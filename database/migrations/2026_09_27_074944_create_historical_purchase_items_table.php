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
        Schema::create('historical_purchase_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('historical_purchase_id')
                ->constrained('historical_purchases')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->integer('quantity_in');

            $table->integer('reject_quantity')->default(0);

            $table->integer('good_quantity')->default(0);

            $table->decimal('purchase_price', 12, 2);

            $table->integer('remaining_quantity')->default(0);

            $table->date('received_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historical_purchase_items');
    }
};