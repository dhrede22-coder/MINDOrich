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
        Schema::create('historical_sales', function (Blueprint $table) {
            $table->id();

            $table->date('sales_date');

            $table->string('or_number')->nullable();

            $table->string('customer_name')->nullable();

            $table->string('sale_type');

            $table->string('payment_method');

            $table->decimal('total_amount', 12, 2)->default(0);

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historical_sales');
    }
};