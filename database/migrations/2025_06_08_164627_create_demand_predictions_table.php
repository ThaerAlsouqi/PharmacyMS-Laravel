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
        Schema::create('demand_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('drug_name');
            $table->json('recent_sales'); // Store the input sales data
            $table->decimal('predicted_demand', 10, 2);
            $table->decimal('suggested_order', 10, 2);
            $table->enum('confidence', ['high', 'medium', 'low'])->default('medium');
            $table->json('model_info')->nullable(); // Store additional model information
            $table->timestamps();

            // Add indexes for better performance
            $table->index(['drug_name', 'created_at']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demand_predictions');
    }
};