<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Receipt - {{ $sale->sale_number }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            background: #f5f5f5;
            font-family: Arial, sans-serif;
            color: #222;
        }

        .receipt {
            width: 380px;
            margin: 0 auto;
            padding: 25px;
            background: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .brand {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .organization {
            font-size: 12px;
            color: #666;
        }

        .receipt-title {
            margin-top: 15px;
            font-size: 18px;
            font-weight: bold;
        }

        .details {
            border-top: 1px dashed #999;
            border-bottom: 1px dashed #999;
            padding: 12px 0;
            margin-bottom: 15px;
            font-size: 13px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .detail-row:last-child {
            margin-bottom: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th {
            border-bottom: 1px solid #333;
            padding: 7px 0;
            text-align: left;
        }

        td {
            padding: 8px 0;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total {
            border-top: 1px dashed #999;
            margin-top: 10px;
            padding-top: 12px;
            display: flex;
            justify-content: space-between;
            font-size: 17px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 12px;
            color: #666;
        }

        .print-button {
            display: block;
            width: 380px;
            margin: 20px auto 0;
            padding: 10px;
            border: none;
            background: #333;
            color: #fff;
            cursor: pointer;
            font-size: 14px;
        }

        @media print {
            body {
                padding: 0;
                background: #fff;
            }

            .receipt {
                width: 100%;
                padding: 0;
            }

            .print-button {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="receipt">

        {{-- Header --}}
        <div class="header">

            <div class="brand">
                MINDOrich
            </div>

            <div class="organization">
                Pampamayanang Mangyan Ugnayan Inc.
            </div>

            <div class="receipt-title">
                SALES RECEIPT
            </div>

        </div>


        {{-- Sale Details --}}
        <div class="details">

            <div class="detail-row">
                <span>Receipt No.</span>
                <strong>{{ $sale->sale_number }}</strong>
            </div>

            <div class="detail-row">
                <span>Date</span>
                <span>
                    {{ $sale->created_at->format('M d, Y h:i A') }}
                </span>
            </div>

            <div class="detail-row">
                <span>Customer</span>
                <span>
                    {{ $sale->user->name ?? 'Walk-in Customer' }}
                </span>
            </div>

            <div class="detail-row">
                <span>Payment</span>
                <span>
                    {{ $sale->payment_method }}
                </span>
            </div>

            <div class="detail-row">
                <span>Status</span>
                <strong>
                    {{ $sale->payment_status }}
                </strong>
            </div>

        </div>


        {{-- Products --}}
        <table>

            <thead>
                <tr>
                    <th>Item</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>

            <tbody>

                @foreach($sale->saleItems as $item)

                    <tr>

                        <td>
                            {{ $item->product->product_name ?? 'Product unavailable' }}
                        </td>

                        <td class="text-center">
                            {{ $item->quantity }}
                        </td>

                        <td class="text-right">
                            ₱{{ number_format($item->subtotal, 2) }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>


        {{-- Total --}}
        <div class="total">

            <span>
                TOTAL
            </span>

            <span>
                ₱{{ number_format($sale->total_amount, 2) }}
            </span>

        </div>


        {{-- Footer --}}
        <div class="footer">

            <div>
                Thank you for supporting Mangyan communities.
            </div>

            <div>
                Please keep this receipt for your records.
            </div>

        </div>

    </div>


    {{-- Print Button --}}
    <button
        type="button"
        class="print-button"
        onclick="window.print()"
    >
        Print Receipt
    </button>

</body>
</html>