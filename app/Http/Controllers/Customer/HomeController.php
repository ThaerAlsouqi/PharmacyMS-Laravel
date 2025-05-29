<?php

namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Popular medicines data
        $popularMedicines = [
            ['id' => 1, 'name' => 'Paracetamol', 'category' => 'Pain Relief', 'image' => 'images/placeholder.jpg'],
            ['id' => 2, 'name' => 'Amoxicillin', 'category' => 'Antibiotics', 'image' => 'images/placeholder.jpg'],
            ['id' => 3, 'name' => 'Ibuprofen', 'category' => 'Anti-inflammatory', 'image' => 'images/placeholder.jpg'],
            ['id' => 4, 'name' => 'Loratadine', 'category' => 'Antihistamine', 'image' => 'images/placeholder.jpg'],
        ];

        return view('customer.home', compact('popularMedicines'));
    }

    public function medicines(Request $request)
    {
        // In a real application, you would fetch medicines from the database
        // and apply filters based on request parameters

        // Example of how you might handle search and filters:
        $search = $request->input('search');
        $categories = $request->input('categories', []);
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $availability = $request->input('availability', 'all');
        $rating = $request->input('rating', 'any');

        // For now, we'll just return the view without real data filtering
        return view('customer.medicines');
    }

    public function symptomChecker()
    {
        $commonSymptoms = [
            'Headache', 'Fever', 'Cough', 'Sore Throat', 'Runny Nose', 
            'Body Aches', 'Fatigue', 'Nausea', 'Dizziness', 'Shortness of Breath'
        ];

        return view('customer.symptom-checker', compact('commonSymptoms'));
    }
}