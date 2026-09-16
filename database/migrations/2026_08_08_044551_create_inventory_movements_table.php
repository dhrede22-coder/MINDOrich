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
    Schema::create('inventory_movements', function (Blueprint $table) {

        $table->id();

        $table->foreignId('product_id')
            ->constrained('products')
            ->cascadeOnDelete();

        $table->foreignId('sale_id')
            ->nullable()
            ->constrained('sales')
            ->nullOnDelete();

        $table->enum('movement_type', [
            'Stock In',
            'Online Sale',
            'Walk-in Sale',
            'Stock Adjustment',
            'Returned',
            'Damaged'
        ]);

        $table->integer('quantity');

        $table->text('remarks')->nullable();

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
