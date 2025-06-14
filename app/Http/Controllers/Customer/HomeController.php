<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get popular medicines (medicines with good ratings or frequently purchased)
        $popularMedicines = [
            [
                'name' => 'Paracetamol 500mg',
                'category' => 'Pain Relief',
                'image' => 'images/paracetamol.jpg'
            ],
            [
                'name' => 'Vitamin C Complex',
                'category' => 'Vitamins',
                'image' => 'images/vitamin-c.jpg'
            ],
            [
                'name' => 'Ibuprofen 200mg',
                'category' => 'Anti-inflammatory',
                'image' => 'images/ibuprofen.jpg'
            ],
            [
                'name' => 'Loratadine 10mg',
                'category' => 'Antihistamine',
                'image' => 'images/loratadine.jpg'
            ],
        ];

        return view('customer.home', compact('popularMedicines'));
    }

    public function medicines(Request $request)
    {
        // Build query for medicines (using Purchase model since it contains medicine data)
        $query = Purchase::with(['category', 'supplier', 'product']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where('product', 'LIKE', "%{$searchTerm}%");
        }

        // Category filter
        if ($request->has('categories') && !empty($request->categories)) {
            $query->whereHas('category', function($q) use ($request) {
                $q->whereIn('name', $request->categories);
            });
        }

        // Price range filter
        if ($request->has('min_price') && $request->min_price) {
            $query->where('cost_price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->where('cost_price', '<=', $request->max_price);
        }

        // Availability filter
        if ($request->has('availability')) {
            switch ($request->availability) {
                case 'in-stock':
                    $query->where('quantity', '>', 0);
                    break;
                case 'prescription':
                    // Add logic for prescription medicines if you have that field
                    break;
            }
        }

        // Get medicines with pagination (show all medicines, not just in stock)
        $medicines = $query->orderBy('created_at', 'desc')->paginate(12);

        // Get categories for filter
        $categories = Category::all();

        return view('customer.medicines', compact('medicines', 'categories'));
    }

    public function symptomChecker()
    {
        $commonSymptoms = [
            'Headache',
            'Fever',
            'Cough',
            'Sore Throat',
            'Runny Nose',
            'Body Aches',
            'Nausea',
            'Fatigue',
            'Muscle Pain',
            'Joint Pain',
            'Stomach Pain',
            'Diarrhea'
        ];

        return view('customer.symptom-checker', compact('commonSymptoms'));
    }

    public function searchMedicines(Request $request)
    {
        $searchTerm = $request->get('q', '');
        
        if (empty($searchTerm)) {
            return response()->json([]);
        }

        $medicines = Purchase::where('product', 'LIKE', "%{$searchTerm}%")
                            ->where('quantity', '>', 0)
                            ->with(['category', 'product'])
                            ->limit(10)
                            ->get()
                            ->map(function($medicine) {
                                return [
                                    'id' => $medicine->id,
                                    'name' => $medicine->product,
                                    'category' => $medicine->category->name ?? 'Unknown',
                                    'price' => $medicine->product->price ?? $medicine->cost_price,
                                    'image' => $medicine->image ?? 'images/default-medicine.jpg',
                                    'stock' => $medicine->quantity,
                                    'expiry_date' => $medicine->expiry_date
                                ];
                            });

        return response()->json($medicines);
    }
}