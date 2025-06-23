<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Purchase; // Add this import
use App\Services\BarcodeQrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    protected $barcodeService;

    public function __construct(BarcodeQrCodeService $barcodeService)
    {
        $this->barcodeService = $barcodeService;
    }

    /**
     * Display invoice list
     */
    public function index()
    {
        $title = 'Invoices';
        $invoices = Invoice::with('sales.product.purchase')
                          ->orderBy('created_at', 'desc')
                          ->paginate(20);

        $stats = [
            'total_invoices' => Invoice::count(),
            'pending_invoices' => Invoice::pending()->count(),
            'paid_invoices' => Invoice::paid()->count(),
            'total_revenue' => Invoice::paid()->sum('total_amount'),
        ];

        return view('admin.invoices.index', compact('title', 'invoices', 'stats'));
    }

    /**
     * Create new invoice
     */
    public function create()
    {
        $title = 'Create Invoice';
        $products = Product::with('purchase')->get();
        
        return view('admin.invoices.create', compact('title', 'products'));
    }

    /**
     * Store new invoice with STOCK DEDUCTION
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_address' => 'nullable|string|max:500',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'payment_method' => 'nullable|string',
            'notes' => 'nullable|string|max:1000'
        ]);

        DB::beginTransaction();
        try {
            // 🔍 STEP 1: Validate stock availability FIRST
            foreach ($request->products as $item) {
                $product = Product::with('purchase')->find($item['product_id']);
                
                if (!$product || !$product->purchase) {
                    throw new \Exception("Product with ID {$item['product_id']} not found or has no purchase record.");
                }
                
                $availableStock = $product->purchase->quantity;
                $requestedQty = $item['quantity'];
                
                if ($availableStock < $requestedQty) {
                    throw new \Exception("Insufficient stock for {$product->purchase->product}. Available: {$availableStock}, Requested: {$requestedQty}");
                }
            }

            // 🧮 STEP 2: Calculate totals
            $subtotal = 0;
            $salesData = [];

            foreach ($request->products as $item) {
                $product = Product::find($item['product_id']);
                $itemTotal = $product->price * $item['quantity'];
                $subtotal += $itemTotal;

                $salesData[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'total_price' => $itemTotal,
                ];
            }

            $taxAmount = $subtotal * ($request->tax_rate ?? 0) / 100;
            $discountAmount = $request->discount_amount ?? 0;
            $totalAmount = $subtotal + $taxAmount - $discountAmount;

            // 📄 STEP 3: Create invoice
            $invoice = Invoice::create([
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'customer_info' => [
                    'name' => $request->customer_name ?: 'Walk-in Customer',
                    'phone' => $request->customer_phone,
                    'address' => $request->customer_address,
                ],
                'payment_method' => $request->payment_method ?: 'cash',
                'invoice_date' => now(),
                'due_date' => now()->addDays(30),
                'notes' => $request->notes,
                'status' => ($request->ajax() || $request->wantsJson()) ? 'paid' : 'pending'
            ]);

            // 🛒 STEP 4: Create sales records AND deduct stock
            foreach ($salesData as $saleData) {
                $saleData['invoice_id'] = $invoice->id;
                Sale::create($saleData);

                // 🔥 CRITICAL: Deduct stock from purchases table
                $product = Product::with('purchase')->find($saleData['product_id']);
                if ($product && $product->purchase) {
                    $purchase = $product->purchase;
                    $newQuantity = $purchase->quantity - $saleData['quantity'];
                    
                    // Update purchase quantity
                    $purchase->update(['quantity' => max(0, $newQuantity)]);
                    
                    Log::info("Stock updated for {$purchase->product}: {$purchase->quantity} -> {$newQuantity}");
                }
            }

            // 📱 STEP 5: Generate QR code for invoice
            $qrData = [
                'type' => 'invoice',
                'invoice_number' => $invoice->invoice_number,
                'total' => $invoice->total_amount,
                'date' => $invoice->invoice_date->format('Y-m-d'),
                'pharmacy' => config('app.name')
            ];

            $qrPath = $this->barcodeService->saveQRCodeImage(
                json_encode($qrData),
                'invoice_' . $invoice->invoice_number
            );

            $invoice->update(['qr_code_path' => $qrPath]);

            DB::commit();

            // ✅ STEP 6: Return response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Invoice created successfully! Stock has been updated.',
                    'invoice_number' => $invoice->invoice_number,
                    'invoice_id' => $invoice->id,
                    'total_amount' => $invoice->total_amount,
                    'print_url' => route('admin.invoices.print', $invoice)
                ]);
            }

            return redirect()->route('admin.invoices.show', $invoice)
                           ->with('success', 'Invoice created successfully! Stock has been updated.');

        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Invoice creation failed: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create invoice: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withErrors(['error' => 'Failed to create invoice: ' . $e->getMessage()]);
        }
    }

    /**
     * Display specific invoice
     */
    public function show(Invoice $invoice)
    {
        $title = 'Invoice #' . $invoice->invoice_number;
        $invoice->load('sales.product.purchase');
        
        return view('admin.invoices.show', compact('title', 'invoice'));
    }

    /**
     * Mark invoice as paid
     */
    public function markAsPaid(Invoice $invoice)
    {
        $invoice->update(['status' => 'paid']);
        
        return back()->with('success', 'Invoice marked as paid!');
    }

    /**
     * Print invoice
     */
    public function print(Invoice $invoice)
    {
        $title = 'Print Invoice';
        $invoice->load('sales.product.purchase');
        
        return view('admin.invoices.print', compact('title', 'invoice'));
    }

    /**
     * Convert existing sales to invoices
     */
    public function convertSalesToInvoices()
    {
        DB::beginTransaction();
        try {
            // Get sales without invoices, grouped by date
            $salesWithoutInvoices = Sale::whereNull('invoice_id')
                                      ->with('product.purchase')
                                      ->get()
                                      ->groupBy(function($sale) {
                                          return $sale->created_at->format('Y-m-d H:i');
                                      });

            $convertedCount = 0;

            foreach ($salesWithoutInvoices as $dateGroup => $sales) {
                if ($sales->count() > 0) {
                    // Calculate totals for this group
                    $subtotal = $sales->sum('total_price');
                    
                    // Create invoice for this group
                    $invoice = Invoice::create([
                        'invoice_number' => Invoice::generateInvoiceNumber(),
                        'subtotal' => $subtotal,
                        'tax_amount' => 0,
                        'discount_amount' => 0,
                        'total_amount' => $subtotal,
                        'customer_info' => ['name' => 'Walk-in Customer'],
                        'invoice_date' => $sales->first()->created_at,
                        'status' => 'paid' // Assume old sales are paid
                    ]);

                    // Update sales with invoice_id
                    Sale::whereIn('id', $sales->pluck('id'))
                        ->update(['invoice_id' => $invoice->id]);

                    $convertedCount++;
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Converted {$convertedCount} sales groups to invoices"
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Conversion failed: ' . $e->getMessage()
            ], 500);
        }
    }
}