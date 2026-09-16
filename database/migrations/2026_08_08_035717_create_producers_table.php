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
    Schema::create('producers', function (Blueprint $table) {

        $table->id();

        // Relationship
        $table->foreignId('tribe_id')
              ->constrained('tribes')
              ->cascadeOnUpdate()
              ->restrictOnDelete();

        // Basic Information
        $table->string('producer_name');
        $table->string('photo')->nullable();

        // Personal Information
        $table->enum('gender', ['Male', 'Female']);
        $table->date('birthdate')->nullable();

        // Contact Information
        $table->string('contact_number', 20)->nullable();
        $table->text('address');

        // Producer Profile
        $table->text('biography')->nullable();
        $table->string('specialization')->nullable();
        $table->integer('years_of_experience')->default(0);

        // Status
        $table->enum('status', [
            'Active',
            'Inactive'
        ])->default('Active');

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producers');
    }
};
