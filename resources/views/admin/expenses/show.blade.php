@extends('admin.layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Expense Details</h4>
            <p class="text-muted mb-0">
                View the details of this business expense.
            </p>
        </div>

        <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Expenses
        </a>
    </div>

    <div class="row g-4">

        {{-- Expense Information --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">Expense Information</h5>

                    <div class="row g-4">

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">
                                Expense Date
                            </div>
                            <div class="fw-semibold">
                                {{ $expense->expense_date->format('F d, Y') }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">
                                Category
                            </div>
                            <div>
                                <span class="badge bg-secondary">
                                    {{ $expense->category }}
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="text-muted small mb-1">
                                Description
                            </div>
                            <div class="fw-semibold">
                                {{ $expense->description }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">
                                Payment Method
                            </div>
                            <div class="fw-semibold">
                                {{ $expense->payment_method ?? '—' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">
                                Amount
                            </div>
                            <div class="fs-4 fw-bold text-primary">
                                ₱{{ number_format($expense->amount, 2) }}
                            </div>
                        </div>

                        @if ($expense->notes)
                            <div class="col-12">
                                <div class="text-muted small mb-1">
                                    Notes
                                </div>

                                <div class="p-3 bg-light rounded">
                                    {{ $expense->notes }}
                                </div>
                            </div>
                        @endif

                    </div>

                </div>
            </div>
        </div>

        {{-- Summary --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">Summary</h5>

                    <div class="mb-4">
                        <div class="text-muted small mb-1">
                            Expense Amount
                        </div>

                        <div class="fs-3 fw-bold">
                            ₱{{ number_format($expense->amount, 2) }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="text-muted small mb-1">
                            Category
                        </div>

                        <span class="badge bg-secondary">
                            {{ $expense->category }}
                        </span>
                    </div>

                    <div>
                        <div class="text-muted small mb-1">
                            Payment Method
                        </div>

                        <div class="fw-semibold">
                            {{ $expense->payment_method ?? '—' }}
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

@endsection