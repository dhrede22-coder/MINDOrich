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
        Schema::table('sales', function (Blueprint $table) {
    $table->string('gcash_reference')->nullable()->after('payment_status');
    $table->string('gcash_proof')->nullable()->after('gcash_reference');
    $table->timestamp('gcash_verified_at')->nullable()->after('gcash_proof');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('sales', function (Blueprint $table) {
    $table->dropColumn([
        'gcash_reference',
        'gcash_proof',
        'gcash_verified_at',
    ]);
});
    }
};
