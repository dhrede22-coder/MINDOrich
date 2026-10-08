@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')

<style>

/* =========================================================
   MINDOrich PRODUCTS
   Same visual system as Reports / Analytics / Producers
========================================================= */

.products-page {
    padding-bottom: 2rem;
}

/* ---------------------------------------------------------
   ALERTS
--------------------------------------------------------- */

.products-alert {
    border-radius: 12px;
    border: 1px solid rgba(31, 41, 55, 0.08);
}

/* ---------------------------------------------------------
   HEADER
--------------------------------------------------------- */

.products-header {
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

.products-header-icon {
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

.products-header h4 {
    color: #1f2937;
}

.products-header p {
    font-size: 0.9rem;
}

/* ---------------------------------------------------------
   HEADER BUTTONS
--------------------------------------------------------- */

.products-header-btn {
    border-radius: 10px;

    padding: 0.65rem 1rem;

    font-weight: 600;

    white-space: nowrap;
}

.products-primary-btn {
    background: #c88a2b;
    border-color: #c88a2b;
    color: #ffffff;
}

.products-primary-btn:hover {
    background: #a86f1f;
    border-color: #a86f1f;
    color: #ffffff;
}

.products-promotion-btn {
    background: #2f5d50;
    border-color: #2f5d50;
    color: #ffffff;
}

.products-promotion-btn:hover {
    background: #244a40;
    border-color: #244a40;
    color: #ffffff;
}

/* ---------------------------------------------------------
   SECTION
--------------------------------------------------------- */

.products-section-icon {
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

.products-section-title {
    font-size: 0.98rem;
    font-weight: 700;

    color: #1f2937;

    margin-bottom: 0.1rem;
}

.products-section-subtitle {
    font-size: 0.78rem;

    color: #6b7280;

    margin-bottom: 0;
}

/* ---------------------------------------------------------
   KPI CARDS
--------------------------------------------------------- */

.product-kpi {
    position: relative;

    height: 100%;

    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 14px;

    padding: 1rem 1.1rem;

    box-shadow: 0 3px 10px rgba(31, 41, 55, 0.035);

    overflow: hidden;
}

.product-kpi::before {
    content: "";

    position: absolute;

    left: 0;
    top: 0;
    bottom: 0;

    width: 4px;

    background: #c88a2b;
}

.product-kpi.success::before {
    background: #198754;
}

.product-kpi.warning::before {
    background: #c88a2b;
}

.product-kpi.danger::before {
    background: #dc3545;
}

.product-kpi.info::before {
    background: #0d6efd;
}

.product-kpi-label {
    color: #6b7280;

    font-size: 0.76rem;
    font-weight: 600;

    margin-bottom: 0.25rem;
}

.product-kpi-value {
    color: #1f2937;

    font-size: 1.45rem;
    font-weight: 700;

    line-height: 1.2;
}

.product-kpi-icon {
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
   FILTER CARD
--------------------------------------------------------- */

.products-filter-card {
    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 16px;

    box-shadow: 0 4px 14px rgba(31, 41, 55, 0.04);

    overflow: hidden;
}

.products-filter-header {
    padding: 1.1rem 1.25rem 0.85rem;

    display: flex;
    align-items: center;

    gap: 0.75rem;
}

.products-filter-body {
    padding: 0 1.25rem 1.25rem;
}

.products-filter-body .form-label {
    color: #4b5563;

    font-size: 0.78rem;
    font-weight: 600;

    margin-bottom: 0.4rem;
}

.products-filter-body .form-control,
.products-filter-body .form-select {
    min-height: 42px;

    border-radius: 10px;

    border-color: rgba(31, 41, 55, 0.12);
}

.products-filter-body .form-control:focus,
.products-filter-body .form-select:focus {
    border-color: #c88a2b;

    box-shadow: 0 0 0 0.2rem rgba(200, 138, 43, 0.12);
}

.products-clear {
    color: #6b7280;

    font-size: 0.78rem;

    text-decoration: none;
}

.products-clear:hover {
    color: #a86f1f;
}

/* ---------------------------------------------------------
   DIRECTORY CARD
--------------------------------------------------------- */

.products-directory-card {
    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 16px;

    box-shadow: 0 4px 14px rgba(31, 41, 55, 0.04);

    overflow: hidden;
}

.products-directory-header {
    padding: 1.1rem 1.25rem;

    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 1rem;

    border-bottom: 1px solid rgba(31, 41, 55, 0.06);
}

.products-count {
    color: #6b7280;

    font-size: 0.75rem;

    white-space: nowrap;
}

.products-see-all {
    border-radius: 9px;

    font-size: 0.78rem;
    font-weight: 600;

    padding: 0.5rem 0.8rem;
}

/* ---------------------------------------------------------
   TABLE
--------------------------------------------------------- */

.products-table-wrapper {
    overflow-x: auto;
}

.products-table {
    margin-bottom: 0;
}

.products-table thead th {
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

.products-table tbody td {
    padding: 0.85rem 1rem;

    color: #374151;

    font-size: 0.82rem;

    border-color: rgba(31, 41, 55, 0.06);

    vertical-align: middle;
}

.products-table tbody tr:last-child td {
    border-bottom: 0;
}

.products-table tbody tr:hover {
    background: #faf7f2;
}

/* ---------------------------------------------------------
   PRODUCT IMAGE
--------------------------------------------------------- */

.product-image {
    width: 50px;
    height: 50px;

    object-fit: cover;

    border-radius: 11px;

    border: 1px solid rgba(31, 41, 55, 0.08);
}

.product-image-placeholder {
    width: 50px;
    height: 50px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 11px;

    background: #f8f9fa;

    color: #9ca3af;

    border: 1px solid rgba(31, 41, 55, 0.07);

    font-size: 1.15rem;
}

/* ---------------------------------------------------------
   PRODUCT NAME
--------------------------------------------------------- */

.product-name {
    color: #1f2937;

    font-weight: 700;

    font-size: 0.84rem;
}

.product-category {
    color: #9ca3af;

    font-size: 0.72rem;

    margin-top: 0.1rem;
}

/* ---------------------------------------------------------
   BADGES
--------------------------------------------------------- */

.product-badge {
    display: inline-flex;
    align-items: center;

    border-radius: 999px;

    padding: 0.38rem 0.65rem;

    font-size: 0.68rem;

    font-weight: 700;

    white-space: nowrap;
}

.product-badge.available {
    background: rgba(25, 135, 84, 0.10);
    color: #198754;
}

.product-badge.low {
    background: rgba(200, 138, 43, 0.12);
    color: #a86f1f;
}

.product-badge.out {
    background: rgba(220, 53, 69, 0.10);
    color: #dc3545;
}

.product-badge.archived {
    background: rgba(108, 117, 125, 0.10);
    color: #6c757d;
}

.product-featured {
    display: inline-flex;
    align-items: center;

    gap: 0.25rem;

    margin-top: 0.3rem;

    padding: 0.25rem 0.5rem;

    border-radius: 999px;

    background: rgba(200, 138, 43, 0.12);

    color: #a86f1f;

    font-size: 0.64rem;

    font-weight: 700;
}

/* ---------------------------------------------------------
   ACTION BUTTONS
--------------------------------------------------------- */

.product-action-btn {
    width: 33px;
    height: 33px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 8px;

    border: 1px solid transparent;

    font-size: 0.78rem;

    transition: 0.15s ease;
}

.product-view-btn {
    background: rgba(13, 110, 253, 0.08);
    color: #0d6efd;
}

.product-view-btn:hover {
    background: #0d6efd;
    color: #ffffff;
}

.product-edit-btn {
    background: rgba(200, 138, 43, 0.10);
    color: #a86f1f;
}

.product-edit-btn:hover {
    background: #c88a2b;
    color: #ffffff;
}

.product-stock-add-btn {
    background: rgba(25, 135, 84, 0.08);
    color: #198754;
}

.product-stock-add-btn:hover {
    background: #198754;
    color: #ffffff;
}

.product-stock-remove-btn {
    background: rgba(220, 53, 69, 0.08);
    color: #dc3545;
}

.product-stock-remove-btn:hover {
    background: #dc3545;
    color: #ffffff;
}

.product-history-btn {
    background: rgba(13, 110, 253, 0.08);
    color: #0d6efd;
}

.product-history-btn:hover {
    background: #0d6efd;
    color: #ffffff;
}

.product-delete-btn {
    background: rgba(220, 53, 69, 0.08);
    color: #dc3545;
}

.product-delete-btn:hover {
    background: #dc3545;
    color: #ffffff;
}

/* ---------------------------------------------------------
   EMPTY STATE
--------------------------------------------------------- */

.product-empty-icon {
    width: 52px;
    height: 52px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background: #f8f9fa;

    color: #9ca3af;

    font-size: 1.3rem;
}

/* ---------------------------------------------------------
   MODALS
--------------------------------------------------------- */

.product-modal {
    border: 0;

    border-radius: 16px;

    overflow: hidden;
}

.product-modal .form-control,
.product-modal textarea {
    border-radius: 10px;

    border-color: rgba(31, 41, 55, 0.12);
}

.product-modal .form-control:focus,
.product-modal textarea:focus {
    border-color: #c88a2b;

    box-shadow: 0 0 0 0.2rem rgba(200, 138, 43, 0.12);
}

.product-delete-icon {
    width: 64px;
    height: 64px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 16px;

    background: rgba(220, 53, 69, 0.08);

    color: #dc3545;

    font-size: 1.7rem;
}

/* ---------------------------------------------------------
   RESPONSIVE
--------------------------------------------------------- */

@media (max-width: 767.98px) {

    .products-header {
        padding: 1rem;
    }

    .products-header-actions {
        width: 100%;

        margin-top: 1rem;

        flex-direction: column;
    }

    .products-header-btn {
        width: 100%;
    }

    .products-directory-header {
        align-items: flex-start;

        flex-direction: column;
    }

    .products-see-all {
        width: 100%;
    }

}

</style>


<div class="container-fluid products-page">


    {{-- =====================================================
         SUCCESS
    ====================================================== --}}

    @if(session('success'))

        <div
            class="alert alert-success products-alert alert-dismissible fade show mb-4"
            role="alert"
        >

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>

        </div>

    @endif


    {{-- =====================================================
         DELETE ERROR
    ====================================================== --}}

    @if($errors->has('delete'))

        <div
            class="alert alert-danger products-alert alert-dismissible fade show mb-4"
            role="alert"
        >

            <i class="bi bi-exclamation-triangle me-2"></i>

            <strong>Unable to delete product.</strong>

            <div class="mt-1">

                {{ $errors->first('delete') }}

            </div>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>

        </div>

    @endif


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="products-header mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div class="d-flex align-items-center gap-3">

                <div class="products-header-icon">

                    <i class="bi bi-box-seam-fill"></i>

                </div>

                <div>

                    <h4 class="fw-bold mb-1">
                        Products
                    </h4>

                    <p class="text-muted mb-0">
                        Manage Mangyan handicraft products.
                    </p>

                </div>

            </div>


            <div class="products-header-actions d-flex gap-2">

                <a
                    href="{{ route('promotions.index') }}"
                    class="btn products-header-btn products-promotion-btn"
                >

                    <i class="bi bi-megaphone me-2"></i>

                    Promotions

                </a>


                <a
                    href="{{ route('products.create') }}"
                    class="btn products-header-btn products-primary-btn"
                >

                    <i class="bi bi-plus-circle me-2"></i>

                    Add Product

                </a>

            </div>

        </div>

    </div>


    {{-- =====================================================
         PRODUCT OVERVIEW
    ====================================================== --}}

    <div class="mb-4">

        <div class="d-flex align-items-center gap-2 mb-3">

            <div class="products-section-icon">

                <i class="bi bi-bar-chart-line-fill"></i>

            </div>

            <div>

                <div class="products-section-title">
                    Product Overview
                </div>

                <p class="products-section-subtitle">
                    Current product catalog and inventory status.
                </p>

            </div>

        </div>


        <div class="row g-3">


            {{-- TOTAL PRODUCTS --}}

            <div class="col-xl-3 col-md-6">

                <div class="product-kpi">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="product-kpi-label">
                                Total Products
                            </div>

                            <div class="product-kpi-value">
                                {{ number_format($totalProducts) }}
                            </div>

                        </div>

                        <div class="product-kpi-icon">

                            <i class="bi bi-box-seam"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- AVAILABLE --}}

            <div class="col-xl-3 col-md-6">

                <div class="product-kpi success">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="product-kpi-label">
                                Available
                            </div>

                            <div class="product-kpi-value">
                                {{ number_format($availableProducts) }}
                            </div>

                        </div>

                        <div class="product-kpi-icon">

                            <i class="bi bi-check-circle-fill"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- LOW STOCK --}}

            <div class="col-xl-3 col-md-6">

                <div class="product-kpi warning">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="product-kpi-label">
                                Low Stock
                            </div>

                            <div class="product-kpi-value">
                                {{ number_format($lowStockProducts) }}
                            </div>

                        </div>

                        <div class="product-kpi-icon">

                            <i class="bi bi-exclamation-triangle-fill"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- CATEGORIES --}}

            <div class="col-xl-3 col-md-6">

                <div class="product-kpi info">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="product-kpi-label">
                                Categories
                            </div>

                            <div class="product-kpi-value">
                                {{ number_format($totalCategories) }}
                            </div>

                        </div>

                        <div class="product-kpi-icon">

                            <i class="bi bi-grid-fill"></i>

                        </div>

                    </div>

                </div>

            </div>


        </div>

    </div>


    {{-- =====================================================
         SEARCH & FILTERS
    ====================================================== --}}

    <div class="products-filter-card mb-4">


        <div class="products-filter-header">

            <div class="products-section-icon">

                <i class="bi bi-funnel-fill"></i>

            </div>

            <div>

                <div class="products-section-title">
                    Search & Filters
                </div>

                <p class="products-section-subtitle">
                    Find products by name, category, craftsman, or status.
                </p>

            </div>

        </div>


        <div class="products-filter-body">

            <form
                id="productSearchForm"
                method="GET"
                action="{{ route('products.index') }}"
            >

                <div class="row g-3 align-items-end">


                    {{-- SEARCH --}}

                    <div class="col-xl-4 col-lg-4">

                        <label class="form-label">
                            Search Product
                        </label>

                        <div class="position-relative">

                            <i
                                class="bi bi-search position-absolute"
                                style="
                                    left: 14px;
                                    top: 50%;
                                    transform: translateY(-50%);
                                    color: #9ca3af;
                                    pointer-events: none;
                                "
                            ></i>

                            <input
                                type="text"
                                name="search"
                                id="productSearchInput"
                                class="form-control ps-5"
                                placeholder="Search product name..."
                                value="{{ request('search') }}"
                            >

                        </div>

                    </div>


                    {{-- CATEGORY --}}

                    <div class="col-xl-2 col-lg-2 col-md-4">

                        <label class="form-label">
                            Category
                        </label>

                        <select
                            name="category"
                            class="form-select product-auto-submit"
                        >

                            <option value="">
                                All Categories
                            </option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}
                                >

                                    {{ $category->category_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- CRAFTSMAN --}}

                    <div class="col-xl-2 col-lg-2 col-md-4">

                        <label class="form-label">
                            Craftsman
                        </label>

                        <select
                            name="producer"
                            class="form-select product-auto-submit"
                        >

                            <option value="">
                                All Craftsmen
                            </option>

                            @foreach($producers as $producer)

                                <option
                                    value="{{ $producer->id }}"
                                    {{ request('producer') == $producer->id ? 'selected' : '' }}
                                >

                                    {{ $producer->producer_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- STATUS --}}

                    <div class="col-xl-2 col-lg-2 col-md-4">

                        <label class="form-label">
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-select product-auto-submit"
                        >

                            <option value="">
                                All Status
                            </option>

                            <option
                                value="Available"
                                {{ request('status') == 'Available' ? 'selected' : '' }}
                            >
                                Available
                            </option>

                            <option
                                value="Out of Stock"
                                {{ request('status') == 'Out of Stock' ? 'selected' : '' }}
                            >
                                Out of Stock
                            </option>

                            <option
                                value="Archived"
                                {{ request('status') == 'Archived' ? 'selected' : '' }}
                            >
                                Archived
                            </option>

                        </select>

                    </div>


                    {{-- CLEAR --}}

                    <div class="col-xl-2 col-lg-2 col-md-12">

                        @if(request()->hasAny([
                            'search',
                            'category',
                            'producer',
                            'status'
                        ]))

                            <a
                                href="{{ route('products.index') }}"
                                class="products-clear"
                            >

                                <i class="bi bi-x-circle me-1"></i>

                                Clear Filters

                            </a>

                        @endif

                    </div>


                </div>

            </form>

        </div>

    </div>


    {{-- =====================================================
         PRODUCT DIRECTORY
    ====================================================== --}}

    <div class="products-directory-card">


        {{-- DIRECTORY HEADER --}}

        <div class="products-directory-header">

            <div class="d-flex align-items-center gap-3">

                <div class="products-section-icon">

                    <i class="bi bi-grid-3x3-gap-fill"></i>

                </div>

                <div>

                    <div class="products-section-title">
                        Product Directory
                    </div>

                    <p class="products-section-subtitle">
                        Manage your handicraft catalog and current stock.
                    </p>

                </div>

            </div>


            <div class="d-flex align-items-center gap-3">

                <span class="products-count">

                    {{ $products->count() }} product(s)

                </span>


                <a
                    href="{{ request()->fullUrlWithQuery(['all' => 1]) }}"
                    class="btn btn-outline-primary products-see-all"
                >

                    <i class="bi bi-box-seam me-1"></i>

                    See All Products

                </a>

            </div>

        </div>


        {{-- TABLE --}}

        <div class="products-table-wrapper">

            <table class="table products-table align-middle">

                <thead>

                    <tr>

                        <th>
                            Product
                        </th>

                        <th>
                            Category
                        </th>

                        <th>
                            Craftsman
                        </th>

                        <th>
                            Price
                        </th>

                        <th>
                            Stock
                        </th>

                        <th>
                            Status
                        </th>

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($products as $product)

                        <tr>


                            {{-- PRODUCT --}}

                            <td>

                                <div class="d-flex align-items-center gap-3">


                                    @if($product->featured_image)

                                        <img
                                            src="{{ asset('storage/' . $product->featured_image) }}"
                                            alt="{{ $product->product_name }}"
                                            class="product-image"
                                        >

                                    @else

                                        <div class="product-image-placeholder">

                                            <i class="bi bi-image"></i>

                                        </div>

                                    @endif


                                    <div>

                                        <div class="product-name">

                                            {{ $product->product_name }}

                                        </div>


                                        @if($product->featured)

                                            <span class="product-featured">

                                                <i class="bi bi-star-fill"></i>

                                                Featured

                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </td>


                            {{-- CATEGORY --}}

                            <td>

                                <span class="fw-semibold">

                                    {{ $product->category->category_name ?? '—' }}

                                </span>

                            </td>


                            {{-- CRAFTSMAN --}}

                            <td>

                                <span>

                                    {{ $product->producer->producer_name ?? '—' }}

                                </span>

                            </td>


                            {{-- PRICE --}}

                            <td>

                                <span class="fw-semibold">

                                    ₱{{ number_format($product->price, 2) }}

                                </span>

                            </td>


                            {{-- STOCK --}}

                            <td>

                                @if($product->stock <= 0)

                                    <span class="product-badge out">

                                        <i class="bi bi-x-circle me-1"></i>

                                        Out of Stock

                                    </span>

                                @elseif($product->stock <= $product->minimum_stock)

                                    <span class="product-badge low">

                                        <i class="bi bi-exclamation-triangle me-1"></i>

                                        {{ $product->stock }} Low

                                    </span>

                                @else

                                    <span class="product-badge available">

                                        <i class="bi bi-check-circle me-1"></i>

                                        {{ $product->stock }}

                                    </span>

                                @endif

                            </td>


                            {{-- STATUS --}}

                            <td>

                                @if($product->status === 'Available')

                                    <span class="product-badge available">

                                        <span class="me-1">●</span>

                                        Available

                                    </span>

                                @elseif($product->status === 'Archived')

                                    <span class="product-badge archived">

                                        <span class="me-1">●</span>

                                        Archived

                                    </span>

                                @else

                                    <span class="product-badge out">

                                        <span class="me-1">●</span>

                                        {{ $product->status }}

                                    </span>

                                @endif

                            </td>


                            {{-- ACTIONS --}}

                            <td>

                                <div class="d-flex justify-content-end gap-1 flex-nowrap">


                                    {{-- VIEW --}}

                                    <a
                                        href="{{ route('products.show', $product) }}"
                                        class="product-action-btn product-view-btn"
                                        title="View Product"
                                    >

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route('products.edit', $product) }}"
                                        class="product-action-btn product-edit-btn"
                                        title="Edit Product"
                                    >

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    {{-- ADD STOCK --}}

                                    <button
                                        type="button"
                                        class="product-action-btn product-stock-add-btn add-stock-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addStockModal"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->product_name }}"
                                        data-stock="{{ $product->stock }}"
                                        title="Add Stock"
                                    >

                                        <i class="bi bi-box-arrow-in-down"></i>

                                    </button>


                                    {{-- REMOVE STOCK --}}

                                    <button
                                        type="button"
                                        class="product-action-btn product-stock-remove-btn remove-stock-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#removeStockModal"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->product_name }}"
                                        data-stock="{{ $product->stock }}"
                                        title="Remove Stock"
                                    >

                                        <i class="bi bi-box-arrow-up"></i>

                                    </button>


                                    {{-- INVENTORY HISTORY --}}

                                    <a
                                        href="{{ route('products.inventory.history', $product) }}"
                                        class="product-action-btn product-history-btn"
                                        title="Inventory History"
                                    >

                                        <i class="bi bi-clock-history"></i>

                                    </a>


                                    {{-- DELETE --}}

                                    <button
                                        type="button"
                                        class="product-action-btn product-delete-btn delete-product-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteProductModal"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->product_name }}"
                                        title="Delete Product"
                                    >

                                        <i class="bi bi-trash"></i>

                                    </button>


                                </div>

                            </td>


                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5"
                            >

                                <div class="product-empty-icon mx-auto mb-3">

                                    <i class="bi bi-box-seam"></i>

                                </div>

                                <div class="fw-semibold text-dark mb-1">

                                    No products found

                                </div>

                                <div class="text-muted small">

                                    Try changing your search or filter criteria.

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- =========================================================
     ADD STOCK MODAL
========================================================= --}}

<div
    class="modal fade"
    id="addStockModal"
    tabindex="-1"
    aria-labelledby="addStockModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content product-modal shadow">


            <div class="modal-header border-0 px-4 pt-4">

                <div>

                    <h5
                        class="modal-title fw-bold"
                        id="addStockModalLabel"
                    >
                        Add Stock
                    </h5>

                    <small
                        class="text-muted"
                        id="addStockProductName"
                    >
                        Product
                    </small>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <form
                id="addStockForm"
                method="POST"
            >

                @csrf

                <div class="modal-body px-4">


                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Current Stock
                        </label>

                        <div
                            class="form-control bg-light"
                            id="currentStockDisplay"
                        >
                            0
                        </div>

                    </div>


                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Quantity to Add
                        </label>

                        <input
                            type="number"
                            name="quantity"
                            class="form-control"
                            placeholder="Enter quantity"
                            min="1"
                            required
                        >

                    </div>


                    <div>

                        <label class="form-label fw-semibold">
                            Remarks
                        </label>

                        <textarea
                            name="remarks"
                            class="form-control"
                            rows="3"
                            placeholder="e.g. New stock delivery"
                        ></textarea>

                    </div>

                </div>


                <div class="modal-footer border-0 px-4 pb-4">

                    <button
                        type="button"
                        class="btn btn-light border"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-success"
                    >

                        <i class="bi bi-box-arrow-in-down me-1"></i>

                        Add Stock

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =========================================================
     REMOVE STOCK MODAL
========================================================= --}}

<div
    class="modal fade"
    id="removeStockModal"
    tabindex="-1"
    aria-labelledby="removeStockModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content product-modal shadow">


            <div class="modal-header border-0 px-4 pt-4">

                <div>

                    <h5
                        class="modal-title fw-bold"
                        id="removeStockModalLabel"
                    >
                        Remove Stock
                    </h5>

                    <small
                        class="text-muted"
                        id="removeStockProductName"
                    >
                        Product
                    </small>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <form
                id="removeStockForm"
                method="POST"
            >

                @csrf

                <div class="modal-body px-4">


                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Current Stock
                        </label>

                        <div
                            class="form-control bg-light"
                            id="removeCurrentStockDisplay"
                        >
                            0
                        </div>

                    </div>


                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Quantity to Remove
                        </label>

                        <input
                            type="number"
                            name="quantity"
                            id="removeStockQuantity"
                            class="form-control"
                            placeholder="Enter quantity"
                            min="1"
                            required
                        >

                        <small
                            class="text-muted"
                            id="removeStockLimit"
                        >
                            Maximum available stock: 0
                        </small>

                    </div>


                    <div>

                        <label class="form-label fw-semibold">
                            Remarks
                        </label>

                        <textarea
                            name="remarks"
                            class="form-control"
                            rows="3"
                            placeholder="e.g. Damaged item, manual release, etc."
                        ></textarea>

                    </div>

                </div>


                <div class="modal-footer border-0 px-4 pb-4">

                    <button
                        type="button"
                        class="btn btn-light border"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-danger"
                    >

                        <i class="bi bi-box-arrow-up me-1"></i>

                        Remove Stock

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =========================================================
     DELETE PRODUCT MODAL
