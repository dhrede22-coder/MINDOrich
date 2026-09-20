<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(Request $request): View
    {
        return view('customer.settings', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'order_notifications' => ['required', 'boolean'],
            'product_notifications' => ['required', 'boolean'],
        ]);

        $request->user()->update($validated);

        return redirect()
            ->route('customer.settings')
            ->with('success', 'Notification settings updated successfully.');
    }
}