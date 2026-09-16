<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Producer;
use App\Models\Tribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display the analytics dashboard.
     */
    public function index(Request $request)
    {
        // ---------------------------------------------------------
        // DATE FILTER
        // ---------------------------------------------------------

        $period = $request->get('period', 'month');

        $from = null;
        $to = now()->endOfDay();

        switch ($period) {

            case 'today':
                $from = now()->startOfDay();
                break;

            case 'week':
                $from = now()->startOfWeek();
                break;

            case 'month':
                $from = now()->startOfMonth();
                break;

            case 'year':
                $from = now()->startOfYear();
                break;

            case 'custom':
                if ($request->filled('from')) {
                    $from = \Carbon\Carbon::parse(
                        $request->from
                    )->startOfDay();
                }

                if ($request->filled('to')) {
                    $to = \Carbon\Carbon::parse(
                        $request->to
                    )->endOfDay();
                }

                break;

            default:
                $from = now()->startOfMonth();
                break;
        }


        // ---------------------------------------------------------
        // BASE SALES QUERY
        // ---------------------------------------------------------

        $salesQuery = Sale::whereBetween(
            'created_at',
            [$from, $to]
        );


        // ---------------------------------------------------------
        // OVERVIEW
        // ---------------------------------------------------------

        $totalSales = (clone $salesQuery)
            ->where('status', 'Completed')
            ->sum('total_amount');

        $totalOrders = (clone $salesQuery)->count();

        $onlineSales = (clone $salesQuery)
            ->where('sale_type', 'Online')
            ->where('status', 'Completed')
            ->sum('total_amount');

        $walkInSales = (clone $salesQuery)
            ->where('sale_type', 'Walk-in')
            ->where('status', 'Completed')
            ->sum('total_amount');

        $completedOrders = (clone $salesQuery)
            ->where('status', 'Completed')
            ->count();

        $pendingOrders = (clone $salesQuery)
            ->where('status', 'Pending')
            ->count();


        // ---------------------------------------------------------
        // ORDER STATUS ANALYSIS
        // ---------------------------------------------------------

        $orderStatus = (clone $salesQuery)
            ->select(
                'status',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('status')
            ->pluck('total', 'status');


        // ---------------------------------------------------------
        // ONLINE VS WALK-IN
        // ---------------------------------------------------------

        $salesByType = (clone $salesQuery)
            ->select(
                'sale_type',
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_amount) as total_sales')
            )
            ->groupBy('sale_type')
            ->get();


        // ---------------------------------------------------------
        // SALES TREND
        // ---------------------------------------------------------

        $salesTrend = (clone $salesQuery)
            ->where('status', 'Completed')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy(
                DB::raw('DATE(created_at)')
            )
            ->orderBy('date')
            ->get();


        // ---------------------------------------------------------
        // TOP PRODUCTS
        // ---------------------------------------------------------

        $topProducts = SaleItem::query()
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
            ->where(
                'sales.status',
                'Completed'
            )
            ->whereBetween(
                'sales.created_at',
                [$from, $to]
            )
            ->select(
                'products.id',
                'products.product_name',
                DB::raw(
                    'SUM(sale_items.quantity) as quantity_sold'
                ),
                DB::raw(
                    'SUM(sale_items.subtotal) as total_sales'
                )
            )
            ->groupBy(
                'products.id',
                'products.product_name'
            )
            ->orderByDesc('quantity_sold')
            ->limit(10)
            ->get();


        // ---------------------------------------------------------
        // TOP TRIBES
        // ---------------------------------------------------------

        $topTribes = SaleItem::query()
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
            ->join(
                'tribes',
                'producers.tribe_id',
                '=',
                'tribes.id'
            )
            ->where(
                'sales.status',
                'Completed'
            )
            ->whereBetween(
                'sales.created_at',
                [$from, $to]
            )
            ->select(
                'tribes.id',
                'tribes.tribe_name',
                DB::raw(
                    'SUM(sale_items.quantity) as quantity_sold'
                ),
                DB::raw(
                    'SUM(sale_items.subtotal) as total_sales'
                )
            )
            ->groupBy(
                'tribes.id',
                'tribes.tribe_name'
            )
            ->orderByDesc('total_sales')
            ->limit(10)
            ->get();


        // ---------------------------------------------------------
        // TOP CRAFTSMEN
        // ---------------------------------------------------------

        $topCraftsmen = SaleItem::query()
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
            ->whereBetween(
                'sales.created_at',
                [$from, $to]
            )
            ->select(
                'producers.id',
                'producers.producer_name',
                DB::raw(
                    'SUM(sale_items.quantity) as quantity_sold'
                ),
                DB::raw(
                    'SUM(sale_items.subtotal) as total_sales'
                )
            )
            ->groupBy(
                'producers.id',
                'producers.producer_name'
            )
            ->orderByDesc('total_sales')
            ->limit(10)
            ->get();


        // ---------------------------------------------------------
        // INVENTORY PERFORMANCE
        // ---------------------------------------------------------

        $availableProducts = Product::where(
            'status',
            'Available'
        )->count();

        $outOfStockProducts = Product::where(
            'status',
            'Out of Stock'
        )->count();

        $lowStockProducts = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )
        ->where(
            'status',
            'Available'
        )
        ->count();


        // ---------------------------------------------------------
        // RETURN VIEW
        // ---------------------------------------------------------

        return view(
            'admin.analytics.index',
            compact(
                'period',
                'from',
                'to',
                'totalSales',
                'totalOrders',
                'onlineSales',
                'walkInSales',
                'completedOrders',
                'pendingOrders',
                'orderStatus',
                'salesByType',
                'salesTrend',
                'topProducts',
                'topTribes',
                'topCraftsmen',
                'availableProducts',
                'outOfStockProducts',
                'lowStockProducts'
            )
        );
    }
}