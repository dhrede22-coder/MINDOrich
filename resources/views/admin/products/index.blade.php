@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
{{-- Success Message --}}
@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4"
         role="alert">

        <i class="bi bi-check-circle me-2"></i>

        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
        </button>

    </div>

@endif


{{-- Error Message --}}
@if($errors->has('delete'))

    <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4"
         role="alert">

        <i class="bi bi-exclamation-triangle me-2"></i>

        <strong>Unable to delete product.</strong>

        <div class="mt-1">
            {{ $errors->first('delete') }}
        </div>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
        </button>

    </div>

@endif

<div class="container-fluid">

    <!-- Header -->
     
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Products

            </h2>

            <p class="text-muted mb-0">

                Manage Mangyan handicraft products.

            </p>

        </div>
        

        <a href="{{ route('products.create') }}"
           class="btn btn-warning">

            <i class="bi bi-plus-circle me-2"></i>

            Add Product

        </a>

    </div>

</div>
<!-- Statistics -->
<div class="row g-4 mb-4">

    <div class="col-lg-3">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">

                            Total Products

                        </small>

                        <h2 class="fw-bold mt-2 mb-0">

                            {{ $totalProducts }}

                        </h2>

                    </div>

                    <i class="bi bi-box-seam fs-1 text-warning"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-3">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">

                            Available

                        </small>

                        <h2 class="fw-bold mt-2 mb-0">

                            {{ $availableProducts }}

                        </h2>

                    </div>

                    <i class="bi bi-check-circle-fill fs-1 text-success"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-3">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">

                            Low Stock

                        </small>

                        <h2 class="fw-bold mt-2 mb-0">

                            {{ $lowStockProducts }}

                        </h2>

                    </div>

                    <i class="bi bi-exclamation-triangle-fill fs-1 text-danger"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-3">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">

                            Categories

                        </small>

                        <h2 class="fw-bold mt-2 mb-0">

                            {{ $totalCategories }}

                        </h2>

                    </div>

                    <i class="bi bi-grid-fill fs-1 text-primary"></i>

                </div>

            </div>

        </div>

    </div>

</div>
<!-- Search & Filters -->
<div class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-body">

        <form id="productSearchForm"
              method="GET"
              action="{{ route('products.index') }}">

            <div class="row g-3 align-items-center">

                <!-- Search -->
                <div class="col-lg-4">

                    <input
                        type="text"
                        name="search"
                        id="productSearchInput"
                        class="form-control"
                        placeholder="🔍 Search product..."
                        value="{{ request('search') }}">

                </div>

                <!-- Category -->
                <div class="col-lg-2">

                    <select
                        name="category"
                        class="form-select product-auto-submit">

                        <option value="">
                            All Categories
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>

                                {{ $category->category_name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <!-- Craftsman -->
                <div class="col-lg-2">

                    <select
                        name="producer"
                        class="form-select product-auto-submit">

                        <option value="">
                            All Craftsmen
                        </option>

                        @foreach($producers as $producer)

                            <option
                                value="{{ $producer->id }}"
                                {{ request('producer') == $producer->id ? 'selected' : '' }}>

                                {{ $producer->producer_name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <!-- Status -->
                <div class="col-lg-2">

                    <select
                        name="status"
                        class="form-select product-auto-submit">

                        <option value="">
                            All Status
                        </option>

                        <option
                            value="Available"
                            {{ request('status') == 'Available' ? 'selected' : '' }}>

                            Available

                        </option>

                        <option
                            value="Out of Stock"
                            {{ request('status') == 'Out of Stock' ? 'selected' : '' }}>

                            Out of Stock

                        </option>

                        <option
                            value="Archived"
                            {{ request('status') == 'Archived' ? 'selected' : '' }}>

                            Archived

                        </option>

                    </select>

                </div>

                <!-- Clear -->
                <div class="col-lg-2 text-end">

                    @if(request()->hasAny([
                        'search',
                        'category',
                        'producer',
                        'status'
                    ]))

                        <a href="{{ route('products.index') }}"
                           class="text-decoration-none small">

                            Clear Filters

                        </a>

                    @endif

                </div>

            </div>

        </form>

    </div>

</div>
<!-- Product Table -->

<div class="d-flex justify-content-end mb-3">

    <a href="{{ request()->fullUrlWithQuery(['all' => 1]) }}"
       class="btn btn-outline-primary">

        <i class="bi bi-box-seam me-2"></i>

        See All Products

    </a>

</div>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>

                <h5 class="fw-bold mb-1">
                    Products
                </h5>

                <small class="text-muted">
                    Manage your handicraft products.
                </small>

            </div>

            <span class="text-muted small">

                {{ $products->count() }} product(s)

            </span>

        </div>

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>Image</th>

                        <th>Product</th>

                        <th>Category</th>

                        <th>Craftsman</th>

                        <th>Price</th>

                        <th>Stock</th>

                        <th>Status</th>

                        <th width="150">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($products as $product)

                        <tr>

                            <!-- Image -->
                            <td>

                                @if($product->featured_image)

                                    <img
                                        src="{{ asset('storage/' . $product->featured_image) }}"
                                        width="55"
                                        height="55"
                                        class="rounded-3"
                                        style="object-fit: cover;">

                                @else

                                    <div
                                        class="bg-light rounded-3 d-flex align-items-center justify-content-center"
                                        style="width:55px;height:55px;">

                                        <i class="bi bi-image text-muted fs-4"></i>

                                    </div>

                                @endif

                            </td>

                            <!-- Product Name -->
                            <td>

                                <div class="fw-semibold">

                                    {{ $product->product_name }}

                                </div>

                                @if($product->featured)

                                    <span class="badge bg-warning text-dark mt-1">

                                        <i class="bi bi-star-fill me-1"></i>

                                        Featured

                                    </span>

                                @endif

                            </td>

                            <!-- Category -->
                            <td>

                                {{ $product->category->category_name ?? '—' }}

                            </td>

                            <!-- Craftsman -->
                            <td>

                                {{ $product->producer->producer_name ?? '—' }}

                            </td>

                            <!-- Price -->
                            <td>

                                ₱{{ number_format($product->price, 2) }}

                            </td>

                            <!-- Stock -->
                            <td>

                                @if($product->stock <= 0)

                                    <span class="badge bg-danger">

                                        Out of Stock

                                    </span>

                                @elseif($product->stock <= $product->minimum_stock)

                                    <span class="badge bg-warning text-dark">

                                        {{ $product->stock }} Low

                                    </span>

                                @else

                                    <span class="badge bg-success">

                                        {{ $product->stock }}

                                    </span>

                                @endif

                            </td>

                            <!-- Status -->
                            <td>

                                @if($product->status === 'Available')

                                    <span class="badge bg-success">

                                        Available

                                    </span>

                                @elseif($product->status === 'Archived')

                                    <span class="badge bg-secondary">

                                        Archived

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        {{ $product->status }}

                                    </span>

                                @endif

                            </td>

                            <!-- Actions -->
                        
                            <td style="min-width: 220px;">
                                <div class="d-flex align-items-center gap-1 flex-nowrap">


        {{-- View --}}                        
<a href="{{ route('products.show', $product) }}"
   class="btn btn-sm btn-primary"
   title="View Product">

    <i class="bi bi-eye"></i>

</a>


{{-- Edit --}}
<a href="{{ route('products.edit', $product) }}"
   class="btn btn-sm btn-warning"
   title="Edit Product">

    <i class="bi bi-pencil"></i>

</a>


{{-- Add Stock --}}
<button type="button"
        class="btn btn-sm btn-success add-stock-btn"
        data-bs-toggle="modal"
        data-bs-target="#addStockModal"
        data-id="{{ $product->id }}"
        data-name="{{ $product->product_name }}"
        data-stock="{{ $product->stock }}"
        title="Add Stock">

    <i class="bi bi-box-arrow-in-down"></i>

</button>
{{-- Remove Stock --}}
<button type="button"
        class="btn btn-sm btn-danger remove-stock-btn"
        data-bs-toggle="modal"
        data-bs-target="#removeStockModal"
        data-id="{{ $product->id }}"
        data-name="{{ $product->product_name }}"
        data-stock="{{ $product->stock }}"
        title="Remove Stock">

    <i class="bi bi-box-arrow-up"></i>

</button>


{{-- Inventory History --}}
<a href="{{ route('products.inventory.history', $product) }}"
   class="btn btn-sm btn-info"
   title="Inventory History">

    <i class="bi bi-clock-history"></i>

</a>


{{-- Delete --}}
{{-- Delete --}}
<button type="button"
        class="btn btn-sm btn-danger delete-product-btn"
        data-bs-toggle="modal"
        data-bs-target="#deleteProductModal"
        data-id="{{ $product->id }}"
        data-name="{{ $product->product_name }}"
        title="Delete Product">

    <i class="bi bi-trash"></i>

</button>
</div>
</td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8"
                                class="text-center py-5 text-muted">

                                <i class="bi bi-box-seam fs-1 d-block mb-3"></i>

                                No products found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
{{-- Add Stock Modal --}}
<div class="modal fade"
     id="addStockModal"
     tabindex="-1"
     aria-labelledby="addStockModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-0 px-4 pt-4">

                <div>
                    <h5 class="modal-title fw-bold"
                        id="addStockModalLabel">

                        Add Stock

                    </h5>

                    <small class="text-muted"
                           id="addStockProductName">

                        Product

                    </small>
                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>

            </div>


            <form id="addStockForm"
                  method="POST">

                @csrf

                <div class="modal-body px-4">

                    {{-- Current Stock --}}
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Current Stock
                        </label>

                        <div class="form-control bg-light"
                             id="currentStockDisplay">

                            0

                        </div>

                    </div>


                    {{-- Quantity --}}
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
                            required>

                    </div>


                    {{-- Remarks --}}
                    <div class="mb-2">

                        <label class="form-label fw-semibold">
                            Remarks
                        </label>

                        <textarea
                            name="remarks"
                            class="form-control"
                            rows="3"
                            placeholder="e.g. New stock delivery"></textarea>

                    </div>

                </div>


                <div class="modal-footer border-0 px-4 pb-4">

                    <button type="button"
                            class="btn btn-light border"
                            data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit"
                            class="btn btn-success">

                        <i class="bi bi-box-arrow-in-down me-1"></i>

                        Add Stock

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const stockButtons =
        document.querySelectorAll('.add-stock-btn');

    const form =
        document.getElementById('addStockForm');

    const productName =
        document.getElementById('addStockProductName');

    const currentStock =
        document.getElementById('currentStockDisplay');


    stockButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const productId =
                this.dataset.id;

            const name =
                this.dataset.name;

            const stock =
                this.dataset.stock;


            productName.textContent = name;

            currentStock.textContent = stock;


            form.action =
                `/admin/products/${productId}/inventory/add`;

        });

    });

});
</script>
{{-- Remove Stock Modal --}}
<div class="modal fade"
     id="removeStockModal"
     tabindex="-1"
     aria-labelledby="removeStockModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-0 px-4 pt-4">

                <div>

                    <h5 class="modal-title fw-bold"
                        id="removeStockModalLabel">

                        Remove Stock

                    </h5>

                    <small class="text-muted"
                           id="removeStockProductName">

                        Product

                    </small>

                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>

            </div>


            <form id="removeStockForm"
                  method="POST">

                @csrf

                <div class="modal-body px-4">

                    {{-- Current Stock --}}
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Current Stock
                        </label>

                        <div class="form-control bg-light"
                             id="removeCurrentStockDisplay">

                            0

                        </div>

                    </div>


                    {{-- Quantity --}}
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
                            required>

                        <small class="text-muted"
                               id="removeStockLimit">

                            Maximum available stock: 0

                        </small>

                    </div>


                    {{-- Remarks --}}
                    <div class="mb-2">

                        <label class="form-label fw-semibold">
                            Remarks
                        </label>

                        <textarea
                            name="remarks"
                            class="form-control"
                            rows="3"
                            placeholder="e.g. Damaged item, manual release, etc."></textarea>

                    </div>

                </div>


                <div class="modal-footer border-0 px-4 pb-4">

                    <button type="button"
                            class="btn btn-light border"
                            data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit"
                            class="btn btn-danger">

                        <i class="bi bi-box-arrow-up me-1"></i>

                        Remove Stock

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const removeButtons =
        document.querySelectorAll('.remove-stock-btn');

    const form =
        document.getElementById('removeStockForm');

    const productName =
        document.getElementById('removeStockProductName');

    const currentStock =
        document.getElementById('removeCurrentStockDisplay');

    const quantityInput =
        document.getElementById('removeStockQuantity');

    const stockLimit =
        document.getElementById('removeStockLimit');


    removeButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const productId =
                this.dataset.id;

            const name =
                this.dataset.name;

            const stock =
                this.dataset.stock;


            productName.textContent = name;

            currentStock.textContent = stock;

            quantityInput.value = '';

            quantityInput.max = stock;

            stockLimit.textContent =
                'Maximum available stock: ' + stock;

            form.action =
                `/admin/products/${productId}/inventory/remove`;

        });

    });

});

