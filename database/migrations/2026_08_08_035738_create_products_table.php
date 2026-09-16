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
    Schema::create('products', function (Blueprint $table) {

        $table->id();

        /*
        |--------------------------------------------------------------------------
        | Relationships
        |--------------------------------------------------------------------------
        */

        $table->foreignId('producer_id')
            ->constrained('producers')
            ->cascadeOnUpdate()
            ->restrictOnDelete();

        $table->foreignId('category_id')
            ->constrained('categories')
            ->cascadeOnUpdate()
            ->restrictOnDelete();

        /*
        |--------------------------------------------------------------------------
        | Product Information
        |--------------------------------------------------------------------------
        */

        $table->string('product_name');

        $table->text('description')->nullable();

        $table->decimal('price', 10, 2);

        /*
        |--------------------------------------------------------------------------
        | Inventory
        |--------------------------------------------------------------------------
        */

        $table->unsignedInteger('stock')->default(0);

        $table->unsignedInteger('minimum_stock')->default(5);

        /*
        |--------------------------------------------------------------------------
        | Images
        |--------------------------------------------------------------------------
        */

        $table->string('featured_image')->nullable();

        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        $table->enum('status', [
            'Available',
            'Out of Stock',
            'Archived'
        ])->default('Available');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
