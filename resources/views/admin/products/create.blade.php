@extends('admin.layouts.app')

@section('title', 'Add Product')

@section('content')

<div class="container-fluid">

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger rounded-4 mb-4">
            <strong>Please check the following:</strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Add Product
            </h2>

            <p class="text-muted mb-0">
                Add a new Mangyan handicraft product.
            </p>
        </div>

        <a href="{{ route('products.index') }}"
           class="btn btn-light border">

            <i class="bi bi-arrow-left me-2"></i>
            Back to Products

        </a>

    </div>


    {{-- ACTUAL FORM --}}
    <form action="{{ route('products.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf


        {{-- Product Information --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-1">
                    Product Information
                </h5>

                <p class="text-muted small mb-4">
                    Enter the basic information about the product.
                </p>


                <div class="row g-4">

                    {{-- Product Name --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Product Name
                        </label>

                        <input
                            type="text"
                            name="product_name"
                            class="form-control"
                            placeholder="Enter product name"
                            value="{{ old('product_name') }}"
                            required
                        >

                    </div>


                    {{-- Producer --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Producer
                        </label>

                        <select
                            name="producer_id"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Select Producer
                            </option>

                            @foreach($producers as $producer)

                                <option
                                    value="{{ $producer->id }}"
                                    {{ old('producer_id') == $producer->id ? 'selected' : '' }}
                                >

                                    {{ $producer->producer_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Category --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Category
                        </label>

                        <select
                            name="category_id"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Select Category
                            </option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}
                                >

                                    {{ $category->category_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Description --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Description
                        </label>

                        <textarea
                            name="description"
                            rows="4"
                            class="form-control"
                            placeholder="Describe the product..."
                        >{{ old('description') }}</textarea>

                    </div>

                </div>

            </div>

        </div>


        {{-- Pricing & Inventory Settings --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-1">
                    Pricing & Inventory
                </h5>

                <p class="text-muted small mb-4">
                    Set the customer selling price and minimum stock level.
                    Actual stock is added through Purchases.
                </p>


                <div class="row g-4">

                    {{-- SRP --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            SRP
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                ₱
                            </span>

                            <input
                                type="number"
                                name="price"
                                class="form-control"
                                placeholder="0.00"
                                min="0"
                                step="0.01"
                                value="{{ old('price') }}"
                                required
                            >

                        </div>

                        <small class="text-muted">
                            Suggested Retail Price / customer selling price.
                        </small>

                    </div>


                    {{-- Current Stock --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Current Stock
                        </label>

                        <input
                            type="text"
                            class="form-control bg-light"
                            value="0"
                            readonly
                        >

                        <small class="text-muted">
                            Stock will be added through the Purchases page.
                        </small>

                    </div>


                    {{-- Minimum Stock --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Minimum Stock
                        </label>

                        <input
                            type="number"
                            name="minimum_stock"
                            class="form-control"
                            placeholder="Enter minimum stock"
                            min="0"
                            value="{{ old('minimum_stock') }}"
                            required
                        >

                        <small class="text-muted">
                            Used to identify low-stock products.
                        </small>

                    </div>


                    {{-- Initial Status --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Initial Status
                        </label>

                        <input
                            type="text"
                            class="form-control bg-light"
                            value="Out of Stock"
                            readonly
                        >

                        <small class="text-muted">
                            The product becomes Available after stock is received.
                        </small>

                        <input
                            type="hidden"
                            name="status"
                            value="Out of Stock"
                        >

                    </div>

                </div>

            </div>

        </div>


        {{-- Product Image --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-1">
                    Product Image
                </h5>

                <p class="text-muted small mb-4">
                    Upload the main image of the product.
                </p>


                <div class="row">

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Featured Image
                        </label>

                        <input
                            type="file"
                            name="featured_image"
                            class="form-control"
                            accept="image/*"
                        >

                        <small class="text-muted">
                            JPG, JPEG, PNG, or WEBP.
                        </small>

                    </div>

                </div>

            </div>

        </div>


        {{-- Form Actions --}}
        <div class="d-flex justify-content-end gap-2 mb-4">

            <a href="{{ route('products.index') }}"
               class="btn btn-light border">

                Cancel

            </a>

            <button type="submit"
                    class="btn btn-warning">

                <i class="bi bi-check-circle me-2"></i>

                Save Product

            </button>

        </div>


    </form>

</div>

@endsection