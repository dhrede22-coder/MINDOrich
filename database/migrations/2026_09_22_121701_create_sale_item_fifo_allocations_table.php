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
        Schema::create('sale_item_fifo_allocations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sale_item_id')
                ->constrained('sale_items')
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('purchase_item_id')
                ->constrained('purchase_items')
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->unsignedInteger('quantity');

            $table->decimal('unit_cost', 14, 2);

            $table->decimal('cost_subtotal', 14, 2);

            $table->timestamps();

            $table->unique(['sale_item_id', 'purchase_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_item_fifo_allocations');
    }
};