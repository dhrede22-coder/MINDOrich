@extends('admin.layouts.app')

@section('title', 'Edit Promotion')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Edit Promotion
            </h2>

            <p class="text-muted mb-0">
                Update promotion details and assigned products.
            </p>
        </div>

        <a
            href="{{ route('promotions.index') }}"
            class="btn btn-light border"
        >
            <i class="bi bi-arrow-left me-1"></i>
            Back to Promotions
        </a>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <div class="fw-semibold mb-2">
                Please fix the following:
            </div>

            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form
        action="{{ route('promotions.update', $promotion) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- Promotion Details --}}
            <div class="col-lg-7">

                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4">
                            Promotion Details
                        </h5>


                        {{-- Promotion Name --}}
                        <div class="mb-4">

                            <label
                                for="name"
                                class="form-label fw-semibold"
                            >
                                Promotion Name
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control"
                                value="{{ old('name', $promotion->name) }}"
                                maxlength="255"
                                required
                            >

                        </div>


                        {{-- Discount --}}
                        <div class="row g-3">

                            <div class="col-md-6">

                                <label
                                    for="discount_type"
                                    class="form-label fw-semibold"
                                >
                                    Discount Type
                                </label>

                                <select
                                    id="discount_type"
                                    name="discount_type"
                                    class="form-select"
                                    required
                                >
                                    <option
                                        value="percentage"
                                        {{ old('discount_type', $promotion->discount_type) === 'percentage' ? 'selected' : '' }}
                                    >
                                        Percentage (%)
                                    </option>

                                    <option
                                        value="fixed"
                                        {{ old('discount_type', $promotion->discount_type) === 'fixed' ? 'selected' : '' }}
                                    >
                                        Fixed Amount (₱)
                                    </option>
                                </select>

                            </div>


                            <div class="col-md-6">

                                <label
                                    for="discount_value"
                                    class="form-label fw-semibold"
                                >
                                    Discount Value
                                </label>

                                <input
                                    type="number"
                                    id="discount_value"
                                    name="discount_value"
                                    class="form-control"
                                    value="{{ old('discount_value', $promotion->discount_value) }}"
                                    min="0.01"
                                    step="0.01"
                                    required
                                >

                            </div>

                        </div>


                        {{-- Schedule --}}
                        <div class="mt-4">

                            <h6 class="fw-bold mb-3">
                                Promotion Schedule
                            </h6>

                            <div class="row g-3">

                                <div class="col-md-6">

                                    <label
                                        for="starts_at"
                                        class="form-label fw-semibold"
                                    >
                                        Start Date
                                    </label>

                                    <input
                                        type="datetime-local"
                                        id="starts_at"
                                        name="starts_at"
                                        class="form-control"
                                        value="{{ old(
                                            'starts_at',
                                            $promotion->starts_at
                                                ? $promotion->starts_at->format('Y-m-d\TH:i')
                                                : ''
                                        ) }}"
                                    >

                                </div>


                                <div class="col-md-6">

                                    <label
                                        for="ends_at"
                                        class="form-label fw-semibold"
                                    >
                                        End Date
                                    </label>

                                    <input
                                        type="datetime-local"
                                        id="ends_at"
                                        name="ends_at"
                                        class="form-control"
                                        value="{{ old(
                                            'ends_at',
                                            $promotion->ends_at
                                                ? $promotion->ends_at->format('Y-m-d\TH:i')
                                                : ''
                                        ) }}"
                                    >

                                </div>

                            </div>

                        </div>


                        {{-- Status --}}
                        <div class="mt-4">

                            <input
                                type="hidden"
                                name="status"
                                value="0"
                            >

                            <div class="form-check form-switch">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    role="switch"
                                    id="status"
                                    name="status"
                                    value="1"
                                    {{ old('status', $promotion->status ? '1' : '0') === '1' ? 'checked' : '' }}
                                >

                                <label
                                    class="form-check-label fw-semibold"
                                    for="status"
                                >
                                    Active Promotion
                                </label>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Products --}}
            <div class="col-lg-5">

                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-1">
                            Assign Products
                        </h5>

                        <p class="text-muted small mb-4">
                            Select the products included in this promotion.
                        </p>


                        @if($products->count())

                            @php
                                $selectedProducts = old(
                                    'product_ids',
                                    $promotion->products->pluck('id')->toArray()
                                );
                            @endphp

                            <select
                                name="product_ids[]"
                                id="product_ids"
                                class="form-select"
                                multiple
                                size="12"
                            >

                                @foreach($products as $product)

                                    <option
                                        value="{{ $product->id }}"
                                        {{ in_array($product->id, $selectedProducts) ? 'selected' : '' }}
                                    >
                                        {{ $product->product_name }}
                                        — ₱{{ number_format($product->price, 2) }}
                                    </option>

                                @endforeach

                            </select>

                            <div class="form-text">
                                Hold Ctrl (Windows) or Command (Mac) to select multiple products.
                            </div>

                        @else

                            <div class="alert alert-warning mb-0">
                                No products are currently available.
                            </div>

                        @endif

                    </div>

                </div>


                {{-- Actions --}}
                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a
                        href="{{ route('promotions.index') }}"
                        class="btn btn-light border"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="btn btn-warning"
                    >
                        <i class="bi bi-check-lg me-1"></i>
                        Save Changes
                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection