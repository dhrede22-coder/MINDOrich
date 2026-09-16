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
     * information and valid ID.
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

            // Customer address
            'address' => [
                'required',
                'string',
                'max:1000',
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

            // Valid ID image
            'id_image' => [
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
        // UPLOAD VALID ID
        // =========================================================

        $idImagePath = null;

        if ($request->hasFile('id_image')) {

            $idImagePath = $request
                ->file('id_image')
                ->store(
                    'customer-verifications',
                    'public'
                );
        }


        // =========================================================
        // UPDATE CUSTOMER VERIFICATION INFORMATION
        // =========================================================

        $user->update([

            'contact_number' => $validated['contact_number'],

            'address' => $validated['address'],

            'id_type' => $validated['id_type'],

            'id_number' => $validated['id_number'],

            'id_image' => $idImagePath,

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