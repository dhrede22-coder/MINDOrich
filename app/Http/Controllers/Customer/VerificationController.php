<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /**
     * ============================================================
     * SHOW CUSTOMER VERIFICATION FORM
     * ============================================================
     *
     * This page will be shown when a customer needs
     * to verify their account before placing an order.
     */
    public function create()
    {
        // Get currently logged-in customer
        $user = Auth::user();

        return view(
            'customer.verification.create',
            compact('user')
        );
    }


    /**
     * ============================================================
     * SUBMIT CUSTOMER VERIFICATION
     * ============================================================
     *
     * This method receives the customer's verification
     * information, delivery information, and valid ID images.
     */
    public function store(Request $request)
    {
        // =========================================================
        // VALIDATE CUSTOMER INFORMATION
        // =========================================================

        $validated = $request->validate([

            // Customer contact information
            'contact_number' => [
                'required',
                'string',
                'max:30',
            ],

            // Delivery information
            'house_street' => [
                'required',
                'string',
                'max:255',
            ],

            'barangay' => [
                'required',
                'string',
                'max:255',
            ],

            'municipality_city' => [
                'required',
                'string',
                'max:255',
            ],

            'province' => [
                'required',
                'string',
                'max:255',
            ],

            'postal_code' => [
                'required',
                'string',
                'max:20',
            ],

            'landmark' => [
                'nullable',
                'string',
                'max:255',
            ],

            // Type of valid ID
            'id_type' => [
                'required',
                'string',
                'max:100',
            ],

            // ID number
            'id_number' => [
                'required',
                'string',
                'max:100',
            ],

            // Front of valid ID
            'id_front_image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            // Back of valid ID
            'id_back_image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);


        // =========================================================
        // GET CURRENT USER
        // =========================================================

        $user = Auth::user();


        // =========================================================
        // BUILD LEGACY ADDRESS FIELD
        // =========================================================
        //
        // Keep the existing "address" field for compatibility
        // with existing customer/admin pages and old records.
        //

        $addressParts = [
            $validated['house_street'],
            $validated['barangay'],
            $validated['municipality_city'],
            $validated['province'],
            $validated['postal_code'],
        ];

        if (!empty($validated['landmark'])) {
            $addressParts[] = 'Landmark: ' . $validated['landmark'];
        }

        $completeAddress = implode(', ', $addressParts);


        // =========================================================
        // UPLOAD FRONT ID
        // =========================================================

        $idFrontImagePath = $request
            ->file('id_front_image')
            ->store(
                'customer-verifications',
                'public'
            );


        // =========================================================
        // UPLOAD BACK ID
        // =========================================================

        $idBackImagePath = $request
            ->file('id_back_image')
            ->store(
                'customer-verifications',
                'public'
            );


        // =========================================================
        // UPDATE CUSTOMER VERIFICATION INFORMATION
        // =========================================================

        $user->update([

            // Contact
            'contact_number' => $validated['contact_number'],

            // Keep old address field populated for compatibility
            'address' => $completeAddress,

            // Structured delivery information
            'house_street' => $validated['house_street'],
            'barangay' => $validated['barangay'],
            'municipality_city' => $validated['municipality_city'],
            'province' => $validated['province'],
            'postal_code' => $validated['postal_code'],
            'landmark' => $validated['landmark'] ?? null,

            // ID information
            'id_type' => $validated['id_type'],
            'id_number' => $validated['id_number'],

            // New front/back ID images
            'id_front_image' => $idFrontImagePath,
            'id_back_image' => $idBackImagePath,

            // Keep old ID field populated for compatibility
            'id_image' => $idFrontImagePath,

            // IMPORTANT:
            // Customer is NOT approved yet.
            'verification_status' => 'Under Review',

            // Remove old verification date
            // because admin has not approved this yet.
            'verified_at' => null,

            // Clear previous rejection message
            'verification_notes' => null,
        ]);


        // =========================================================
        // REDIRECT AFTER SUBMISSION
        // =========================================================

        return redirect()
            ->route('customer.verification.create')
            ->with(
                'success',
                'Your verification has been submitted successfully. Please wait for admin approval.'
            );
    }
}