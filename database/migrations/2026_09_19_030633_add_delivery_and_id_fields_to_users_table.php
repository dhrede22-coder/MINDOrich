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
        Schema::table('users', function (Blueprint $table) {

            // Structured delivery address
            $table->string('house_street')->nullable()->after('address');
            $table->string('barangay')->nullable()->after('house_street');
            $table->string('municipality_city')->nullable()->after('barangay');
            $table->string('province')->nullable()->after('municipality_city');
            $table->string('postal_code')->nullable()->after('province');
            $table->string('landmark')->nullable()->after('postal_code');

            // Front and back images of valid ID
            $table->string('id_front_image')->nullable()->after('id_image');
            $table->string('id_back_image')->nullable()->after('id_front_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'house_street',
                'barangay',
                'municipality_city',
                'province',
                'postal_code',
                'landmark',
                'id_front_image',
                'id_back_image',
            ]);
        });
    }
};