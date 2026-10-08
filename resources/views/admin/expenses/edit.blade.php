@extends('admin.layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Expense</h4>
            <p class="text-muted mb-0">
                Update the details of this business expense.
            </p>
        </div>

        <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Expenses
        </a>
    </div>

    {{-- Expense Form --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form action="{{ route('expenses.update', $expense) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- Expense Date --}}
                    <div class="col-md-6">
                        <label for="expense_date" class="form-label fw-semibold">
                            Expense Date <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="expense_date"
                            id="expense_date"
                            class="form-control @error('expense_date') is-invalid @enderror"
                            value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}"
                            required
                        >

                        @error('expense_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div class="col-md-6">
                        <label for="category" class="form-label fw-semibold">
                            Category <span class="text-danger">*</span>
                        </label>

                        <select
                            name="category"
                            id="category"
                            class="form-select @error('category') is-invalid @enderror"
                            required
                        >
                            <option value="">Select Category</option>

                            <option value="Administration"
                                {{ old('category', $expense->category) == 'Administration' ? 'selected' : '' }}>
                                Administration
                            </option>

                            <option value="Cost of Goods Sold"
                                {{ old('category', $expense->category) == 'Cost of Goods Sold' ? 'selected' : '' }}>
                                Cost of Goods Sold
                            </option>

                            <option value="Food"
                                {{ old('category', $expense->category) == 'Food' ? 'selected' : '' }}>
                                Food
                            </option>

                            <option value="Office Supplies"
                                {{ old('category', $expense->category) == 'Office Supplies' ? 'selected' : '' }}>
                                Office Supplies
                            </option>

                            <option value="Taxes/Penalties"
                                {{ old('category', $expense->category) == 'Taxes/Penalties' ? 'selected' : '' }}>
                                Taxes/Penalties
                            </option>

                            <option value="Travel Expenses"
                                {{ old('category', $expense->category) == 'Travel Expenses' ? 'selected' : '' }}>
                                Travel Expenses
                            </option>

                            <option value="Utilities"
                                {{ old('category', $expense->category) == 'Utilities' ? 'selected' : '' }}>
                                Utilities
                            </option>
                        </select>

                        @error('category')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="col-12">
                        <label for="description" class="form-label fw-semibold">
                            Description <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="description"
                            id="description"
                            class="form-control @error('description') is-invalid @enderror"
                            value="{{ old('description', $expense->description) }}"
                            required
                        >

                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Amount --}}
                    <div class="col-md-6">
                        <label for="amount" class="form-label fw-semibold">
                            Amount <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">₱</span>

                            <input
                                type="number"
                                name="amount"
                                id="amount"
                                class="form-control @error('amount') is-invalid @enderror"
                                value="{{ old('amount', $expense->amount) }}"
                                min="0"
                                step="0.01"
                                required
                            >
                        </div>

                        @error('amount')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Payment Method --}}
                    <div class="col-md-6">
                        <label for="payment_method" class="form-label fw-semibold">
                            Payment Method
                        </label>

                        <select
                            name="payment_method"
                            id="payment_method"
                            class="form-select @error('payment_method') is-invalid @enderror"
                        >
                            <option value="">Select Payment Method</option>

                            <option value="Cash"
                                {{ old('payment_method', $expense->payment_method) == 'Cash' ? 'selected' : '' }}>
                                Cash
                            </option>

                            <option value="GCash"
                                {{ old('payment_method', $expense->payment_method) == 'GCash' ? 'selected' : '' }}>
                                GCash
                            </option>
                        </select>

                        @error('payment_method')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Notes --}}
                    <div class="col-12">
                        <label for="notes" class="form-label fw-semibold">
                            Notes
                        </label>

                        <textarea
                            name="notes"
                            id="notes"
                            rows="4"
                            class="form-control @error('notes') is-invalid @enderror"
                            placeholder="Optional notes..."
                        >{{ old('notes', $expense->notes) }}</textarea>

                        @error('notes')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                {{-- Form Actions --}}
                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a href="{{ route('expenses.index') }}"
                       class="btn btn-outline-secondary">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>
                        Update Expense
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection