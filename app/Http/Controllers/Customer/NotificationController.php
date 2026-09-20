<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(Request $request, string $notificationId)
{
    $notification = $request->user()
        ->notifications()
        ->whereKey($notificationId)
        ->firstOrFail();

    $notification->markAsRead();

    $type = $notification->data['type'] ?? 'order';

    if ($type === 'verification') {
        return redirect()->route('customer.verification.create');
    }

    if ($type === 'product') {
        return redirect()->route(
            'customer.product.show',
            $notification->data['product_id']
        );
    }

    return redirect()->route(
        'customer.order.show',
        $notification->data['sale_id']
    );
}
}