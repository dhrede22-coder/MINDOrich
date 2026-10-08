@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')

<style>

/* =========================================================
   MINDOrich CATEGORIES
   Same visual system as Reports / Analytics / Products
========================================================= */

.categories-page {
    padding-bottom: 2rem;
}

/* ---------------------------------------------------------
   ALERTS
--------------------------------------------------------- */

.categories-alert {
    border-radius: 12px;
    border: 1px solid rgba(31, 41, 55, 0.08);
}

/* ---------------------------------------------------------
   HEADER
--------------------------------------------------------- */

.categories-header {
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

.categories-header-icon {
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

.categories-header h4 {
    color: #1f2937;
}

.categories-header p {
    font-size: 0.9rem;
}

/* ---------------------------------------------------------
   ADD BUTTON
--------------------------------------------------------- */

.categories-add-btn {
    background: #c88a2b;
    border-color: #c88a2b;

    color: #ffffff;

    border-radius: 10px;

    padding: 0.65rem 1rem;

    font-weight: 600;

    white-space: nowrap;
}

.categories-add-btn:hover,
.categories-add-btn:focus {
    background: #a86f1f;
    border-color: #a86f1f;
    color: #ffffff;
}

/* ---------------------------------------------------------
   SECTION
--------------------------------------------------------- */

.categories-section-icon {
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

.categories-section-title {
    font-size: 0.98rem;
    font-weight: 700;

    color: #1f2937;

    margin-bottom: 0.1rem;
}

.categories-section-subtitle {
    font-size: 0.78rem;

    color: #6b7280;

    margin-bottom: 0;
}

/* ---------------------------------------------------------
   KPI CARDS
--------------------------------------------------------- */

.category-kpi {
    position: relative;

    height: 100%;

    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 14px;

    padding: 1rem 1.1rem;

    box-shadow: 0 3px 10px rgba(31, 41, 55, 0.035);

    overflow: hidden;
}

.category-kpi::before {
    content: "";

    position: absolute;

    left: 0;
    top: 0;
    bottom: 0;

    width: 4px;

    background: #c88a2b;
}

.category-kpi.success::before {
    background: #198754;
}

.category-kpi.warning::before {
    background: #c88a2b;
}

.category-kpi.neutral::before {
    background: #6b7280;
}

.category-kpi-label {
    color: #6b7280;

    font-size: 0.76rem;
    font-weight: 600;

    margin-bottom: 0.25rem;
}

.category-kpi-value {
    color: #1f2937;

    font-size: 1.45rem;
    font-weight: 700;

    line-height: 1.2;
}

.category-kpi-icon {
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

.categories-directory-card {
    background: #ffffff;

    border: 1px solid rgba(31, 41, 55, 0.08);
    border-radius: 16px;

    box-shadow: 0 4px 14px rgba(31, 41, 55, 0.04);

    overflow: hidden;
}

.categories-directory-header {
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

.categories-table-wrapper {
    overflow-x: auto;
}

.categories-table {
    margin-bottom: 0;
}

.categories-table thead th {
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

.categories-table tbody td {
    padding: 0.9rem 1rem;

    color: #374151;

    font-size: 0.82rem;

    border-color: rgba(31, 41, 55, 0.06);

    vertical-align: middle;
}

.categories-table tbody tr:last-child td {
    border-bottom: 0;
}

.categories-table tbody tr:hover {
    background: #faf7f2;
}

/* ---------------------------------------------------------
   CATEGORY NAME
--------------------------------------------------------- */

.category-name-wrapper {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.category-icon {
    width: 38px;
    height: 38px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: rgba(200, 138, 43, 0.10);

    color: #a86f1f;

    flex-shrink: 0;
}

.category-name {
    color: #1f2937;

    font-weight: 700;

    font-size: 0.84rem;
}

/* ---------------------------------------------------------
   DESCRIPTION
--------------------------------------------------------- */

.category-description {
    max-width: 360px;

    color: #6b7280;

    line-height: 1.5;
}

/* ---------------------------------------------------------
   STATUS
--------------------------------------------------------- */

.category-status {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;

    padding: 0.38rem 0.65rem;

    border-radius: 999px;

    font-size: 0.68rem;

    font-weight: 700;
}

.category-status.active {
    background: rgba(25, 135, 84, 0.10);
    color: #198754;
}

.category-status.inactive {
    background: rgba(108, 117, 125, 0.10);
    color: #6c757d;
}

.category-status-dot {
    width: 6px;
    height: 6px;

    border-radius: 50%;

    background: currentColor;
}

/* ---------------------------------------------------------
   PRODUCT COUNT
--------------------------------------------------------- */

.category-product-count {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;

    font-weight: 700;

    color: #374151;
}

.category-product-count i {
    color: #6b7280;
}

/* ---------------------------------------------------------
   ACTIONS
--------------------------------------------------------- */

.category-action-btn {
    width: 34px;
    height: 34px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    border: 1px solid transparent;

    font-size: 0.8rem;
}

.category-edit-btn {
    background: rgba(200, 138, 43, 0.10);
    color: #a86f1f;
}

.category-edit-btn:hover {
    background: #c88a2b;
    color: #ffffff;
}

.category-delete-btn {
    background: rgba(220, 53, 69, 0.08);
    color: #dc3545;
}

.category-delete-btn:hover {
    background: #dc3545;
    color: #ffffff;
}

.category-disabled-btn {
    background: #f3f4f6;
    color: #9ca3af;
    cursor: not-allowed;
}

/* ---------------------------------------------------------
   EMPTY STATE
--------------------------------------------------------- */

.category-empty-icon {
    width: 52px;
    height: 52px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background: #f8f9fa;

    color: #9ca3af;

    font-size: 1.25rem;
}

/* ---------------------------------------------------------
   RESPONSIVE
--------------------------------------------------------- */

@media (max-width: 767.98px) {

    .categories-header {
        padding: 1rem;
    }

    .categories-header-action {
        width: 100%;

        margin-top: 1rem;
    }

    .categories-add-btn {
        width: 100%;
    }

    .categories-directory-header {
        align-items: flex-start;

        flex-direction: column;
    }

}

</style>


<div class="container-fluid categories-page">


    {{-- =====================================================
         SUCCESS
    ====================================================== --}}

    @if(session('success'))

        <div
            class="alert alert-success categories-alert alert-dismissible fade show mb-4"
            role="alert"
        >

            <i class="bi bi-check-circle-fill me-2"></i>

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
            class="alert alert-danger categories-alert alert-dismissible fade show mb-4"
            role="alert"
        >

            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            {{ $errors->first('delete') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>

        </div>

    @endif


    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="categories-header mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div class="d-flex align-items-center gap-3">

                <div class="categories-header-icon">

                    <i class="bi bi-grid-fill"></i>

                </div>

                <div>

                    <h4 class="fw-bold mb-1">
                        Categories
                    </h4>

                    <p class="text-muted mb-0">
                        Manage product categories.
                    </p>

                </div>

            </div>


            <div class="categories-header-action">

                <a
                    href="{{ route('categories.create') }}"
                    class="btn categories-add-btn"
                >

                    <i class="bi bi-plus-circle me-2"></i>

                    Add Category

                </a>

            </div>

        </div>

    </div>


    {{-- =====================================================
         CATEGORY OVERVIEW
    ====================================================== --}}

    <div class="mb-4">

        <div class="d-flex align-items-center gap-2 mb-3">

            <div class="categories-section-icon">

                <i class="bi bi-bar-chart-line-fill"></i>

            </div>

            <div>

                <div class="categories-section-title">
                    Category Overview
                </div>

                <p class="categories-section-subtitle">
                    A quick summary of your product categories.
                </p>

            </div>

        </div>


        <div class="row g-3">


            {{-- TOTAL CATEGORIES --}}

            <div class="col-xl-4 col-md-6">

                <div class="category-kpi">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="category-kpi-label">
                                Total Categories
                            </div>

                            <div class="category-kpi-value">

                                {{ number_format($categories->count()) }}

                            </div>

                        </div>

                        <div class="category-kpi-icon">

                            <i class="bi bi-grid-fill"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ACTIVE --}}

            <div class="col-xl-4 col-md-6">

                <div class="category-kpi success">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="category-kpi-label">
                                Active Categories
                            </div>

                            <div class="category-kpi-value">

                                {{ number_format(
                                    $categories->where('status', 'Active')->count()
                                ) }}

                            </div>

                        </div>

                        <div class="category-kpi-icon">

                            <i class="bi bi-check-circle-fill"></i>

                        </div>

                    </div>

                </div>

            </div>


            {{-- INACTIVE --}}

            <div class="col-xl-4 col-md-6">

                <div class="category-kpi neutral">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="category-kpi-label">
                                Inactive Categories
                            </div>

                            <div class="category-kpi-value">

                                {{ number_format(
                                    $categories->where('status', '!=', 'Active')->count()
                                ) }}

                            </div>

                        </div>

                        <div class="category-kpi-icon">

                            <i class="bi bi-dash-circle-fill"></i>

                        </div>

                    </div>

                </div>

            </div>


        </div>

    </div>


    {{-- =====================================================
         CATEGORY DIRECTORY
    ====================================================== --}}

    <div class="categories-directory-card">


        <div class="categories-directory-header">

            <div class="d-flex align-items-center gap-3">

                <div class="categories-section-icon">

                    <i class="bi bi-grid-3x3-gap-fill"></i>

                </div>

                <div>

                    <div class="categories-section-title">
                        Category Directory
                    </div>

                    <p class="categories-section-subtitle">
                        Manage the categories used throughout your product catalog.
                    </p>

                </div>

            </div>


            <div class="text-muted small">

                {{ $categories->count() }}
                {{ $categories->count() === 1 ? 'category' : 'categories' }}

            </div>

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}

        <div class="categories-table-wrapper">

            <table class="table categories-table align-middle">

                <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            Category
                        </th>

                        <th>
                            Description
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Products
                        </th>

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($categories as $category)

                        <tr>


                            {{-- NUMBER --}}

                            <td>

                                <span class="text-muted fw-semibold">

                                    {{ $loop->iteration }}

                                </span>

                            </td>


                            {{-- CATEGORY --}}

                            <td>

                                <div class="category-name-wrapper">

                                    <div class="category-icon">

                                        <i class="bi bi-grid-3x3-gap"></i>

                                    </div>

                                    <div>

                                        <div class="category-name">

                                            {{ $category->category_name }}

                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- DESCRIPTION --}}

                            <td>

                                @if($category->description)

                                    <div class="category-description">

                                        {{ $category->description }}

                                    </div>

                                @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- STATUS --}}

                            <td>

                                @if($category->status === 'Active')

                                    <span class="category-status active">

                                        <span class="category-status-dot"></span>

                                        Active

                                    </span>

                                @else

                                    <span class="category-status inactive">

                                        <span class="category-status-dot"></span>

                                        Inactive

                                    </span>

                                @endif

                            </td>


                            {{-- PRODUCTS --}}

                            <td>

                                <span class="category-product-count">

                                    <i class="bi bi-box-seam"></i>

                                    {{ number_format($category->products_count) }}

                                </span>

                            </td>


                            {{-- ACTIONS --}}

                            <td class="text-end">

                                <div class="d-flex justify-content-end gap-1">


                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route('categories.edit', $category) }}"
                                        class="category-action-btn category-edit-btn"
                                        title="Edit Category"
                                    >

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    {{-- DELETE --}}

                                    @if($category->products_count === 0)

                                        <form
                                            action="{{ route('categories.destroy', $category) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this category?');"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="category-action-btn category-delete-btn"
                                                title="Delete Category"
                                            >

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>

                                    @else

                                        <button
                                            type="button"
                                            class="category-action-btn category-disabled-btn"
                                            disabled
                                            title="This category is currently assigned to products."
                                        >

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    @endif


                                </div>

                            </td>


                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center py-5"
                            >

                                <div class="category-empty-icon mx-auto mb-3">

                                    <i class="bi bi-grid"></i>

                                </div>

                                <div class="fw-semibold text-dark mb-1">

                                    No categories found.

                                </div>

                                <div class="text-muted small">

                                    Add a category to organize your products.

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection