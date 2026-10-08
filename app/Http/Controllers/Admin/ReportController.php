<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Expense;
use App\Models\HistoricalSale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display reports.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | DATE FILTER
        |--------------------------------------------------------------------------
        */

        $period = $request->input('period', 'month');

        $from = null;
        $to = null;

        switch ($period) {

            case 'today':
                $from = Carbon::today()->startOfDay();
                $to = Carbon::today()->endOfDay();
                break;

            case 'week':
                $from = Carbon::now()->startOfWeek();
                $to = Carbon::now()->endOfWeek();
                break;

            case 'month':
                $from = Carbon::now()->startOfMonth();
                $to = Carbon::now()->endOfMonth();
                break;

            case 'year':
                $from = Carbon::now()->startOfYear();
                $to = Carbon::now()->endOfYear();
                break;

            case 'custom':

                if ($request->filled('from')) {
                    $from = Carbon::parse(
                        $request->input('from')
                    )->startOfDay();
                }

                if ($request->filled('to')) {
                    $to = Carbon::parse(
                        $request->input('to')
                    )->endOfDay();
                }

                if (!$from && !$to) {
                    $from = Carbon::now()->startOfMonth();
                    $to = Carbon::now()->endOfMonth();
                    $period = 'month';
                }

                break;

            default:
                $period = 'month';
                $from = Carbon::now()->startOfMonth();
                $to = Carbon::now()->endOfMonth();
                break;
        }


        /*
        |--------------------------------------------------------------------------
        | SALES
        |--------------------------------------------------------------------------
        */

        $sales = Sale::with([
    'user',
    'saleItems.product.producer.tribe',
    'saleItems.fifoAllocations.purchaseItem',
])
        ->whereBetween('created_at', [
            $from,
            $to
        ])
        ->latest()
        ->get();

        $historicalSales = HistoricalSale::with([
    'items.product.producer.tribe',
    'items.fifoAllocations',
])
->whereBetween('sales_date', [
    $from->toDateString(),
    $to->toDateString()
])
->latest('sales_date')
->get();


        /*
        |--------------------------------------------------------------------------
        | SALES OVERVIEW
        |--------------------------------------------------------------------------
        */

        $completedSales = $sales->where('status', 'Completed');


/*
|--------------------------------------------------------------------------
| HISTORICAL SALES OVERVIEW
|--------------------------------------------------------------------------
*/

$historicalSalesRevenue = $historicalSales->sum(
    fn ($sale) => (float) $sale->total_amount
);

$historicalOrders = $historicalSales->count();

$historicalOnlineSales = $historicalSales
    ->where('sale_type', 'Online')
    ->sum(
        fn ($sale) => (float) $sale->total_amount
    );

$historicalWalkInSales = $historicalSales
    ->where('sale_type', 'Walk-in')
    ->sum(
        fn ($sale) => (float) $sale->total_amount
    );


/*
|--------------------------------------------------------------------------
| CURRENT SALES OVERVIEW
|--------------------------------------------------------------------------
*/

$currentSalesRevenue = $completedSales->sum(
    fn ($sale) => (float) $sale->total_amount
);

$currentOrders = $completedSales->count();

$currentOnlineSales = $completedSales
    ->where('sale_type', 'Online')
    ->sum(
        fn ($sale) => (float) $sale->total_amount
    );

$currentWalkInSales = $completedSales
    ->where('sale_type', 'Walk-in')
    ->sum(
        fn ($sale) => (float) $sale->total_amount
    );


/*
|--------------------------------------------------------------------------
| COMBINED SALES OVERVIEW
|--------------------------------------------------------------------------
*/

$totalSales =
    $currentSalesRevenue +
    $historicalSalesRevenue;

$totalOrders =
    $currentOrders +
    $historicalOrders;

$onlineSales =
    $currentOnlineSales +
    $historicalOnlineSales;

$walkInSales =
    $currentWalkInSales +
    $historicalWalkInSales;

