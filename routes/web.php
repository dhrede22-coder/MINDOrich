<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Admin\ProducerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Customer\ShopController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Customer\NotificationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Customer\SettingsController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\Customer\FavoriteController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Public\HomeController;
use App\Models\Tribe;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\HistoricalPurchaseController;
use App\Http\Controllers\Admin\HistoricalSaleController;

// ================================================================
// CUSTOMER VERIFICATION CONTROLLER
// ================================================================
// Handles customer account verification before they can place
// an online order.
use App\Http\Controllers\Customer\VerificationController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;



/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index']);

Route::get('/about', function () {
    return view('public.about');
})->name('public.about');

Route::get('/tribes', function () {
    $tribes = Tribe::where('status', 'Active')
        ->orderBy('tribe_name')
        ->get();

    return view('public.tribes', compact('tribes'));
})->name('public.tribes');

Route::get('/marketplace', function () {
    return view('public.marketplace');
})->name('public.marketplace');

Route::get('/contact', function () {
    return view('public.contact');
})->name('public.contact');


/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/dashboard', function () {

    $roleName = auth()->user()->role?->name;

    if ($roleName === 'Admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($roleName === 'Customer') {
        return redirect()->route('customer.dashboard');
    }

    abort(403, 'Unauthorized Access.');

})->name('dashboard');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    // ============================================================
    // ADMIN DASHBOARD
    // ============================================================

    Route::get(
        '/admin/dashboard',
        [AdminDashboardController::class, 'index']
    )->name('admin.dashboard');


    // ============================================================
    // PRODUCERS
    // ============================================================

    Route::resource(
        'admin/producers',
        ProducerController::class
    );


    // ============================================================
    // PRODUCTS
    // ============================================================

    Route::resource(
        'admin/products',
        ProductController::class
    );

    Route::resource(
        'admin/categories',
        CategoryController::class
    )->except(['show']);

    Route::resource(
        'admin/promotions',
        PromotionController::class
    );

    // ============================================================
    // PURCHASES
    // ============================================================

   Route::resource(
    'admin/purchases',
    PurchaseController::class
)->only(['index', 'create', 'store', 'show'])
  ->names('admin.purchases');

  Route::resource('admin/expenses', ExpenseController::class);

  Route::resource('admin/historical-purchases', HistoricalPurchaseController::class);

  Route::resource('admin/historical-sales', HistoricalSaleController::class);


    // ============================================================
    // INVENTORY
    // ============================================================


    Route::post(
        'admin/products/{product}/inventory/remove',
        [InventoryController::class, 'removeStock']
    )->name('products.inventory.remove');

    Route::get(
        'admin/products/{product}/inventory',
        [InventoryController::class, 'history']
    )->name('products.inventory.history');


    // ============================================================
    // ADMIN ORDERS
    // ============================================================

    // Order list
    Route::get(
        '/admin/orders',
        [OrderController::class, 'index']
    )->name('orders.index');


    // Create walk-in / online order
    Route::get(
        '/admin/orders/create',
        [OrderController::class, 'create']
    )->name('orders.create');


    // Store order
    Route::post(
        '/admin/orders',
        [OrderController::class, 'store']
    )->name('orders.store');


    // View order details
    Route::get(
        '/admin/orders/{sale}',
        [OrderController::class, 'show']
    )->name('orders.show');

    // Print receipt
    Route::get(
        '/admin/orders/{sale}/receipt',
        [OrderController::class, 'receipt']
    )->name('orders.receipt');

    // Update order status
    Route::patch(
        '/admin/orders/{sale}/status',
        [OrderController::class, 'updateStatus']
    )->name('orders.status.update');

    Route::patch(
        '/admin/orders/{sale}/gcash/verify',
        [OrderController::class, 'verifyGcash']
    )->name('orders.gcash.verify');

    Route::patch(
        '/admin/orders/{sale}/gcash/reject',
        [OrderController::class, 'rejectGcash']
    )->name('orders.gcash.reject');

    // ============================================================
    // ADMIN CUSTOMER MANAGEMENT
    // ============================================================

    // Customer list
    Route::get(
        '/admin/customers',
        [CustomerController::class, 'index']
    )->name('admin.customers.index');

    // View online customer
    Route::get(
        '/admin/customers/{user}',
        [CustomerController::class, 'show']
    )->name('admin.customers.show');

    // Approve customer verification
    Route::patch(
        '/admin/customers/{user}/approve',
        [CustomerController::class, 'approve']
    )->name('admin.customers.approve');

    // Reject customer verification
    Route::patch(
        '/admin/customers/{user}/reject',
        [CustomerController::class, 'reject']
    )->name('admin.customers.reject');

    //reports
    Route::get(
        '/admin/reports',
        [ReportController::class, 'index']
    )->name('admin.reports.index');

    Route::get(
        '/admin/reports/export/pdf',
        [ReportController::class, 'exportPdf']
    )->name('admin.reports.export.pdf');

    Route::get(
        '/admin/reports/export/excel',
        [ReportController::class, 'exportExcel']
    )->name('admin.reports.export.excel');

    // ============================================================
    // ADMIN ANALYTICS
    // ============================================================

    Route::get(
        '/admin/analytics',
        [AnalyticsController::class, 'index']
    )->name('admin.analytics.index');

    // ============================================================
    // ADMIN PROFILE
    // ============================================================

    Route::get(
        '/admin/profile',
        [AdminProfileController::class, 'edit']
    )->name('admin.profile.edit');

    Route::patch(
        '/admin/profile',
        [AdminProfileController::class, 'update']
    )->name('admin.profile.update');

    Route::get('/admin/settings', [SettingController::class, 'index'])
        ->name('settings.index');

    Route::post('/admin/settings/gcash-qr', [SettingController::class, 'updateGcashQr'])
        ->name('settings.gcash-qr.update');

});





