<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('order_notifications')
                ->default(true)
                ->after('verification_notes');

            $table->boolean('product_notifications')
                ->default(true)
                ->after('order_notifications');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'order_notifications',
                'product_notifications',
            ]);
        });
    }
};