========================================================= --}}

<div
    class="modal fade"
    id="deleteProductModal"
    tabindex="-1"
    aria-labelledby="deleteProductModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content product-modal shadow">


            <div class="modal-header border-0 px-4 pt-4">

                <h5
                    class="modal-title fw-bold"
                    id="deleteProductModalLabel"
                >
                    Delete Product
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <form
                id="deleteProductForm"
                method="POST"
            >

                @csrf

                @method('DELETE')


                <div class="modal-body px-4">

                    <div class="text-center py-2">


                        <div class="product-delete-icon mb-3">

                            <i class="bi bi-trash"></i>

                        </div>


                        <h5 class="fw-bold">
                            Are you sure?
                        </h5>


                        <p class="text-muted mb-2">
                            You are about to delete:
                        </p>


                        <p
                            class="fw-bold mb-3"
                            id="deleteProductName"
                        >
                            Product
                        </p>


                        <div class="alert alert-warning rounded-3 mb-0">

                            <small>
                                This action cannot be undone.
                            </small>

                        </div>

                    </div>

                </div>


                <div class="modal-footer border-0 px-4 pb-4">

                    <button
                        type="button"
                        class="btn btn-light border"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>


                    <button
                        type="submit"
                        class="btn btn-danger"
                    >

                        <i class="bi bi-trash me-2"></i>

                        Delete Product

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- =========================================================
     SCRIPTS
