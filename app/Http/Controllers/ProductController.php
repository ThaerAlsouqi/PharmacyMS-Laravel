<?php

namespace App\Http\Controllers;

use App\Models\Product; // Ensure you have the correct namespace for your Product model
use Illuminate\Support\Facades\Log; // Import the Log facade

class ProductController extends Controller{

    public function getOutstockProducts()
    {
        $products = Product::where('quantity','=',0)->get(['name', 'category', 'price', 'quantity', 'discount']);
        Log::info($products); // Log the data for debugging
        return response()->json(['data' => $products]);
    }
      
}
