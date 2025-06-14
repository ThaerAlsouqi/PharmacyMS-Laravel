<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade'); // Links to customers table
            $table->string('reservation_number')->unique();
            $table->enum('status', ['pending', 'ready', 'completed', 'cancelled'])->default('pending');
            $table->string('pharmacy_name');
            $table->text('pharmacy_address');
            $table->string('pharmacy_phone');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->string('payment_method')->default('pay_at_pickup');
            $table->timestamp('estimated_pickup_date')->nullable();
            $table->timestamp('actual_pickup_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index(['customer_id', 'status']);
            $table->index('reservation_number');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};