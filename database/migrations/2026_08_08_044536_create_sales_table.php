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
    Schema::create('sales', function (Blueprint $table) {

        $table->id();

        /*
        |--------------------------------------------------------------------------
        | Sale Information
        |--------------------------------------------------------------------------
        */

        $table->string('sale_number')->unique();

        $table->foreignId('user_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

        $table->enum('sale_type', [
            'Online',
            'Walk-in'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Payment
        |--------------------------------------------------------------------------
        */

        $table->enum('payment_method', [
            'COD',
            'GCash',
            'Cash'
        ]);

        $table->enum('payment_status', [
            'Pending',
            'Paid',
            'Failed',
            'Refunded'
        ])->default('Pending');

        /*
        |--------------------------------------------------------------------------
        | Order Status
        |--------------------------------------------------------------------------
        */

        $table->enum('status', [
            'Pending',
            'Confirmed',
            'Processing',
            'Shipped',
            'Delivered',
            'Cancelled',
            'Completed'
        ])->default('Pending');

        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $table->decimal('total_amount', 10, 2);

        $table->text('notes')->nullable();

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
