<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ============================================================
     * ADD CUSTOMER VERIFICATION FIELDS TO USERS TABLE
     * ============================================================
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // =====================================================
            // CUSTOMER CONTACT INFORMATION
            // =====================================================

            $table->string('contact_number')
                ->nullable()
                ->after('email');


            // =====================================================
            // CUSTOMER ADDRESS
            // =====================================================

            $table->text('address')
                ->nullable()
                ->after('contact_number');


            // =====================================================
            // VERIFICATION INFORMATION
            // =====================================================

            // Example:
            // National ID, Driver's License, Passport, etc.
            $table->string('id_type')
                ->nullable()
                ->after('address');

            // ID number submitted by the customer
            $table->string('id_number')
                ->nullable()
                ->after('id_type');

            // Uploaded image/file of the valid ID
            $table->string('id_image')
                ->nullable()
                ->after('id_number');


            // =====================================================
            // VERIFICATION STATUS
            // =====================================================

            /*
             * Pending:
             * Customer has not completed verification yet.
             *
             * Under Review:
             * Customer submitted verification and admin
             * needs to review it.
             *
             * Approved:
             * Customer is allowed to place orders.
             *
             * Rejected:
             * Admin rejected the submitted verification.
             */
            $table->enum('verification_status', [
                'Pending',
                'Under Review',
                'Approved',
                'Rejected'
            ])
            ->default('Pending')
            ->after('id_image');


            // =====================================================
            // VERIFICATION DATE
            // =====================================================

            $table->timestamp('verified_at')
                ->nullable()
                ->after('verification_status');


            // =====================================================
            // ADMIN REJECTION REASON
            // =====================================================

            /*
             * This will only be filled when the admin
             * rejects the customer's verification.
             */
            $table->text('verification_notes')
                ->nullable()
                ->after('verified_at');

        });
    }


    /**
     * ============================================================
     * REMOVE CUSTOMER VERIFICATION FIELDS
     * ============================================================
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'contact_number',
                'address',
                'id_type',
                'id_number',
                'id_image',
                'verification_status',
                'verified_at',
                'verification_notes',
            ]);

        });
    }
};