<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ReservationItem;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        
        // Get customer's reservations with items
        $reservations = Reservation::where('customer_id', $customer->id)
                                 ->with(['items.purchase.category'])
                                 ->orderBy('created_at', 'desc')
                                 ->get();
        
        return view('customer.my_reservations', compact('reservations'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array|min:1',
                'items.*.medicine_id' => 'required|exists:purchases,id',
                'items.*.quantity' => 'required|integer|min:1|max:10',
                'pharmacy_name' => 'required|string',
                'pharmacy_address' => 'required|string',
                'pharmacy_phone' => 'required|string',
                'notes' => 'nullable|string|max:500',
            ]);

            $customer = Auth::guard('customer')->user();
            
            DB::beginTransaction();

            // Calculate totals
            $subtotal = 0;
            $validatedItems = [];

            foreach ($request->items as $item) {
                $purchase = Purchase::findOrFail($item['medicine_id']);
                
                // Check stock availability
                if ($purchase->quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$purchase->product}. Available: {$purchase->quantity}");
                }

                $unitPrice = $purchase->product->price ?? $purchase->cost_price;
                $itemSubtotal = $unitPrice * $item['quantity'];
                $subtotal += $itemSubtotal;

                $validatedItems[] = [
                    'purchase' => $purchase,
                    'quantity' => $item['quantity'],
                    'unit_price' => $unitPrice,
                    'subtotal' => $itemSubtotal
                ];
            }

            // Calculate tax (8%)
            $taxAmount = $subtotal * 0.08;
            $totalAmount = $subtotal + $taxAmount;

            // Create reservation
            $reservation = Reservation::create([
                'customer_id' => $customer->id,
                'reservation_number' => Reservation::generateReservationNumber(),
                'status' => 'pending',
                'pharmacy_name' => $request->pharmacy_name,
                'pharmacy_address' => $request->pharmacy_address,
                'pharmacy_phone' => $request->pharmacy_phone,
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
                'payment_method' => 'pay_at_pickup',
                'estimated_pickup_date' => now()->addDays(2),
                'notes' => $request->notes,
            ]);

            // Create reservation items
            foreach ($validatedItems as $item) {
                ReservationItem::create([
                    'reservation_id' => $reservation->id,
                    'purchase_id' => $item['purchase']->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal']
                ]);

                // Optionally reduce stock (uncomment if you want to reserve stock)
                // $item['purchase']->decrement('quantity', $item['quantity']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Reservation created successfully!',
                'reservation_id' => $reservation->id,
                'reservation_number' => $reservation->reservation_number
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $customer = Auth::guard('customer')->user();
        
        $reservation = Reservation::where('customer_id', $customer->id)
                                ->where('id', $id)
                                ->with(['items.purchase.category'])
                                ->firstOrFail();
        
        return view('customer.reservation_details', compact('reservation'));
    }

    public function cancel($id)
    {
        try {
            $customer = Auth::guard('customer')->user();
            
            $reservation = Reservation::where('customer_id', $customer->id)
                                    ->where('id', $id)
                                    ->where('status', '!=', 'completed')
                                    ->firstOrFail();

            // Only allow cancellation if reservation is pending or ready
            if (!in_array($reservation->status, ['pending', 'ready'])) {
                return redirect()->back()->with('error', 'This reservation cannot be cancelled.');
            }

            $reservation->update([
                'status' => 'cancelled',
                'cancellation_reason' => 'Customer request'
            ]);

            // If stock was reserved, restore it
            foreach ($reservation->items as $item) {
                // $item->purchase->increment('quantity', $item->quantity);
            }

            return redirect()->route('customer.my-reservations')
                           ->with('success', 'Reservation cancelled successfully.');
                           
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to cancel reservation: ' . $e->getMessage());
        }
    }

    public function reorder($id)
    {
        try {
            $customer = Auth::guard('customer')->user();
            
            $originalReservation = Reservation::where('customer_id', $customer->id)
                                             ->where('id', $id)
                                             ->with('items.purchase')
                                             ->firstOrFail();

            // Check if all items are still available
            $unavailableItems = [];
            foreach ($originalReservation->items as $item) {
                if ($item->purchase->quantity < $item->quantity) {
                    $unavailableItems[] = $item->purchase->product;
                }
            }

            if (!empty($unavailableItems)) {
                return redirect()->back()->with('error', 'Some items are no longer available: ' . implode(', ', $unavailableItems));
            }

            DB::beginTransaction();

            // Create new reservation
            $newReservation = Reservation::create([
                'customer_id' => $customer->id,
                'reservation_number' => Reservation::generateReservationNumber(),
                'status' => 'pending',
                'pharmacy_name' => $originalReservation->pharmacy_name,
                'pharmacy_address' => $originalReservation->pharmacy_address,
                'pharmacy_phone' => $originalReservation->pharmacy_phone,
                'total_amount' => $originalReservation->total_amount,
                'tax_amount' => $originalReservation->tax_amount,
                'payment_method' => 'pay_at_pickup',
                'estimated_pickup_date' => now()->addDays(2),
                'notes' => 'Reorder from reservation #' . $originalReservation->reservation_number,
            ]);

            // Copy items to new reservation
            foreach ($originalReservation->items as $item) {
                ReservationItem::create([
                    'reservation_id' => $newReservation->id,
                    'purchase_id' => $item->purchase_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'subtotal' => $item->subtotal
                ]);
            }

            DB::commit();

            return redirect()->route('customer.my-reservations')
                           ->with('success', 'Reorder created successfully! Reservation #' . $newReservation->reservation_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to reorder: ' . $e->getMessage());
        }
    }
}