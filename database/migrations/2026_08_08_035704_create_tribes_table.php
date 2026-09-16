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
    Schema::create('tribes', function (Blueprint $table) {

        $table->id();

        $table->string('tribe_name')->unique();

        $table->string('cover_image')->nullable();

        $table->text('description');

        $table->longText('history')->nullable();

        $table->string('location');

        $table->string('language')->nullable();

        $table->enum('status', ['Active', 'Inactive'])
              ->default('Active');

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tribes');
    }
};
