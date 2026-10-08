<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>MINDOrich Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; }
        h1 { font-size: 22px; margin-bottom: 4px; }
        h2 { font-size: 15px; margin-top: 20px; margin-bottom: 8px; }
        .subtitle { color: #666; margin-bottom: 15px; }
        .summary { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .summary td { border: 1px solid #ddd; padding: 8px; width: 16.66%; }
        .label { color: #666; font-size: 9px; }
        .value { font-size: 14px; font-weight: bold; margin-top: 4px; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data th { background: #f2f2f2; font-weight: bold; }
        table.data th, table.data td { border: 1px solid #ddd; padding: 6px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 25px; font-size: 9px; color: #777; }
    </style>
</head>
<body>
    <h1>MINDOrich</h1>
    <div class="subtitle">Sales and Performance Report</div>
    <p><strong>Period:</strong> {{ ucfirst($period) }}</p>
    <p><strong>Date Range:</strong> {{ $from->format('M d, Y') }} - {{ $to->format('M d, Y') }}</p>
    <h2>Sales Summary</h2>
    <table class="summary"><tr>
        <td><div class="label">Total Sales</div><div class="value">₱{{ number_format($totalSales, 2) }}</div></td>
        <td><div class="label">Total Orders</div><div class="value">{{ number_format($totalOrders) }}</div></td>
        <td><div class="label">Online Sales</div><div class="value">₱{{ number_format($onlineSales, 2) }}</div></td>
        <td><div class="label">Walk-in Sales</div><div class="value">₱{{ number_format($walkInSales, 2) }}</div></td>
        <td><div class="label">Completed Orders</div><div class="value">{{ number_format($completedOrders) }}</div></td>
        <td><div class="label">Pending Orders</div><div class="value">{{ number_format($pendingOrders) }}</div></td>
    </tr></table>
    <h2>FIFO & Inventory Summary</h2>
    <table class="summary">
        <tr>
            <td><div class="label">FIFO Sales Revenue</div><div class="value">₱{{ number_format($fifoSalesRevenue, 2) }}</div></td>
            <td><div class="label">FIFO COGS</div><div class="value">₱{{ number_format($fifoCogs, 2) }}</div></td>
            <td><div class="label">Gross Profit</div><div class="value">₱{{ number_format($fifoGrossProfit, 2) }}</div></td>
            <td><div class="label">Total Purchase Cost</div><div class="value">₱{{ number_format($totalPurchaseCost, 2) }}</div></td>
        </tr>
        <tr>
            <td><div class="label">Operating Expenses</div><div class="value">₱{{ number_format($operatingExpenses, 2) }}</div></td>
            <td><div class="label">Net Profit</div><div class="value">₱{{ number_format($netProfit, 2) }}</div></td>
            <td><div class="label">Good Units</div><div class="value">{{ number_format($totalGoodUnits) }}</div></td>
            <td><div class="label">Reject Units</div><div class="value">{{ number_format($totalRejectUnits) }}</div></td>
        </tr>
        <tr>
            <td colspan="4"><div class="label">Current Inventory Cost</div><div class="value">₱{{ number_format($currentInventoryCost, 2) }}</div></td>
        </tr>
    </table>
   <h2>Current Sales</h2>

<table class="data">

    <thead>
        <tr>
            <th>Date</th>
            <th>Order</th>
            <th>Customer</th>
            <th>Type</th>
            <th>Payment</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>

        @forelse($sales as $sale)

            <tr>

                <td>
                    {{ $sale->created_at?->format('M d, Y') }}
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

                <td class="text-right">
                    ₱{{ number_format($sale->total_amount, 2) }}
                </td>

                <td>
                    {{ $sale->status }}
                </td>

            </tr>

        @empty

            <tr>
                <td colspan="7" class="text-center">
                    No current sales data available.
                </td>
            </tr>

        @endforelse

    </tbody>

</table>


<h2>Historical Sales</h2>

<table class="data">

    <thead>
        <tr>
            <th>Date</th>
            <th>OR Number</th>
            <th>Customer</th>
            <th>Type</th>
            <th>Payment</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>

        @forelse($historicalSales as $historicalSale)

            <tr>

                <td>
                    {{ $historicalSale->sales_date?->format('M d, Y') }}
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

                <td class="text-right">
                    ₱{{ number_format(
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
                <td colspan="7" class="text-center">
                    No historical sales data available.
                </td>
            </tr>

        @endforelse

    </tbody>

</table>
    <div class="footer">Generated by MINDOrich Admin on {{ now()->format('M d, Y h:i A') }}</div>
</body>
</html>