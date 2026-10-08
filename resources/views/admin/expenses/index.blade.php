@extends('admin.layouts.app')

@section('title', 'Expenses')

@section('content')

<style>

/* =========================================================
   MINDOrich EXPENSES
========================================================= */

.expenses-page {
    padding-bottom: 2rem;
}

/* ---------------------------------------------------------
   HEADER
--------------------------------------------------------- */

.expenses-header {
    background: linear-gradient(
        135deg,
        #ffffff 0%,
        #faf7f2 100%
    );

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 16px;

    padding: 1.25rem 1.5rem;

    box-shadow: 0 4px 14px rgba(31, 41, 55, 0.04);
}

.expenses-header-icon {
    width: 46px;
    height: 46px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background: rgba(200, 138, 43, 0.12);
    color: #a86f1f;

    font-size: 1.3rem;

    flex-shrink: 0;
}

.expenses-header h4 {
    color: #1f2937;
}

.expenses-header p {
    font-size: 0.9rem;
}

/* ---------------------------------------------------------
   ADD BUTTON
--------------------------------------------------------- */

.expenses-add-btn {
    background: #c88a2b;
    border-color: #c88a2b;

    color: #ffffff;

    border-radius: 10px;

    padding: 0.65rem 1rem;

    font-weight: 600;

    white-space: nowrap;
}

.expenses-add-btn:hover,
.expenses-add-btn:focus {
    background: #a86f1f;
    border-color: #a86f1f;
    color: #ffffff;
}

/* ---------------------------------------------------------
   SECTION HEADING
--------------------------------------------------------- */

.expense-section-icon {
    width: 38px;
    height: 38px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #f8f9fa;
    color: #374151;

    flex-shrink: 0;
}

.expense-section-title {
    font-size: 0.98rem;
    font-weight: 700;

    color: #1f2937;

    margin-bottom: 0.1rem;
}

.expense-section-subtitle {
    font-size: 0.78rem;

    color: #6b7280;

    margin-bottom: 0;
}

/* ---------------------------------------------------------
   KPI CARDS
--------------------------------------------------------- */

.expense-kpi {
    position: relative;

    height: 100%;

    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 14px;

    padding: 1rem 1.1rem;

    box-shadow: 0 3px 10px rgba(31, 41, 55, 0.035);

    overflow: hidden;
}

.expense-kpi::before {
    content: "";

    position: absolute;

    left: 0;
    top: 0;
    bottom: 0;

    width: 4px;

    background: #c88a2b;
}

.expense-kpi.success::before {
    background: #198754;
}

.expense-kpi.info::before {
    background: #0d6efd;
}

.expense-kpi.neutral::before {
    background: #6b7280;
}

.expense-kpi-label {
    color: #6b7280;

    font-size: 0.76rem;
    font-weight: 600;

    margin-bottom: 0.25rem;
}

.expense-kpi-value {
    color: #1f2937;

    font-size: 1.35rem;
    font-weight: 700;

    line-height: 1.2;
}

.expense-kpi-icon {
    width: 40px;
    height: 40px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #f8f9fa;

    color: #374151;

    font-size: 1.05rem;
}

/* ---------------------------------------------------------
   DIRECTORY CARD
--------------------------------------------------------- */

.expenses-directory-card {
    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 16px;

    box-shadow: 0 4px 14px rgba(31, 41, 55, 0.04);

    overflow: hidden;
}

.expenses-directory-header {
    padding: 1.1rem 1.25rem;

    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 1rem;

    border-bottom: 1px solid rgba(31, 41, 55, 0.06);
}

/* ---------------------------------------------------------
   TABLE
--------------------------------------------------------- */

.expenses-table-wrapper {
    overflow-x: auto;
}

.expenses-table {
    margin-bottom: 0;
}

.expenses-table thead th {
    background: #f8f9fa;

    color: #6b7280;

    font-size: 0.72rem;
    font-weight: 700;

    text-transform: uppercase;
    letter-spacing: 0.025em;

    padding: 0.85rem 1rem;

    border-bottom: 1px solid rgba(31, 41, 55, 0.07);

    white-space: nowrap;
}

.expenses-table tbody td {
    padding: 0.9rem 1rem;

    color: #374151;

    font-size: 0.82rem;

    border-color: rgba(31, 41, 55, 0.06);

    vertical-align: middle;
}

.expenses-table tbody tr:last-child td {
    border-bottom: 0;
}

.expenses-table tbody tr:hover {
    background: #faf7f2;
}

/* ---------------------------------------------------------
   DATE
--------------------------------------------------------- */

.expense-date {
    display: inline-flex;
    align-items: center;

    color: #4b5563;

    white-space: nowrap;
}

.expense-date i {
    color: #6b7280;
}

/* ---------------------------------------------------------
   CATEGORY
--------------------------------------------------------- */

.expense-category {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;

    background: rgba(47, 93, 80, 0.09);
    color: #2f5d50;

    border-radius: 999px;

    padding: 0.38rem 0.65rem;

    font-size: 0.68rem;
    font-weight: 700;

    white-space: nowrap;
}

.expense-category i {
    font-size: 0.7rem;
}

/* ---------------------------------------------------------
   DESCRIPTION
--------------------------------------------------------- */

.expense-description {
    color: #374151;

    max-width: 360px;

    line-height: 1.5;
}

/* ---------------------------------------------------------
   PAYMENT METHOD
--------------------------------------------------------- */

.expense-payment {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;

    color: #4b5563;

    font-size: 0.78rem;
}

.expense-payment i {
    color: #6b7280;
}

/* ---------------------------------------------------------
   AMOUNT
--------------------------------------------------------- */

.expense-amount {
    color: #1f2937;

    font-weight: 700;

    white-space: nowrap;
}

/* ---------------------------------------------------------
   ACTIONS
--------------------------------------------------------- */

.expense-action-btn {
    width: 34px;
    height: 34px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    border: 1px solid transparent;

    font-size: 0.8rem;

    transition: all 0.15s ease;
}

.expense-view-btn {
    background: rgba(47, 93, 80, 0.08);
    color: #2f5d50;
}

.expense-view-btn:hover {
    background: #2f5d50;
    color: #ffffff;
}

.expense-edit-btn {
    background: rgba(200, 138, 43, 0.10);
    color: #a86f1f;
}

.expense-edit-btn:hover {
    background: #c88a2b;
    color: #ffffff;
}

.expense-delete-btn {
    background: rgba(220, 53, 69, 0.08);
    color: #dc3545;
}

.expense-delete-btn:hover {
    background: #dc3545;
    color: #ffffff;
}

/* ---------------------------------------------------------
   EMPTY STATE
--------------------------------------------------------- */

.expense-empty-icon {
    width: 56px;
    height: 56px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 14px;

    background: #f8f9fa;

    color: #9ca3af;

    font-size: 1.4rem;
}

/* ---------------------------------------------------------
   RESPONSIVE
--------------------------------------------------------- */

@media (max-width: 767.98px) {

    .expenses-header {
        padding: 1rem;
    }

    .expenses-header-action {
        width: 100%;
    }

    .expenses-add-btn {
        width: 100%;
    }

    .expenses-directory-header {
        align-items: flex-start;
        flex-direction: column;
    }

}

</style>


