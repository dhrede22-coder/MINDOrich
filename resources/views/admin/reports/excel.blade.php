<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">

    <title>MINDOrich Report</title>

</head>

<body>

    <h2>MINDOrich Sales Report</h2>

    <table border="1">
        <tr>
            <td>
                <strong>Period</strong>
            </td>
            <td>
                {{ ucfirst($period) }}
            </td>
        </tr>
        <tr>
            <td>
                <strong>From</strong>
            </td>
            <td>
                {{ $from->format('Y-m-d') }}
            </td>
        </tr>
        <tr>
            <td>
                <strong>To</strong>
            </td>
            <td>
                {{ $to->format('Y-m-d') }}
            </td>
        </tr>
    </table>

    <br>

    <h3>Sales Summary</h3>

    <table border="1">
        <tr>
            <th>Total Sales</th>
            <th>Total Orders</th>
            <th>Online Sales</th>
            <th>Walk-in Sales</th>
            <th>Completed Orders</th>
            <th>Pending Orders</th>
        </tr>
        <tr>
            <td>
                {{ number_format($totalSales, 2) }}
            </td>
            <td>
                {{ $totalOrders }}
            </td>
            <td>
                {{ number_format($onlineSales, 2) }}
            </td>
            <td>
                {{ number_format($walkInSales, 2) }}
            </td>
            <td>
                {{ $completedOrders }}
            </td>
            <td>
                {{ $pendingOrders }}
            </td>
        </tr>
    </table>

    <br>

    <h3>FIFO & Inventory Summary</h3>

    <table border="1">
        <tr>
            <th>FIFO Sales Revenue</th>
            <th>FIFO COGS</th>
            <th>Gross Profit</th>
            <th>Total Purchase Cost</th>
        </tr>
        <tr>
            <td>
                {{ number_format($fifoSalesRevenue, 2) }}
            </td>
            <td>
                {{ number_format($fifoCogs, 2) }}
            </td>
            <td>
                {{ number_format($fifoGrossProfit, 2) }}
            </td>
            <td>
                {{ number_format($totalPurchaseCost, 2) }}
            </td>
        </tr>
    </table>

    <br>

    <table border="1">
        <tr>
            <th>Operating Expenses</th>
            <th>Net Profit</th>
            <th>Good Units</th>
            <th>Reject Units</th>
            <th>Current Inventory Cost</th>
        </tr>
        <tr>
            <td>
                {{ number_format($operatingExpenses, 2) }}
            </td>
            <td>
                {{ number_format($netProfit, 2) }}
            </td>
            <td>
                {{ number_format($totalGoodUnits) }}
            </td>
            <td>
                {{ number_format($totalRejectUnits) }}
            </td>
            <td>
                {{ number_format($currentInventoryCost, 2) }}
            </td>
        </tr>
    </table>

    <br>

    <h3>Current Sales</h3>

<table border="1">

    <thead>

        <tr>

            <th>Date</th>

            <th>Order Number</th>

            <th>Customer</th>

            <th>Order Type</th>

            <th>Payment Method</th>

            <th>Total Amount</th>

            <th>Payment Status</th>

            <th>Order Status</th>

        </tr>

    </thead>


    <tbody>

        @forelse($sales as $sale)

            <tr>

                <td>
                    {{ $sale->created_at?->format('Y-m-d') }}
                </td>

                <td>
                    {{ $sale->sale_number }}
                </td>

                <td>
                    {{ $sale->user?->name ?? 'Walk-in Customer' }}
                </td>

                <td>
                    {{ $sale->sale_type }}
                </td>

                <td>
                    {{ $sale->payment_method }}
                </td>

                <td>
                    {{ number_format($sale->total_amount, 2) }}
                </td>

                <td>
                    {{ $sale->payment_status }}
                </td>

                <td>
                    {{ $sale->status }}
                </td>

            </tr>

        @empty

            <tr>

                <td colspan="8">
                    No current sales data available.
                </td>

            </tr>

        @endforelse

    </tbody>

</table>


<br>


<h3>Historical Sales</h3>

<table border="1">

    <thead>

        <tr>

            <th>Date</th>

            <th>OR Number</th>

            <th>Customer</th>

            <th>Sale Type</th>

            <th>Payment Method</th>

            <th>Total Amount</th>

            <th>Status</th>

        </tr>

    </thead>


    <tbody>

        @forelse($historicalSales as $historicalSale)

            <tr>

                <td>
                    {{ $historicalSale->sales_date?->format('Y-m-d') }}
                </td>

                <td>
                    {{ $historicalSale->or_number ?? '—' }}
                </td>

                <td>
                    {{ $historicalSale->customer_name ?? '—' }}
                </td>

                <td>
                    {{ $historicalSale->sale_type }}
                </td>

                <td>
                    {{ $historicalSale->payment_method }}
                </td>

                <td>
                    {{ number_format(
                        $historicalSale->total_amount,
                        2
                    ) }}
                </td>

                <td>
                    Historical
                </td>

            </tr>

        @empty

            <tr>

                <td colspan="7">
                    No historical sales data available.
                </td>

            </tr>

        @endforelse

    </tbody>

</table>

    <br>

    <p>
        Generated by MINDOrich Admin
        on {{ now()->format('Y-m-d H:i:s') }}
    </p>

</body>
</html>