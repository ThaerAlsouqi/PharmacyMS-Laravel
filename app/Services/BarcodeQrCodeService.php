<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class BarcodeQrCodeService
{
    protected $barcodeGenerator;

    public function __construct()
    {
        $this->barcodeGenerator = new BarcodeGeneratorPNG();
        
    }

    /**
     * Generate unique barcode for product
     */
    public function generateProductBarcode($productId, $productName)
    {
        // Generate unique barcode: PHM (Pharmacy) + Product ID + Random
        $barcode = 'PHM' . str_pad($productId, 4, '0', STR_PAD_LEFT) . rand(1000, 9999);
        
        // Ensure uniqueness
        while (\App\Models\Purchase::where('barcode', $barcode)->exists()) {
            $barcode = 'PHM' . str_pad($productId, 4, '0', STR_PAD_LEFT) . rand(1000, 9999);
        }

        return $barcode;
    }

    /**
     * Generate barcode image
     */
    public function generateBarcodeImage($code)
    {
        try {
            return $this->barcodeGenerator->getBarcode($code, $this->barcodeGenerator::TYPE_CODE_128);
        } catch (\Exception $e) {
            Log::error('Barcode generation failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Save barcode image to storage
     */
    public function saveBarcodeImage($code, $productName)
    {
        $barcodeImage = $this->generateBarcodeImage($code);
        
        if ($barcodeImage) {
            $filename = 'barcodes/' . Str::slug($productName) . '_' . $code . '.png';
            Storage::disk('public')->put($filename, $barcodeImage);
            return $filename;
        }

        return null;
    }

    /**
     * Generate QR Code for product
     */
    public function generateProductQRCode($product)
    {
        $qrData = [
            'type' => 'product',
            'id' => $product->id,
            'name' => $product->purchase->product ?? 'Unknown',
            'price' => $product->price,
            'barcode' => $product->purchase->barcode ?? null,
            'pharmacy' => config('app.name', 'Pharmacy')
        ];

        return $this->generateQRCodeImage(json_encode($qrData));
    }

    /**
     * Generate QR Code image
     */
    public function generateQRCodeImage($data, $size = 150)
    {
        try {
            return QrCode::format('png')
                         ->size($size)
                         ->margin(2)
                         ->errorCorrection('M')
                         ->generate($data);
        } catch (\Exception $e) {
            Log::error('QR Code generation failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Save QR Code image to storage
     */
    public function saveQRCodeImage($data, $filename, $size = 150)
    {
        $qrImage = $this->generateQRCodeImage($data, $size);
        
        if ($qrImage) {
            $filepath = 'qrcodes/' . $filename . '.png';
            Storage::disk('public')->put($filepath, $qrImage);
            return $filepath;
        }

        return null;
    }

    /**
     * Decode barcode/QR code
     */
    public function decodeBarcode($code)
    {
        // Check if it's a product barcode (starts with PHM)
        if (strpos($code, 'PHM') === 0) {
            return $this->lookupProductByBarcode($code);
        }

        // Check if it's JSON (QR Code)
        $decoded = json_decode($code, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $this->processQRCodeData($decoded);
        }

        // Try to find product by manual search
        return $this->searchProductByCode($code);
    }

    /**
     * Lookup product by barcode
     */
    protected function lookupProductByBarcode($barcode)
    {
        $purchase = \App\Models\Purchase::where('barcode', $barcode)->first();
        
        if ($purchase) {
            $product = \App\Models\Product::where('purchase_id', $purchase->id)->first();
            
            if ($product) {
                return [
                    'success' => true,
                    'type' => 'product',
                    'data' => [
                        'product_id' => $product->id,
                        'name' => $purchase->product,
                        'price' => $product->price,
                        'stock' => $purchase->quantity,
                        'barcode' => $barcode
                    ]
                ];
            }
        }

        return ['success' => false, 'message' => 'Product not found'];
    }

    /**
     * Process QR Code data
     */
    protected function processQRCodeData($data)
    {
        if (!isset($data['type'])) {
            return ['success' => false, 'message' => 'Invalid QR Code'];
        }

        switch ($data['type']) {
            case 'product':
                return [
                    'success' => true,
                    'type' => 'product',
                    'data' => $data
                ];
            
            default:
                return ['success' => false, 'message' => 'Unknown QR Code type'];
        }
    }

    /**
     * Search product by any code
     */
    protected function searchProductByCode($code)
    {
        $purchase = \App\Models\Purchase::where('product', 'LIKE', '%' . $code . '%')->first();

        if ($purchase) {
            $product = \App\Models\Product::where('purchase_id', $purchase->id)->first();
            
            if ($product) {
                return [
                    'success' => true,
                    'type' => 'product',
                    'data' => [
                        'product_id' => $product->id,
                        'name' => $purchase->product,
                        'price' => $product->price,
                        'stock' => $purchase->quantity,
                        'code' => $code
                    ]
                ];
            }
        }

        return ['success' => false, 'message' => 'No product found for: ' . $code];
    }

    /**
     * Log barcode scan
     */
    public function logScan($barcode, $type = 'product', $productId = null, $userId = null)
    {
        try {
            \App\Models\BarcodeScan::create([
                'barcode' => $barcode,
                'scan_type' => $type,
                'product_id' => $productId,
                'user_id' => $userId,
                'scanned_at' => now(),
                'scan_data' => [
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent()
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log barcode scan: ' . $e->getMessage());
        }
    }
}