</script>
{{-- Delete Product Modal --}}
<div class="modal fade"
     id="deleteProductModal"
     tabindex="-1"
     aria-labelledby="deleteProductModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-0 px-4 pt-4">

                <h5 class="modal-title fw-bold"
                    id="deleteProductModalLabel">

                    Delete Product

                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>

            </div>


            <form id="deleteProductForm"
                  method="POST">

                @csrf

                @method('DELETE')


                <div class="modal-body px-4">

                    <div class="text-center py-2">

                        <div class="mb-3">

                            <i class="bi bi-exclamation-triangle text-danger"
                               style="font-size: 48px;"></i>

                        </div>

                        <h5 class="fw-bold">
                            Are you sure?
                        </h5>

                        <p class="text-muted mb-2">

                            You are about to delete:

                        </p>

                        <p class="fw-bold mb-3"
                           id="deleteProductName">

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

                    <button type="button"
                            class="btn btn-light border"
                            data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit"
                            class="btn btn-danger">

                        <i class="bi bi-trash me-2"></i>

                        Delete Product

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

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

});

</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('productSearchForm');
    const searchInput = document.getElementById('productSearchInput');
    const filters = document.querySelectorAll('.product-auto-submit');

    let timer;

    // Live Search
    searchInput.addEventListener('keyup', function () {

        clearTimeout(timer);

        timer = setTimeout(function () {
            form.submit();
        }, 400);

    });

    // Auto Filter
    filters.forEach(function (filter) {

        filter.addEventListener('change', function () {
            form.submit();
        });

    });

});
</script>

@endsection
