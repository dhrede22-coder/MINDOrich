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
        Schema::create('historical_purchases', function (Blueprint $table) {
            $table->id();

            $table->string('purchase_number')->unique();

            $table->foreignId('producer_id')
                ->constrained('producers')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->date('purchase_date');

            $table->string('status')->default('Completed');

            $table->decimal('total_purchase_cost', 12, 2)->default(0);

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historical_purchases');
    }
};