$completedOrders = $totalOrders;

$pendingOrders = $sales
    ->where('status', 'Pending')
    ->count();


        /*
        |--------------------------------------------------------------------------
        | SALES BY PAYMENT METHOD
        |--------------------------------------------------------------------------
        */

        $cashSales = $completedSales
    ->where('payment_method', 'Cash')
    ->sum(
        fn ($sale) => (float) $sale->total_amount
    );

$codSales = $completedSales
    ->where('payment_method', 'COD')
    ->sum(
        fn ($sale) => (float) $sale->total_amount
    );


        /*
        |--------------------------------------------------------------------------
        | SALES TREND
        |--------------------------------------------------------------------------
        */

        $salesTrend = $completedSales
            ->groupBy(
                fn ($sale) =>
                    Carbon::parse($sale->created_at)
                        ->format('Y-m-d')
            )
            ->map(function ($dailySales, $date) {

                return [
                    'date' => $date,

                    'sales' => round(
                        $dailySales->sum(
                            fn ($sale) =>
                                (float) $sale->total_amount
                        ),
                        2
                    ),

                    'orders' => $dailySales->count(),
                ];
            })
            ->sortKeys()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | TOP PRODUCTS
        |--------------------------------------------------------------------------
        */

        $productData = [];

        foreach ($completedSales as $sale) {

            foreach ($sale->saleItems as $saleItem) {

                $product = $saleItem->product;

                if (!$product) {
                    continue;
                }

                $productId = $product->id;

                if (!isset($productData[$productId])) {

                    $productData[$productId] = [
                        'id' => $productId,
                        'name' => $product->product_name,
                        'quantity' => 0,
                        'orders' => 0,
                        'sales' => 0,
                    ];
                }

                $productData[$productId]['quantity'] +=
                    (int) $saleItem->quantity;

                $productData[$productId]['orders']++;

                $productData[$productId]['sales'] +=
                    (float) $saleItem->subtotal;
            }
        }

        $topProducts = collect($productData)
            ->sortByDesc('quantity')
            ->values()
            ->take(10)
            ->map(function ($product) {

                $product['sales'] = round(
                    $product['sales'],
                    2
                );

                return $product;
            });


        /*
        |--------------------------------------------------------------------------
        | TOP CRAFTSMEN
        |--------------------------------------------------------------------------
        */

        $craftsmanData = [];

        foreach ($completedSales as $sale) {

            foreach ($sale->saleItems as $saleItem) {

                $product = $saleItem->product;

                if (!$product || !$product->producer) {
                    continue;
                }

                $producer = $product->producer;

                $producerId = $producer->id;

                if (!isset($craftsmanData[$producerId])) {

                    $craftsmanData[$producerId] = [
                        'id' => $producerId,
                        'name' => $producer->producer_name,
                        'tribe' => $producer->tribe
                            ? $producer->tribe->tribe_name
                            : '—',
                        'tribe_id' => $producer->tribe_id,
                        'quantity' => 0,
                        'orders' => 0,
                        'sales' => 0,
                    ];
                }

                $craftsmanData[$producerId]['quantity'] +=
                    (int) $saleItem->quantity;

                $craftsmanData[$producerId]['orders']++;

                $craftsmanData[$producerId]['sales'] +=
                    (float) $saleItem->subtotal;
            }
        }

        $topCraftsmen = collect($craftsmanData)
            ->sortByDesc('quantity')
            ->values()
            ->take(10)
            ->map(function ($craftsman) {

                $craftsman['sales'] = round(
                    $craftsman['sales'],
                    2
                );

                return $craftsman;
            });


        /*
        |--------------------------------------------------------------------------
        | TOP TRIBES
        |--------------------------------------------------------------------------
        */

        $tribeData = [];

        foreach ($completedSales as $sale) {

            foreach ($sale->saleItems as $saleItem) {

                $product = $saleItem->product;

                if (
                    !$product ||
                    !$product->producer ||
                    !$product->producer->tribe
                ) {
                    continue;
                }

                $tribe = $product->producer->tribe;

                $tribeId = $tribe->id;

                if (!isset($tribeData[$tribeId])) {

                    $tribeData[$tribeId] = [
                        'id' => $tribeId,
                        'name' => $tribe->tribe_name,
                        'quantity' => 0,
                        'orders' => 0,
                        'sales' => 0,
                    ];
                }

                $tribeData[$tribeId]['quantity'] +=
                    (int) $saleItem->quantity;

                $tribeData[$tribeId]['orders']++;

                $tribeData[$tribeId]['sales'] +=
                    (float) $saleItem->subtotal;
            }
        }

        $topTribes = collect($tribeData)
            ->sortByDesc('quantity')
            ->values()
            ->take(10)
            ->map(function ($tribe) {

                $tribe['sales'] = round(
                    $tribe['sales'],
                    2
                );

                return $tribe;
            });


        /*
        |--------------------------------------------------------------------------
        | TRIBES FOR FILTER
        |--------------------------------------------------------------------------
        */

        $tribes = \App\Models\Tribe::orderBy(
            'tribe_name'
        )->get();


        /*
        |--------------------------------------------------------------------------
        | TOP CUSTOMERS
        |--------------------------------------------------------------------------
        */

        $customerData = [];

        foreach ($completedSales as $sale) {

            if (!$sale->user) {
                continue;
            }

            $userId = $sale->user->id;

            if (!isset($customerData[$userId])) {

                $customerData[$userId] = [
                    'id' => $userId,
                    'name' => $sale->user->name,
                    'orders' => 0,
                    'spent' => 0,
                ];
            }

            $customerData[$userId]['orders']++;

            $customerData[$userId]['spent'] +=
                (float) $sale->total_amount;
        }

        $topCustomers = collect($customerData)
            ->sortByDesc('spent')
            ->values()
            ->take(10)
            ->map(function ($customer) {

                $customer['spent'] = round(
                    $customer['spent'],
                    2
                );

                return $customer;
            });


        /*
        |--------------------------------------------------------------------------
        | INVENTORY PERFORMANCE
        |--------------------------------------------------------------------------
        */

        $totalProducts = Product::count();

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
            'stock',
            '>',
            0
        )
        ->count();
$fifoCogs = 0;

$fifoSalesRevenue = 0;

$fifoGrossProfit = 0;

$totalPurchaseCost = 0;

$totalGoodUnits = 0;

$totalRejectUnits = 0;

$currentInventoryCost = 0;

foreach ($completedSales as $sale) {

    foreach ($sale->saleItems as $saleItem) {

        $allocations = $saleItem->fifoAllocations;

        if ($allocations->isEmpty()) {
            continue;
        }

        $allocatedQuantity = $allocations->sum(
            fn ($allocation) => (int) $allocation->quantity
        );

        if ($allocatedQuantity < $saleItem->quantity) {
            continue;
        }

        $fifoCogs += $allocations->sum(
            fn ($allocation) => (float) $allocation->cost_subtotal
        );

        $fifoSalesRevenue += (float) $saleItem->subtotal;
    }
}

$historicalFifoCogs = 0;

foreach ($historicalSales as $historicalSale) {

    foreach ($historicalSale->items as $saleItem) {

        $historicalFifoCogs +=
            $saleItem->fifoAllocations->sum(
                fn ($allocation) =>
                    (float) $allocation->cost_subtotal
            );
    }
}


/*
|--------------------------------------------------------------------------
| COMBINED FIFO
|--------------------------------------------------------------------------
*/

$fifoSalesRevenue += $historicalSalesRevenue;

$fifoCogs += $historicalFifoCogs;

$fifoGrossProfit =
    $fifoSalesRevenue -
    $fifoCogs;

