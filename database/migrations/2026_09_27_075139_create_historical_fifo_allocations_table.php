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
        Schema::create('historical_fifo_allocations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('historical_sale_item_id')
                ->constrained('historical_sale_items')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('historical_purchase_item_id')
                ->constrained('historical_purchase_items')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->integer('quantity');

            $table->decimal('unit_cost', 12, 2);

            $table->decimal('cost_subtotal', 12, 2);

            $table->timestamps();

            $table->unique(
    [
        'historical_sale_item_id',
        'historical_purchase_item_id'
    ],
    'hist_fifo_alloc_unique'
);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historical_fifo_allocations');
    }
};