<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->json('customer_info')->nullable(); // Store customer details
            $table->string('payment_method')->nullable();
            $table->timestamp('invoice_date');
            $table->timestamp('due_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('qr_code_path')->nullable(); // Invoice QR code
            $table->timestamps();
        });

        // Add invoice_id to sales table
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('invoice_id')->nullable()->after('id')->constrained('invoices')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['invoice_id']);
            $table->dropColumn('invoice_id');
        });
        
        Schema::dropIfExists('invoices');
    }
};