$purchaseItems = \App\Models\PurchaseItem::with('purchase')
    ->whereHas('purchase', function ($query) use ($from, $to) {
        $query->whereBetween('purchase_date', [
            $from->toDateString(),
            $to->toDateString()
        ]);
    })
    ->get();

$totalPurchaseCost = $purchaseItems->sum(
    fn ($item) => (float) $item->quantity_in * (float) $item->purchase_price
);

$totalGoodUnits = $purchaseItems->sum(
    fn ($item) => (int) $item->good_quantity
);

$totalRejectUnits = $purchaseItems->sum(
    fn ($item) => (int) $item->reject_quantity
);

$remainingPurchaseItems = \App\Models\PurchaseItem::where(
    'remaining_quantity',
    '>',
    0
)->get();

$currentInventoryCost = $remainingPurchaseItems->sum(
    fn ($item) =>
        (float) $item->remaining_quantity *
        (float) $item->purchase_price
);

/*
|--------------------------------------------------------------------------
| OPERATING EXPENSES & NET PROFIT
|--------------------------------------------------------------------------
| Cost of Goods Sold is excluded because FIFO COGS
| is already calculated above. This prevents double-counting.
*/

$operatingExpenses = Expense::whereBetween('expense_date', [
    $from->toDateString(),
    $to->toDateString()
])
->where('category', '!=', 'Cost of Goods Sold')
->sum('amount');

$netProfit = $fifoGrossProfit - (float) $operatingExpenses;

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.reports.index',
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

                'cashSales',
                'codSales',

                'salesTrend',

                'topProducts',
                'topTribes',
                'topCraftsmen',
                'tribes',

                'topCustomers',

                'totalProducts',
'availableProducts',
'lowStockProducts',
'outOfStockProducts',

'fifoCogs',
'fifoSalesRevenue',
'fifoGrossProfit',
'operatingExpenses',
'netProfit',
'totalPurchaseCost',
'totalGoodUnits',
'totalRejectUnits',
'currentInventoryCost',

