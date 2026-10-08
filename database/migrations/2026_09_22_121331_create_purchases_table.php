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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            $table->string('purchase_number', 50)->unique();

            $table->foreignId('producer_id')
                ->constrained('producers')
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->date('purchase_date');

            $table->enum('status', [
                'Pending',
                'Completed',
                'Cancelled',
            ])->default('Pending');

            $table->decimal('total_purchase_cost', 14, 2)->default(0);

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};