<div class="container-fluid expenses-page">


    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="expenses-header mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div class="d-flex align-items-center gap-3">

                <div class="expenses-header-icon">

                    <i class="bi bi-wallet2"></i>

                </div>

                <div>

                    <h4 class="fw-bold mb-1">
                        Expenses
                    </h4>

                    <p class="text-muted mb-0">
                        Manage and monitor business expenses.
                    </p>

                </div>

            </div>


            <div class="expenses-header-action">

                <a
                    href="{{ route('expenses.create') }}"
                    class="btn expenses-add-btn"
                >

                    <i class="bi bi-plus-circle me-2"></i>

                    Add Expense

                </a>

            </div>

        </div>

    </div>


    {{-- =====================================================
         EXPENSE OVERVIEW
    ====================================================== --}}

    <div class="mb-4">

        <div class="d-flex align-items-center gap-2 mb-3">

            <div class="expense-section-icon">

                <i class="bi bi-bar-chart-line-fill"></i>

            </div>

            <div>

                <div class="expense-section-title">
                    Expense Overview
                </div>

                <p class="expense-section-subtitle">
                    Quick summary of recorded business expenses.
                </p>

            </div>

        </div>


        <div class="row g-3">


            {{-- TOTAL EXPENSE RECORDS --}}

            <div class="col-xl-3 col-md-6">

                <div class="expense-kpi">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="expense-kpi-label">
                                Expense Records
                            </div>

                            <div class="expense-kpi-value">

                                {{ number_format($expenses->count()) }}

                            </div>

                        </div>

                        <div class="expense-kpi-icon">

                            <i class="bi bi-receipt"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- TOTAL AMOUNT --}}

            <div class="col-xl-3 col-md-6">

                <div class="expense-kpi warning">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="expense-kpi-label">
                                Total Expenses
                            </div>

                            <div class="expense-kpi-value">

                                ₱{{ number_format($expenses->sum('amount'), 2) }}

                            </div>

                        </div>

                        <div class="expense-kpi-icon">

                            <i class="bi bi-cash-stack"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- CASH --}}

            <div class="col-xl-3 col-md-6">

                <div class="expense-kpi success">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="expense-kpi-label">
                                Cash Expenses
                            </div>

                            <div class="expense-kpi-value">

                                ₱{{ number_format(
                                    $expenses->where('payment_method', 'Cash')->sum('amount'),
                                    2
                                ) }}

                            </div>

                        </div>

                        <div class="expense-kpi-icon">

                            <i class="bi bi-cash"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- GCASH --}}

            <div class="col-xl-3 col-md-6">

                <div class="expense-kpi info">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="expense-kpi-label">
                                GCash Expenses
                            </div>

                            <div class="expense-kpi-value">

                                ₱{{ number_format(
                                    $expenses->where('payment_method', 'GCash')->sum('amount'),
                                    2
                                ) }}

                            </div>

                        </div>

                        <div class="expense-kpi-icon">

                            <i class="bi bi-phone"></i>

                        </div>

                    </div>

                </div>

            </div>


        </div>

    </div>


    {{-- =====================================================
         EXPENSE DIRECTORY
    ====================================================== --}}

    <div class="expenses-directory-card">


        <div class="expenses-directory-header">

            <div class="d-flex align-items-center gap-3">

                <div class="expense-section-icon">

                    <i class="bi bi-receipt-cutoff"></i>

                </div>

                <div>

                    <div class="expense-section-title">
                        Expense Directory
                    </div>

                    <p class="expense-section-subtitle">
                        View and manage recorded business expenses.
                    </p>

                </div>

            </div>


            <div class="text-muted small">

                {{ $expenses->count() }}

                {{ $expenses->count() === 1 ? 'expense' : 'expenses' }}

            </div>

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}

        <div class="expenses-table-wrapper">

            <table class="table expenses-table align-middle">

                <thead>

                    <tr>

                        <th>
                            Date
                        </th>

                        <th>
                            Category
                        </th>

                        <th>
                            Description
                        </th>

                        <th>
                            Payment Method
                        </th>

                        <th class="text-end">
                            Amount
                        </th>

                        <th
                            class="text-end"
                            style="width: 140px;"
                        >
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($expenses as $expense)

                        <tr>


                            {{-- DATE --}}

                            <td>

                                <span class="expense-date">

                                    <i class="bi bi-calendar3 me-2"></i>

                                    {{ $expense->expense_date->format('M d, Y') }}

                                </span>

                            </td>


                            {{-- CATEGORY --}}

                            <td>

                                <span class="expense-category">

                                    <i class="bi bi-tag-fill"></i>

                                    {{ $expense->category }}

                                </span>

                            </td>


                            {{-- DESCRIPTION --}}

                            <td>

                                <div class="expense-description">

                                    {{ $expense->description }}

                                </div>

                            </td>


                            {{-- PAYMENT METHOD --}}

                            <td>

                                @if($expense->payment_method)

                                    <span class="expense-payment">

                                        @if($expense->payment_method === 'Cash')

                                            <i class="bi bi-cash"></i>

                                        @elseif($expense->payment_method === 'GCash')

                                            <i class="bi bi-phone"></i>

                                        @else

                                            <i class="bi bi-credit-card"></i>

                                        @endif

                                        {{ $expense->payment_method }}

                                    </span>

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- AMOUNT --}}

                            <td class="text-end">

                                <span class="expense-amount">

                                    ₱{{ number_format($expense->amount, 2) }}

                                </span>

                            </td>


                            {{-- ACTIONS --}}

                            <td class="text-end">

                                <div class="d-flex justify-content-end gap-1">


                                    {{-- VIEW --}}

                                    <a
                                        href="{{ route('expenses.show', $expense) }}"
                                        class="expense-action-btn expense-view-btn"
                                        title="View"
                                    >

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route('expenses.edit', $expense) }}"
                                        class="expense-action-btn expense-edit-btn"
                                        title="Edit"
                                    >

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    {{-- DELETE --}}

                                    <form
                                        action="{{ route('expenses.destroy', $expense) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this expense?');"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="expense-action-btn expense-delete-btn"
                                            title="Delete"
                                        >

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>


                                </div>

                            </td>


                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center py-5"
                            >

                                <div class="expense-empty-icon mx-auto mb-3">

                                    <i class="bi bi-receipt"></i>

                                </div>

                                <h6 class="fw-semibold">
                                    No Expenses Found
                                </h6>

                                <p class="text-muted mb-3">

                                    No expenses have been recorded yet.

                                </p>

                                <a
                                    href="{{ route('expenses.create') }}"
                                    class="btn expenses-add-btn"
                                >

                                    <i class="bi bi-plus-circle me-1"></i>

                                    Add Expense

                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection