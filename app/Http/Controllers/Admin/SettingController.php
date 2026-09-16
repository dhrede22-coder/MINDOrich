<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key');

        return view('admin.settings.index', compact('settings'));
    }

    public function updateGcashQr(Request $request)
{
    $request->validate([
        'gcash_qr_code' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $path = $request->file('gcash_qr_code')->store(
        'settings',
        'public'
    );

    Setting::updateOrCreate(
        ['key' => 'gcash_qr_code'],
        ['value' => $path]
    );

    return back()->with(
        'success',
        'GCash QR Code updated successfully.'
    );
}
}