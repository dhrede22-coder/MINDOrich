<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Producer;
use App\Models\Tribe;
use App\Models\HistoricalSale;
use App\Models\HistoricalSaleItem;
use App\Models\Expense;
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
        $historicalSalesQuery = HistoricalSale::whereBetween(
    'sales_date',
    [
        $from->toDateString(),
        $to->toDateString()
    ]
);



// ---------------------------------------------------------
// OVERVIEW
// ---------------------------------------------------------

$currentTotalSales = (clone $salesQuery)
    ->where('status', 'Completed')
    ->sum('total_amount');

$historicalTotalSales = (clone $historicalSalesQuery)
    ->sum('total_amount');

$totalSales =
    (float) $currentTotalSales +
    (float) $historicalTotalSales;


$currentTotalOrders = (clone $salesQuery)
    ->where('status', 'Completed')
    ->count();

$historicalTotalOrders =
    (clone $historicalSalesQuery)->count();

$totalOrders =
    $currentTotalOrders +
    $historicalTotalOrders;


$currentOnlineSales = (clone $salesQuery)
    ->where('sale_type', 'Online')
    ->where('status', 'Completed')
    ->sum('total_amount');

$historicalOnlineSales = (clone $historicalSalesQuery)
    ->where('sale_type', 'Online')
    ->sum('total_amount');

$onlineSales =
    (float) $currentOnlineSales +
    (float) $historicalOnlineSales;


$currentWalkInSales = (clone $salesQuery)
    ->where('sale_type', 'Walk-in')
    ->where('status', 'Completed')
    ->sum('total_amount');

$historicalWalkInSales = (clone $historicalSalesQuery)
    ->where('sale_type', 'Walk-in')
    ->sum('total_amount');

$walkInSales =
    (float) $currentWalkInSales +
    (float) $historicalWalkInSales;


$completedOrders =
    $currentTotalOrders +
    $historicalTotalOrders;


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

        $salesByType = collect([
    [
        'sale_type' => 'Online',
        'total_orders' =>
            (clone $salesQuery)
                ->where('status', 'Completed')
                ->where('sale_type', 'Online')
                ->count()
            +
            (clone $historicalSalesQuery)
                ->where('sale_type', 'Online')
                ->count(),

        'total_sales' =>
            (float) (
                (clone $salesQuery)
                    ->where('status', 'Completed')
                    ->where('sale_type', 'Online')
                    ->sum('total_amount')
            )
            +
            (float) (
                (clone $historicalSalesQuery)
                    ->where('sale_type', 'Online')
                    ->sum('total_amount')
            ),
    ],
    [
        'sale_type' => 'Walk-in',
        'total_orders' =>
            (clone $salesQuery)
                ->where('status', 'Completed')
                ->where('sale_type', 'Walk-in')
                ->count()
            +
            (clone $historicalSalesQuery)
                ->where('sale_type', 'Walk-in')
                ->count(),

        'total_sales' =>
            (float) (
                (clone $salesQuery)
                    ->where('status', 'Completed')
                    ->where('sale_type', 'Walk-in')
                    ->sum('total_amount')
            )
            +
            (float) (
                (clone $historicalSalesQuery)
                    ->where('sale_type', 'Walk-in')
                    ->sum('total_amount')
            ),
    ],
]);


        // ---------------------------------------------------------
        // SALES TREND
        // ---------------------------------------------------------

       $currentSalesTrend = (clone $salesQuery)
    ->where('status', 'Completed')
    ->select(
        DB::raw('DATE(created_at) as date'),
        DB::raw('SUM(total_amount) as total')
    )
    ->groupBy(DB::raw('DATE(created_at)'))
    ->get();

$historicalSalesTrend = (clone $historicalSalesQuery)
    ->select(
        'sales_date as date',
        DB::raw('SUM(total_amount) as total')
    )
    ->groupBy('sales_date')
    ->get();

$salesTrend = $currentSalesTrend
    ->concat($historicalSalesTrend)
    ->groupBy(function ($item) {
        return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
    })
    ->map(function ($items, $date) {
        return (object) [
            'date' => $date,
            'total' => $items->sum('total'),
        ];
    })
    ->sortBy('date')
    ->values();


        // ---------------------------------------------------------
// TOP PRODUCTS
// ---------------------------------------------------------

$currentTopProducts = SaleItem::query()
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
    ->get();

$historicalTopProducts = HistoricalSaleItem::query()
    ->join(
        'historical_sales',
        'historical_sale_items.historical_sale_id',
        '=',
        'historical_sales.id'
    )
    ->join(
        'products',
        'historical_sale_items.product_id',
        '=',
        'products.id'
    )
    ->whereBetween(
        'historical_sales.sales_date',
        [
            $from->toDateString(),
            $to->toDateString()
        ]
    )
    ->select(
        'products.id',
        'products.product_name',
        DB::raw(
            'SUM(historical_sale_items.quantity) as quantity_sold'
        ),
        DB::raw(
            'SUM(historical_sale_items.subtotal) as total_sales'
        )
    )
    ->groupBy(
        'products.id',
        'products.product_name'
    )
    ->get();

$topProducts = $currentTopProducts
    ->concat($historicalTopProducts)
    ->groupBy('id')
    ->map(function ($items) {

        $first = $items->first();

        return (object) [
            'id' => $first->id,
            'product_name' => $first->product_name,
            'quantity_sold' => $items->sum('quantity_sold'),
            'total_sales' => $items->sum('total_sales'),
        ];
    })
    ->sortByDesc('quantity_sold')
    ->take(10)
    ->values();


        // ---------------------------------------------------------