'sales',
'historicalSales',
'historicalSalesRevenue',
'historicalFifoCogs',
            )
        );
    }
        /**
     * Export reports as PDF.
     */
    public function exportPdf(Request $request)
    {
        $period = $request->input('period', 'month');

        [$from, $to] = $this->getExportDateRange($request);

        $sales = Sale::with([
            'user',
            'saleItems.product.producer.tribe',
            'saleItems.fifoAllocations.purchaseItem',
        ])
        ->whereBetween('created_at', [$from, $to])
        ->latest()
        ->get();

        $historicalSales = HistoricalSale::with([
    'items.fifoAllocations',
])
->whereBetween('sales_date', [
    $from->toDateString(),
    $to->toDateString()
])
->latest('sales_date')
->get();

        $completedSales = $sales->where('status', 'Completed');


/*
|--------------------------------------------------------------------------
| HISTORICAL SALES
|--------------------------------------------------------------------------
*/

$historicalSalesRevenue = $historicalSales->sum(
    fn ($sale) => (float) $sale->total_amount
);

$historicalOrders = $historicalSales->count();

$historicalOnlineSales = $historicalSales
    ->where('sale_type', 'Online')
    ->sum(
        fn ($sale) => (float) $sale->total_amount
    );

$historicalWalkInSales = $historicalSales
    ->where('sale_type', 'Walk-in')
    ->sum(
        fn ($sale) => (float) $sale->total_amount
    );


/*
|--------------------------------------------------------------------------
| CURRENT + HISTORICAL SALES
|--------------------------------------------------------------------------
*/

$currentSalesRevenue = $completedSales->sum(
    fn ($sale) => (float) $sale->total_amount
);

$currentOrders = $completedSales->count();

$currentOnlineSales = $completedSales
    ->where('sale_type', 'Online')
    ->sum(
        fn ($sale) => (float) $sale->total_amount
    );

$currentWalkInSales = $completedSales
    ->where('sale_type', 'Walk-in')
    ->sum(
        fn ($sale) => (float) $sale->total_amount
    );


$totalSales =
    $currentSalesRevenue +
    $historicalSalesRevenue;

$totalOrders =
    $currentOrders +
    $historicalOrders;

$onlineSales =
    $currentOnlineSales +
    $historicalOnlineSales;

$walkInSales =
    $currentWalkInSales +
    $historicalWalkInSales;

$completedOrders =
    $totalOrders;

$pendingOrders = $sales
    ->where('status', 'Pending')
    ->count();


        /*
        |--------------------------------------------------------------------------
        | FIFO & INVENTORY SUMMARY FOR PDF
        |--------------------------------------------------------------------------
        */

        $fifoCogs = 0;

        $fifoSalesRevenue = 0;

        foreach ($completedSales as $sale) {

            foreach ($sale->saleItems as $saleItem) {

                $allocations = $saleItem->fifoAllocations;

                if ($allocations->isEmpty()) {
                    continue;
                }

                $allocatedQuantity = $allocations->sum(
                    fn ($allocation) => (int) $allocation->quantity
                );

                if ($allocatedQuantity < $saleItem->quantity) {
                    continue;
                }

                $fifoCogs += $allocations->sum(
                    fn ($allocation) => (float) $allocation->cost_subtotal
                );

                $fifoSalesRevenue += (float) $saleItem->subtotal;
            }
        }

        $historicalFifoCogs = 0;

foreach ($historicalSales as $historicalSale) {

    foreach ($historicalSale->items as $saleItem) {

        $historicalFifoCogs +=
            $saleItem->fifoAllocations->sum(
                fn ($allocation) =>
                    (float) $allocation->cost_subtotal
            );
    }
}


/*
|--------------------------------------------------------------------------
| COMBINED FIFO
|--------------------------------------------------------------------------
*/

$fifoSalesRevenue += $historicalSalesRevenue;

$fifoCogs += $historicalFifoCogs;

$fifoGrossProfit =
    $fifoSalesRevenue -
    $fifoCogs;

        $purchaseItems = \App\Models\PurchaseItem::with('purchase')
            ->whereHas('purchase', function ($query) use ($from, $to) {
                $query->whereBetween('purchase_date', [
                    $from->toDateString(),
                    $to->toDateString()
                ]);
            })
            ->get();

        $totalPurchaseCost = $purchaseItems->sum(
            fn ($item) =>
                (float) $item->quantity_in *
                (float) $item->purchase_price
        );

        $totalGoodUnits = $purchaseItems->sum(
            fn ($item) => (int) $item->good_quantity
        );

        $totalRejectUnits = $purchaseItems->sum(
            fn ($item) => (int) $item->reject_quantity
        );

        $remainingPurchaseItems = \App\Models\PurchaseItem::where(
            'remaining_quantity',
            '>',
            0
        )->get();

        $currentInventoryCost = $remainingPurchaseItems->sum(
            fn ($item) =>
                (float) $item->remaining_quantity *
                (float) $item->purchase_price
        );

        /*
|--------------------------------------------------------------------------
| OPERATING EXPENSES & NET PROFIT FOR PDF
|--------------------------------------------------------------------------
| Cost of Goods Sold is excluded because FIFO COGS
| is already calculated above. This prevents double-counting.
*/

$operatingExpenses = Expense::whereBetween('expense_date', [
    $from->toDateString(),
    $to->toDateString()
])
->where('category', '!=', 'Cost of Goods Sold')
->sum('amount');

$netProfit = $fifoGrossProfit - (float) $operatingExpenses;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'admin.reports.pdf',
            compact(
                'period',
                'from',
                'to',
                'sales',
                'totalSales',
                'totalOrders',
                'onlineSales',
                'walkInSales',
                'completedOrders',
                'pendingOrders',
                'fifoCogs',
                'fifoSalesRevenue',
                'fifoGrossProfit',
                'operatingExpenses',
                'netProfit',
                'totalPurchaseCost',
                'totalGoodUnits',
                'totalRejectUnits',
                'currentInventoryCost',
'historicalSales',
'historicalSalesRevenue',
'historicalFifoCogs'
            )
        );

        return $pdf->download(
            'MINDOrich-Report-' . now()->format('Y-m-d') . '.pdf'
        );
    }


    /**
     * Export reports as Excel-compatible XLS.
     */
    public function exportExcel(Request $request)
    {
        $period = $request->input('period', 'month');

        [$from, $to] = $this->getExportDateRange($request);

        $sales = Sale::with([
            'user',
            'saleItems.product.producer.tribe',
            'saleItems.fifoAllocations.purchaseItem',
        ])
        ->whereBetween('created_at', [$from, $to])
        ->latest()
        ->get();

        $historicalSales = HistoricalSale::with([
    'items.fifoAllocations',
])
->whereBetween('sales_date', [
    $from->toDateString(),
    $to->toDateString()
])
->latest('sales_date')
->get();

        $completedSales = $sales->where('status', 'Completed');


/*
|--------------------------------------------------------------------------
| HISTORICAL SALES
|--------------------------------------------------------------------------
*/

$historicalSalesRevenue = $historicalSales->sum(
    fn ($sale) => (float) $sale->total_amount
);

$historicalOrders = $historicalSales->count();

$historicalOnlineSales = $historicalSales
    ->where('sale_type', 'Online')
    ->sum(
        fn ($sale) => (float) $sale->total_amount
    );

$historicalWalkInSales = $historicalSales
    ->where('sale_type', 'Walk-in')
    ->sum(
        fn ($sale) => (float) $sale->total_amount
    );


/*
|--------------------------------------------------------------------------
| COMBINED SALES
|--------------------------------------------------------------------------
*/

$currentSalesRevenue = $completedSales->sum(
    fn ($sale) => (float) $sale->total_amount
);

$currentOrders = $completedSales->count();

$currentOnlineSales = $completedSales
    ->where('sale_type', 'Online')
    ->sum(
        fn ($sale) => (float) $sale->total_amount
    );

$currentWalkInSales = $completedSales
    ->where('sale_type', 'Walk-in')
    ->sum(
        fn ($sale) => (float) $sale->total_amount
    );


$totalSales =
    $currentSalesRevenue +
    $historicalSalesRevenue;

$totalOrders =
    $currentOrders +
    $historicalOrders;

$onlineSales =
    $currentOnlineSales +
    $historicalOnlineSales;

$walkInSales =
    $currentWalkInSales +
    $historicalWalkInSales;

$completedOrders =
    $totalOrders;

$pendingOrders = $sales
    ->where('status', 'Pending')
    ->count();


        /*
        |--------------------------------------------------------------------------
        | FIFO & INVENTORY SUMMARY FOR EXCEL
        |--------------------------------------------------------------------------
        */

        $fifoCogs = 0;

        $fifoSalesRevenue = 0;

        foreach ($completedSales as $sale) {

            foreach ($sale->saleItems as $saleItem) {

                $allocations = $saleItem->fifoAllocations;

                if ($allocations->isEmpty()) {
                    continue;
                }

                $allocatedQuantity = $allocations->sum(
                    fn ($allocation) => (int) $allocation->quantity
                );

                if ($allocatedQuantity < $saleItem->quantity) {
                    continue;
                }

                $fifoCogs += $allocations->sum(
                    fn ($allocation) => (float) $allocation->cost_subtotal
                );

                $fifoSalesRevenue += (float) $saleItem->subtotal;
            }
        }

       $historicalFifoCogs = 0;

foreach ($historicalSales as $historicalSale) {

    foreach ($historicalSale->items as $saleItem) {

        $historicalFifoCogs +=
            $saleItem->fifoAllocations->sum(
                fn ($allocation) =>
                    (float) $allocation->cost_subtotal
            );
    }
}


/*
|--------------------------------------------------------------------------
| COMBINED FIFO
|--------------------------------------------------------------------------
*/

$fifoSalesRevenue += $historicalSalesRevenue;

$fifoCogs += $historicalFifoCogs;

$fifoGrossProfit =
    $fifoSalesRevenue -
    $fifoCogs;

        $purchaseItems = \App\Models\PurchaseItem::with('purchase')
            ->whereHas('purchase', function ($query) use ($from, $to) {
                $query->whereBetween('purchase_date', [
                    $from->toDateString(),
                    $to->toDateString()
                ]);
            })
            ->get();

        $totalPurchaseCost = $purchaseItems->sum(
            fn ($item) =>
                (float) $item->quantity_in *
                (float) $item->purchase_price
        );

        $totalGoodUnits = $purchaseItems->sum(
            fn ($item) => (int) $item->good_quantity
        );

        $totalRejectUnits = $purchaseItems->sum(
            fn ($item) => (int) $item->reject_quantity
        );

        $remainingPurchaseItems = \App\Models\PurchaseItem::where(
            'remaining_quantity',
            '>',
            0
        )->get();

        $currentInventoryCost = $remainingPurchaseItems->sum(
            fn ($item) =>
                (float) $item->remaining_quantity *
                (float) $item->purchase_price
        );

        /*
        |--------------------------------------------------------------------------
        | OPERATING EXPENSES & NET PROFIT FOR EXCEL
        |--------------------------------------------------------------------------
        | Cost of Goods Sold is excluded because FIFO COGS
        | is already calculated above. This prevents double-counting.
        */

        $operatingExpenses = Expense::whereBetween('expense_date', [
            $from->toDateString(),
            $to->toDateString()
        ])
        ->where('category', '!=', 'Cost of Goods Sold')
        ->sum('amount');

        $netProfit = $fifoGrossProfit - (float) $operatingExpenses;

        $html = view(
            'admin.reports.excel',
            compact(
                'period',
                'from',
                'to',
                'sales',
                'totalSales',
                'totalOrders',
                'onlineSales',
                'walkInSales',
                'completedOrders',
                'pendingOrders',
                'fifoCogs',
                'fifoSalesRevenue',
                'fifoGrossProfit',
                'operatingExpenses',
                'netProfit',
                'totalPurchaseCost',
                'totalGoodUnits',
                'totalRejectUnits',
                'currentInventoryCost',
'historicalSales',
'historicalSalesRevenue',
'historicalFifoCogs'
            )
        )->render();

        return response($html)
            ->header(
                'Content-Type',
                'application/vnd.ms-excel'
            )
            ->header(
                'Content-Disposition',
                'attachment; filename="MINDOrich-Report-' .
                now()->format('Y-m-d') .
                '.xls"'
            );
    }


    /**
     * Get date range for exports.
     */
    private function getExportDateRange(Request $request)
    {
        $period = $request->input('period', 'month');

        switch ($period) {

            case 'today':

                $from = Carbon::today()->startOfDay();
                $to = Carbon::today()->endOfDay();

                break;


            case 'week':

                $from = Carbon::now()->startOfWeek();
                $to = Carbon::now()->endOfWeek();

                break;


            case 'year':

                $from = Carbon::now()->startOfYear();
                $to = Carbon::now()->endOfYear();

                break;


            case 'custom':

                $from = $request->filled('from')
                    ? Carbon::parse(
                        $request->input('from')
                    )->startOfDay()
                    : Carbon::now()->startOfMonth();

                $to = $request->filled('to')
                    ? Carbon::parse(
                        $request->input('to')
                    )->endOfDay()
                    : Carbon::now()->endOfMonth();

                break;


            case 'month':

            default:

                $from = Carbon::now()->startOfMonth();
                $to = Carbon::now()->endOfMonth();

                break;
        }

        return [$from, $to];
    }
}