/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'customer'])->group(function () {

    Route::get('/customer/settings', [SettingsController::class, 'index'])
        ->name('customer.settings');

    Route::patch('/customer/settings', [SettingsController::class, 'update'])
        ->name('customer.settings.update');

    Route::post(
        '/customer/orders/items/{saleItem}/review',
        [ReviewController::class, 'store']
    )->name('customer.reviews.store');

    Route::post(
        '/customer/favorites/{product}/toggle',
        [FavoriteController::class, 'toggle']
    )->name('customer.favorites.toggle');

    Route::get(
        '/customer/favorites',
        [FavoriteController::class, 'index']
    )->name('customer.favorites');

    // ============================================================
    // CUSTOMER DASHBOARD
    // ============================================================

    Route::get(
        '/customer/dashboard',
        [CustomerDashboardController::class, 'index']
    )->name('customer.dashboard');


    // ============================================================
    // CUSTOMER SHOP
    // ============================================================

    Route::get(
        '/customer/shop',
        [ShopController::class, 'index']
    )->name('customer.shop');

    Route::get(
        '/customer/shop/{product}',
        [ShopController::class, 'show']
    )->name('customer.product.show');


    // ============================================================
    // CUSTOMER CART
    // ============================================================

    Route::get(
        '/customer/cart',
        [CartController::class, 'index']
    )->name('customer.cart');

    Route::post(
        '/customer/cart/add/{product}',
        [CartController::class, 'add']
    )->name('customer.cart.add');

    Route::patch(
        '/customer/cart/update/{product}',
        [CartController::class, 'update']
    )->name('customer.cart.update');

    Route::delete(
        '/customer/cart/remove/{product}',
        [CartController::class, 'remove']
    )->name('customer.cart.remove');

    Route::delete(
        '/customer/cart/clear',
        [CartController::class, 'clear']
    )->name('customer.cart.clear');


    // ============================================================
    // CUSTOMER VERIFICATION
    // ============================================================
    //
    // IMPORTANT:
    // Customer can still LOGIN even if not verified.
    //
    // Verification is only required before placing an order.
    //
    // Pending / Rejected / Under Review customers can access
    // this page and submit their verification information.
    // ============================================================

    // Show verification form
    Route::get(
        '/customer/verification',
        [VerificationController::class, 'create']
    )->name('customer.verification.create');


    // Submit verification form
    Route::post(
        '/customer/verification',
        [VerificationController::class, 'store']
    )->name('customer.verification.store');


    // ============================================================
    // CUSTOMER CHECKOUT
    // ============================================================

    Route::get(
        '/customer/checkout',
        [CheckoutController::class, 'index']
    )->name('customer.checkout');


    // Buy Now
    Route::post(
        '/checkout/buy-now/{product}',
        [CheckoutController::class, 'buyNow']
    )->name('customer.checkout.buy-now');


    // Place Order
    Route::post(
        '/customer/checkout/place-order',
        [CheckoutController::class, 'placeOrder']
    )->name('customer.checkout.place');


    // Checkout Success
    Route::get(
        '/customer/checkout/success/{sale}',
        [CheckoutController::class, 'success']
    )->name('customer.checkout.success');

    Route::patch(
        '/customer/notifications/{notification}/read',
        [NotificationController::class, 'markAsRead']
    )->name('customer.notifications.read');


    // ============================================================
    // CUSTOMER ORDERS
    // ============================================================

    // Order history
    Route::get(
        '/customer/orders',
        [CustomerOrderController::class, 'index']
    )->name('customer.orders');


    // Order details
    Route::get(
        '/customer/orders/{sale}',
        [CustomerOrderController::class, 'show']
    )->name('customer.order.show');

    Route::patch(
        '/customer/orders/{sale}/gcash/resubmit',
        [CustomerOrderController::class, 'resubmitGcashPayment']
    )->name('customer.order.gcash.resubmit');

    // Cancel order
    Route::post(
        '/customer/orders/{sale}/cancel',
        [CustomerOrderController::class, 'cancel']
    )->name('customer.order.cancel');

});


/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';