========================================================= --}}

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {


    /* =====================================================
       ADD STOCK
    ===================================================== */

    const addStockButtons =
        document.querySelectorAll('.add-stock-btn');

    const addStockForm =
        document.getElementById('addStockForm');

    const addStockProductName =
        document.getElementById('addStockProductName');

    const currentStockDisplay =
        document.getElementById('currentStockDisplay');


    addStockButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const productId =
                this.dataset.id;

            const name =
                this.dataset.name;

            const stock =
                this.dataset.stock;


            addStockProductName.textContent =
                name;

            currentStockDisplay.textContent =
                stock;


            addStockForm.action =
                `/admin/products/${productId}/inventory/add`;

        });

    });


    /* =====================================================
       REMOVE STOCK
    ===================================================== */

    const removeStockButtons =
        document.querySelectorAll('.remove-stock-btn');

    const removeStockForm =
        document.getElementById('removeStockForm');

    const removeStockProductName =
        document.getElementById('removeStockProductName');

    const removeCurrentStockDisplay =
        document.getElementById('removeCurrentStockDisplay');

    const removeStockQuantity =
        document.getElementById('removeStockQuantity');

    const removeStockLimit =
        document.getElementById('removeStockLimit');


    removeStockButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const productId =
                this.dataset.id;

            const name =
                this.dataset.name;

            const stock =
                this.dataset.stock;


            removeStockProductName.textContent =
                name;

            removeCurrentStockDisplay.textContent =
                stock;

            removeStockQuantity.value = '';

            removeStockQuantity.max =
                stock;

            removeStockLimit.textContent =
                'Maximum available stock: ' + stock;


            removeStockForm.action =
                `/admin/products/${productId}/inventory/remove`;

        });

    });


    /* =====================================================
       DELETE PRODUCT
    ===================================================== */

    const deleteButtons =
        document.querySelectorAll('.delete-product-btn');

    const deleteForm =
        document.getElementById('deleteProductForm');

    const deleteProductName =
        document.getElementById('deleteProductName');


    deleteButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const productId =
                this.dataset.id;

            const productName =
                this.dataset.name;


            deleteProductName.textContent =
                productName;

            deleteForm.action =
                `/admin/products/${productId}`;

        });

    });


    /* =====================================================
       SEARCH + FILTERS
    ===================================================== */

    const searchForm =
        document.getElementById('productSearchForm');

    const searchInput =
        document.getElementById('productSearchInput');

    const filters =
        document.querySelectorAll('.product-auto-submit');


    let timer;


    if (searchInput) {

        searchInput.addEventListener(
            'keyup',
            function () {

                clearTimeout(timer);

                timer = setTimeout(
                    function () {

                        searchForm.submit();

                    },
                    400
                );

            }
        );

    }


    filters.forEach(function (filter) {

        filter.addEventListener(
            'change',
            function () {

                searchForm.submit();

            }
        );

    });

});

</script>

@endpush

@endsection