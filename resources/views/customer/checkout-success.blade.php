@extends('customer.layouts.customer')

@section('title', 'Order Successful')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card border-0 shadow-sm rounded-4 text-center">

                <div class="card-body p-5">

                    {{-- Success Icon --}}
                    <div class="mb-4">
                        <div
                            class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center"
                            style="width:90px;height:90px;"
                        >
                            <i class="bi bi-check-circle-fill text-success"
                               style="font-size:50px;">
                            </i>
                        </div>
                    </div>

                    <h1 class="fw-bold mb-3">
                        Purchase Successful!
                    </h1>

                    <p class="text-muted mb-4">
                        Thank you for your order. Your order has been successfully placed.
                    </p>

                    {{-- Order Number --}}
                    <div class="bg-light rounded-3 p-3 mb-4">

                        <small class="text-muted d-block">
                            Order Number
                        </small>

                        <strong class="fs-5">
                            {{ $sale->sale_number }}
                        </strong>

                    </div>

                    {{-- Total --}}
                    <div class="d-flex justify-content-between border-bottom py-3">

                        <span class="text-muted">
                            Total Amount
                        </span>

                        <strong class="text-warning fs-5">
                            ₱{{ number_format($sale->total_amount, 2) }}
                        </strong>

                    </div>

                    {{-- Payment --}}
                    <div class="d-flex justify-content-between border-bottom py-3">

                        <span class="text-muted">
                            Payment Method
                        </span>

                        <strong>
                            {{ $sale->payment_method }}
                        </strong>

                    </div>

                    {{-- Status --}}
                    <div class="d-flex justify-content-between py-3">

                        <span class="text-muted">
                            Order Status
                        </span>

                        <span class="badge bg-warning text-dark">
                            {{ $sale->status }}
                        </span>

                    </div>

                    {{-- Buttons --}}
                    <div class="d-grid gap-2 mt-4">

                        <a
    href="{{ route('customer.dashboard') }}"
    class="btn btn-warning btn-lg"
>
    Back to Home
</a>

                        <a
                            href="{{ route('customer.shop') }}"
                            class="btn btn-outline-secondary"
                        >
                            Continue Shopping
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection