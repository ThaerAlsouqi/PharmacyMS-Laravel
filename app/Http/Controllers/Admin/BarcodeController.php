<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BarcodeQrCodeService;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\BarcodeScan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarcodeController extends Controller
{
    protected $barcodeService;

    public function __construct(BarcodeQrCodeService $barcodeService)
    {
        $this->barcodeService = $barcodeService;
        $this->barcodeService = new BarcodeQrCodeService();

    }

    /**
     * Process barcode/QR code scan
     */
    public function scan(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $code = $request->input('code');
        
        // Decode the barcode/QR code
        $result = $this->barcodeService->decodeBarcode($code);
        
        // Log the scan
        if ($result['success'] && isset($result['data']['product_id'])) {
            $this->barcodeService->logScan(
                $code, 
                $result['type'], 
                $result['data']['product_id'], 
                Auth::id()
            );
        }

        return response()->json($result);
    }

    /**
     * Generate barcodes for all products
     */
    public function generateAllBarcodes(Request $request)
    {
        try {
            $products = Product::with('purchase')->get();
            $generated = 0;
            $errors = [];

            foreach ($products as $product) {
                if ($product->purchase && !$product->purchase->barcode) {
                    try {
                        $barcode = $this->barcodeService->generateProductBarcode(
                            $product->id, 
                            $product->purchase->product
                        );

                        $barcodeImagePath = $this->barcodeService->saveBarcodeImage(
                            $barcode, 
                            $product->purchase->product
                        );

                        $product->purchase->update([
                            'barcode' => $barcode,
                            'barcode_data' => [
                                'generated_at' => now(),
                                'image_path' => $barcodeImagePath,
                                'type' => 'CODE_128'
                            ]
                        ]);

                        $generated++;
                    } catch (\Exception $e) {
                        $errors[] = "Product {$product->id}: " . $e->getMessage();
                    }
                }
            }

            return response()->json([
                'success' => true,
                'generated' => $generated,
                'total_products' => $products->count(),
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Batch generation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate QR codes for all products
     */
    public function generateAllQRCodes(Request $request)
    {
        try {
            $products = Product::with('purchase')->get();
            $generated = 0;

            foreach ($products as $product) {
                if (!$product->product_qr_code) {
                    $qrCodePath = $this->barcodeService->saveQRCodeImage(
                        json_encode([
                            'type' => 'product',
                            'id' => $product->id,
                            'name' => $product->purchase->product ?? 'Unknown',
                            'price' => $product->price
                        ]),
                        'product_' . $product->id
                    );

                    if ($qrCodePath) {
                        $product->update(['product_qr_code' => $qrCodePath]);
                        $generated++;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'generated' => $generated,
                'message' => "Generated {$generated} QR codes"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'QR code batch generation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display barcode management page
     */
    public function index()
    {
        $title = 'Barcode Management';
        
        // Get statistics
        $stats = [
            'total_products' => Product::count(),
            'products_with_barcodes' => Purchase::whereNotNull('barcode')->count(),
            'products_with_qr' => Product::whereNotNull('product_qr_code')->count(),
            'total_scans' => BarcodeScan::count(),
        ];

        // Get recent scans
        $recentScans = BarcodeScan::with(['product.purchase', 'user'])
                                 ->orderBy('scanned_at', 'desc')
                                 ->limit(10)
                                 ->get();

        return view('admin.barcode.index', compact('title', 'stats', 'recentScans'));
    }

    /**
     * Print barcodes view
     */
    public function printBarcodes(Request $request)
    {
        $products = Product::with('purchase')
                          ->whereHas('purchase', function($query) {
                              $query->whereNotNull('barcode');
                          })
                          ->get();

        $title = 'Print Barcodes';
        
        return view('admin.barcode.print', compact('title', 'products'));
    }
}