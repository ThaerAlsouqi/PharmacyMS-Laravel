<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add barcode fields to purchases table
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('barcode')->nullable()->unique()->after('image');
            $table->string('qr_code')->nullable()->after('barcode');
            $table->json('barcode_data')->nullable()->after('qr_code');
        });

        // Add QR code fields to products table
        Schema::table('products', function (Blueprint $table) {
            $table->string('product_qr_code')->nullable()->after('description');
            $table->json('qr_data')->nullable()->after('product_qr_code');
        });

        // Add receipt QR code to sales table
        Schema::table('sales', function (Blueprint $table) {
            $table->string('receipt_qr_code')->nullable()->after('total_price');
            $table->string('sale_reference')->nullable()->unique()->after('receipt_qr_code');
        });

        // Create barcode_scans table for tracking scans
        Schema::create('barcode_scans', function (Blueprint $table) {
            $table->id();
            $table->string('barcode');
            $table->string('scan_type')->default('product');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->json('scan_data')->nullable();
            $table->timestamp('scanned_at');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barcode_scans');
        
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['receipt_qr_code', 'sale_reference']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['product_qr_code', 'qr_data']);
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn(['barcode', 'qr_code', 'barcode_data']);
        });
    }
};