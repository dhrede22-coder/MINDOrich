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
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('purchase_id')
                ->constrained('purchases')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained('products')
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->unsignedInteger('quantity_in');

            $table->unsignedInteger('reject_quantity')->default(0);

            $table->unsignedInteger('good_quantity')->default(0);

            $table->decimal('purchase_price', 14, 2);

            $table->unsignedInteger('remaining_quantity')->default(0);

            $table->date('received_at');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};