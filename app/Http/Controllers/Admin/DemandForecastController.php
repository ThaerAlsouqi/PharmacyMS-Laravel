<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\DemandPrediction;
use App\Models\Sale;
use Carbon\Carbon;

class DemandForecastController extends Controller
{
    private $apiUrl = 'http://127.0.0.1:5001';

    public function index()
    {
        $title = 'demand-forecasting';
        
        try {
            // Check if API is running
            $health = $this->checkApiHealth();
            
            if (!$health['status']) {
                return view('admin.demand-forecast.index', compact('title'))
                    ->with('error', 'AI Model API is not running. Please start the prediction service.');
            }

            // Get available drugs from the API
            $availableDrugs = $this->getAvailableDrugs();
            
            // Get recent predictions from database
            $recentPredictions = DemandPrediction::with(['user'])
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            return view('admin.demand-forecast.index', compact('title', 'availableDrugs', 'recentPredictions', 'health'));
            
        } catch (\Exception $e) {
            Log::error('Demand Forecast Index Error: ' . $e->getMessage());
            return view('admin.demand-forecast.index', compact('title'))
                ->with('error', 'Unable to connect to AI prediction service.');
        }
    }

    public function predict(Request $request)
    {
        $request->validate([
            'drug_name' => 'required|string',
            'recent_sales' => 'required|array|min:3',
            'recent_sales.*' => 'required|numeric|min:0'
        ]);

        try {
            // Make prediction request to Flask API
            $response = Http::timeout(10)->post($this->apiUrl . '/predict', [
                'drug_name' => $request->drug_name,
                'recent_sales' => array_map('floatval', $request->recent_sales)
            ]);

            if ($response->successful()) {
                $prediction = $response->json();
                
                // Save prediction to database
                DemandPrediction::create([
                    'user_id' => auth()->id(),
                    'drug_name' => $prediction['drug_name'],
                    'recent_sales' => $prediction['recent_sales'],
                    'predicted_demand' => $prediction['predicted_demand'],
                    'suggested_order' => $prediction['suggested_order'],
                    'confidence' => $prediction['confidence'],
                    'model_info' => $prediction['model_info']
                ]);

                return response()->json([
                    'success' => true,
                    'prediction' => $prediction
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Prediction API returned an error: ' . $response->body()
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Prediction Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Unable to connect to prediction service'
            ], 500);
        }
    }

    public function batchPredict(Request $request)
    {
        $request->validate([
            'drugs' => 'required|array',
            'drugs.*.drug_name' => 'required|string',
            'drugs.*.recent_sales' => 'required|array|min:3',
            'drugs.*.recent_sales.*' => 'required|numeric|min:0'
        ]);

        try {
            $response = Http::timeout(30)->post($this->apiUrl . '/batch_predict', [
                'drugs' => $request->drugs
            ]);

            if ($response->successful()) {
                $predictions = $response->json()['predictions'];
                
                // Save all predictions to database
                foreach ($predictions as $prediction) {
                    DemandPrediction::create([
                        'user_id' => auth()->id(),
                        'drug_name' => $prediction['drug_name'],
                        'recent_sales' => [], // Will be filled from request
                        'predicted_demand' => $prediction['predicted_demand'],
                        'suggested_order' => $prediction['suggested_order'],
                        'confidence' => 'medium',
                        'model_info' => ['batch_prediction' => true]
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'predictions' => $predictions
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Batch prediction failed'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Batch Prediction Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Unable to connect to prediction service'
            ], 500);
        }
    }

    public function getHistoricalSales(Request $request)
    {
        $drugName = $request->get('drug_name');
        $weeks = $request->get('weeks', 12);

        try {
            // Get historical sales data from your sales table
            // This is a simplified example - adjust based on your actual sales table structure
            $sales = Sale::where('product', 'LIKE', '%' . $drugName . '%')
                ->orderBy('created_at', 'desc')
                ->take($weeks)
                ->get()
                ->groupBy(function($date) {
                    return Carbon::parse($date->created_at)->format('Y-W');
                })
                ->map(function($week) {
                    return $week->sum('quantity');
                })
                ->values()
                ->reverse()
                ->toArray();

            return response()->json([
                'success' => true,
                'sales' => $sales,
                'weeks' => count($sales)
            ]);
        } catch (\Exception $e) {
            Log::error('Historical Sales Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Unable to fetch historical sales data'
            ], 500);
        }
    }

    private function checkApiHealth()
    {
        try {
            $response = Http::timeout(5)->get($this->apiUrl . '/health');
            return $response->successful() ? $response->json() : ['status' => false];
        } catch (\Exception $e) {
            return ['status' => false, 'error' => $e->getMessage()];
        }
    }

    private function getAvailableDrugs()
    {
        try {
            $response = Http::timeout(5)->get($this->apiUrl . '/drugs');
            return $response->successful() ? $response->json()['drugs'] : [];
        } catch (\Exception $e) {
            Log::error('Get Available Drugs Error: ' . $e->getMessage());
            return [];
        }
    }

    public function history()
    {
        $title = 'prediction-history';
        
        $predictions = DemandPrediction::with(['user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.demand-forecast.history', compact('title', 'predictions'));
    }

    public function deletePrediction(DemandPrediction $prediction)
    {
        try {
            $prediction->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}