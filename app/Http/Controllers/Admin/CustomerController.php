<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Sale;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * ============================================================
     * CUSTOMER LIST
     * ============================================================
     *
     * Displays:
     * - Walk-in Customers
     * - Online Customers
     */
   public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | ONLINE CUSTOMERS
        |--------------------------------------------------------------------------
        |
        | Get users whose role is Customer.
        |
        */
        $onlineCustomers = User::whereHas('role', function ($query) {
    $query->where('name', 'Customer');
})
->latest()
->when(
    !$request->boolean('online_all'),
    fn ($query) => $query->limit(20)
)
->get();


        /*
        |--------------------------------------------------------------------------
        | WALK-IN CUSTOMERS
        |--------------------------------------------------------------------------
        |
        | Walk-in transactions are stored in the sales table
        | with sale_type = "Walk-in".
        |
        */
        $walkInCustomers = Sale::with([
    'saleItems.product',
])
->where('sale_type', 'Walk-in')
->latest()
->when(
    !$request->boolean('walkin_all'),
    fn ($query) => $query->limit(20)
)
->get();

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER COUNTS
        |--------------------------------------------------------------------------
        */
        $onlineCount = $onlineCustomers->count();

        $walkInCount = $walkInCustomers->count();


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER PAGE
        |--------------------------------------------------------------------------
        */
        return view(
            'admin.customers.index',
            compact(
                'onlineCustomers',
                'walkInCustomers',
                'onlineCount',
                'walkInCount'
            )
        );
    }


    /**
     * ============================================================
     * VIEW CUSTOMER
     * ============================================================
     *
     * Displays the complete information of an online customer.
     */
    public function show(User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | MAKE SURE THE USER IS A CUSTOMER
        |--------------------------------------------------------------------------
        */
        if (!$user->role || $user->role->name !== 'Customer') {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | GET CUSTOMER ORDERS
        |--------------------------------------------------------------------------
        |
        | This will allow the admin to see the customer's
        | previous online orders.
        |
        */
        $orders = Sale::with([
            'saleItems.product',
        ])
        ->where('user_id', $user->id)
        ->latest()
        ->get();


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER DETAILS PAGE
        |--------------------------------------------------------------------------
        */
        return view(
            'admin.customers.show',
            compact(
                'user',
                'orders'
            )
        );
    }


    /**
     * ============================================================
     * APPROVE CUSTOMER
     * ============================================================
     *
     * Approves the customer's submitted verification.
     */
    public function approve(User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | MAKE SURE THE USER IS A CUSTOMER
        |--------------------------------------------------------------------------
        */
        if (!$user->role || $user->role->name !== 'Customer') {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | APPROVE VERIFICATION
        |--------------------------------------------------------------------------
        */
        $user->update([
            'verification_status' => 'Approved',
            'verified_at' => now(),
            'verification_notes' => null,
        ]);
        $user->notify(
    new \App\Notifications\CustomerNotification(
        'Account Verified',
        'Your account has been approved and verified. You can now place orders.',
        'verification'
    )
);


        /*
        |--------------------------------------------------------------------------
        | RETURN TO CUSTOMER DETAILS
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('admin.customers.show', $user)
            ->with(
                'success',
                'Customer account has been approved successfully.'
            );
    }


    /**
     * ============================================================
     * REJECT CUSTOMER
     * ============================================================
     *
     * Rejects the customer's verification.
     */
    public function reject(Request $request, User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | MAKE SURE THE USER IS A CUSTOMER
        |--------------------------------------------------------------------------
        */
        if (!$user->role || $user->role->name !== 'Customer') {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATE REJECTION REASON
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate([
            'verification_notes' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | REJECT VERIFICATION
        |--------------------------------------------------------------------------
        */
        $user->update([
            'verification_status' => 'Rejected',
            'verified_at' => null,
            'verification_notes' => $validated['verification_notes'],
        ]);
        $user->notify(
    new \App\Notifications\CustomerNotification(
        'Account Verification Rejected',
        'Your account verification was rejected. Please check the verification notes and submit your information again.',
        'verification'
    )
);


        /*
        |--------------------------------------------------------------------------
        | RETURN TO CUSTOMER DETAILS
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('admin.customers.show', $user)
            ->with(
                'success',
                'Customer verification has been rejected.'
            );
    }
}