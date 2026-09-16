<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Producer;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC COUNTS
        |--------------------------------------------------------------------------
        */

        $products = Product::count();

        $producers = Producer::count();

        $customers = User::whereHas('role', function ($query) {
    $query->where('name', 'Customer');
})->count();

        $pendingOrders = Sale::where('status', 'Pending')->count();

        $recentOrders = Sale::with([
    'user',
    'saleItems.product'
])
->latest()
->limit(10)
->get();

$lowStockProducts = Product::whereColumn(
    'stock',
    '<=',
    'minimum_stock'
)
->where('stock', '>', 0)
->orderBy('stock')
->limit(5)
->get();


        /*
        |--------------------------------------------------------------------------
        | MONTHLY COUNTS
        |--------------------------------------------------------------------------
        */

        $productsThisMonth = Product::whereMonth(
            'created_at',
            now()->month
        )
        ->whereYear(
            'created_at',
            now()->year
        )
        ->count();

        $producersThisMonth = Producer::whereMonth(
            'created_at',
            now()->month
        )
        ->whereYear(
            'created_at',
            now()->year
        )
        ->count();

        $customersThisMonth = User::whereHas('role', function ($query) {
    $query->where('name', 'Customer');
})
->whereMonth(
    'created_at',
    now()->month
)
->whereYear(
    'created_at',
    now()->year
)
->count();


        /*
        |--------------------------------------------------------------------------
        | MONTHLY SALES ANALYTICS
        |--------------------------------------------------------------------------
        |
        | Same completed-sales logic used in Analytics.
        |
        */

        $monthlySales = Sale::where(
            'status',
            'Completed'
        )
        ->whereYear(
            'created_at',
            now()->year
        )
        ->select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_amount) as total')
        )
        ->groupBy(
            DB::raw('MONTH(created_at)')
        )
        ->orderBy('month')
        ->get();


        /*
        |--------------------------------------------------------------------------
        | CHART DATA
        |--------------------------------------------------------------------------
        */

        $salesLabels = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec',
        ];

        $salesData = array_fill(0, 12, 0);

        foreach ($monthlySales as $sale) {

            $monthIndex = (int) $sale->month - 1;

            $salesData[$monthIndex] =
                (float) $sale->total;
        }


        /*
        |--------------------------------------------------------------------------
        | TOP PRODUCERS
        |--------------------------------------------------------------------------
        */

        $topProducers = DB::table('sale_items')
            ->join(
                'sales',
                'sale_items.sale_id',
                '=',
                'sales.id'
            )
            ->join(
                'products',
                'sale_items.product_id',
                '=',
                'products.id'
            )
            ->join(
                'producers',
                'products.producer_id',
                '=',
                'producers.id'
            )
            ->where(
                'sales.status',
                'Completed'
            )
            ->select(
    'producers.id',
    'producers.producer_name',
    'producers.photo',
    DB::raw(
        'SUM(sale_items.subtotal) as total_sales'
    )
)
            ->groupBy(
    'producers.id',
    'producers.producer_name',
    'producers.photo'
)
            ->orderByDesc('total_sales')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.dashboard',
            compact(
                'products',
                'producers',
                'customers',
                'pendingOrders',
                'productsThisMonth',
                'producersThisMonth',
                'customersThisMonth',
                'salesLabels',
                'salesData',
                'topProducers',
                'recentOrders',
                'lowStockProducts'
            )
        );
    }
}