// TOP TRIBES
// ---------------------------------------------------------

$currentTopTribes = SaleItem::query()
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
    ->get();

$historicalTopTribes = HistoricalSaleItem::query()
    ->join(
        'historical_sales',
        'historical_sale_items.historical_sale_id',
        '=',
        'historical_sales.id'
    )
    ->join(
        'products',
        'historical_sale_items.product_id',
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
    ->whereBetween(
        'historical_sales.sales_date',
        [
            $from->toDateString(),
            $to->toDateString()
        ]
    )
    ->select(
        'tribes.id',
        'tribes.tribe_name',
        DB::raw(
            'SUM(historical_sale_items.quantity) as quantity_sold'
        ),
        DB::raw(
            'SUM(historical_sale_items.subtotal) as total_sales'
        )
    )
    ->groupBy(
        'tribes.id',
        'tribes.tribe_name'
    )
    ->get();

$topTribes = $currentTopTribes
    ->concat($historicalTopTribes)
    ->groupBy('id')
    ->map(function ($items) {

        $first = $items->first();

        return (object) [
            'id' => $first->id,
            'tribe_name' => $first->tribe_name,
            'quantity_sold' => $items->sum('quantity_sold'),
            'total_sales' => $items->sum('total_sales'),
        ];
    })
    ->sortByDesc('total_sales')
    ->take(10)
    ->values();


        // ---------------------------------------------------------
// TOP CRAFTSMEN
// ---------------------------------------------------------

$currentTopCraftsmen = SaleItem::query()
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
    ->get();

$historicalTopCraftsmen = HistoricalSaleItem::query()
    ->join(
        'historical_sales',
        'historical_sale_items.historical_sale_id',
        '=',
        'historical_sales.id'
    )
    ->join(
        'products',
        'historical_sale_items.product_id',
        '=',
        'products.id'
    )
    ->join(
        'producers',
        'products.producer_id',
        '=',
        'producers.id'
    )
    ->whereBetween(
        'historical_sales.sales_date',
        [
            $from->toDateString(),
            $to->toDateString()
        ]
    )
    ->select(
        'producers.id',
        'producers.producer_name',
        DB::raw(
            'SUM(historical_sale_items.quantity) as quantity_sold'
        ),
        DB::raw(
            'SUM(historical_sale_items.subtotal) as total_sales'
        )
    )
    ->groupBy(
        'producers.id',
        'producers.producer_name'
    )
    ->get();

$topCraftsmen = $currentTopCraftsmen
    ->concat($historicalTopCraftsmen)
    ->groupBy('id')
    ->map(function ($items) {

        $first = $items->first();

        return (object) [
            'id' => $first->id,
            'producer_name' => $first->producer_name,
            'quantity_sold' => $items->sum('quantity_sold'),
            'total_sales' => $items->sum('total_sales'),
        ];
    })
    ->sortByDesc('total_sales')
    ->take(10)
    ->values();


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
// PROFITABILITY
// ---------------------------------------------------------

$currentFifoCogs = SaleItem::query()
    ->join(
        'sales',
        'sale_items.sale_id',
        '=',
        'sales.id'
    )
    ->join(
        'sale_item_fifo_allocations',
        'sale_items.id',
        '=',
        'sale_item_fifo_allocations.sale_item_id'
    )
    ->where(
        'sales.status',
        'Completed'
    )
    ->whereBetween(
        'sales.created_at',
        [$from, $to]
    )
    ->sum(
        'sale_item_fifo_allocations.cost_subtotal'
    );

$currentFifoSalesRevenue = SaleItem::query()
    ->join(
        'sales',
        'sale_items.sale_id',
        '=',
        'sales.id'
    )
    ->where(
        'sales.status',
        'Completed'
    )
    ->whereBetween(
        'sales.created_at',
        [$from, $to]
    )
    ->sum(
        'sale_items.subtotal'
    );

$historicalFifoCogs = HistoricalSaleItem::query()
    ->join(
        'historical_sales',
        'historical_sale_items.historical_sale_id',
        '=',
        'historical_sales.id'
    )
    ->join(
        'historical_fifo_allocations',
        'historical_sale_items.id',
        '=',
        'historical_fifo_allocations.historical_sale_item_id'
    )
    ->whereBetween(
        'historical_sales.sales_date',
        [
            $from->toDateString(),
            $to->toDateString()
        ]
    )
    ->sum(
        'historical_fifo_allocations.cost_subtotal'
    );

$historicalSalesRevenue = (clone $historicalSalesQuery)
    ->sum('total_amount');

$fifoCogs =
    (float) $currentFifoCogs +
    (float) $historicalFifoCogs;

$fifoSalesRevenue =
    (float) $currentFifoSalesRevenue +
    (float) $historicalSalesRevenue;

$fifoGrossProfit =
    $fifoSalesRevenue -
    $fifoCogs;

$operatingExpenses = Expense::whereBetween(
    'expense_date',
    [
        $from->toDateString(),
        $to->toDateString()
    ]
)
->where(
    'category',
    '!=',
    'Cost of Goods Sold'
)
->sum('amount');

$netProfit =
    $fifoGrossProfit -
    (float) $operatingExpenses;


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
    'lowStockProducts',
    'fifoCogs',
    'fifoSalesRevenue',
    'fifoGrossProfit',
    'operatingExpenses',
    'netProfit'
)
        );
    }
}