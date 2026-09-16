@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')

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
            Edit Product
        </h2>

        <p class="text-muted mb-0">
            Update the information of this product.
        </p>

    </div>

    <a href="{{ route('products.index') }}"
       class="btn btn-light border">

        <i class="bi bi-arrow-left me-2"></i>

        Back to Products

    </a>

</div>


<form action="{{ route('products.update', $product) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    @method('PUT')


    {{-- Product Information --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-1">
                Product Information
            </h5>

            <p class="text-muted small mb-4">
                Update the basic information about the product.
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
                        value="{{ old('product_name', $product->product_name) }}"
                        required>

                </div>


                {{-- Craftsman --}}
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Craftsman
                    </label>

                    <select
                        name="producer_id"
                        class="form-select"
                        required>

                        <option value="">
                            Select Craftsman
                        </option>

                        @foreach($producers as $producer)

                            <option
                                value="{{ $producer->id }}"
                                {{ old('producer_id', $product->producer_id) == $producer->id ? 'selected' : '' }}>

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
                        required>

                        <option value="">
                            Select Category
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>

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
                        placeholder="Describe the product...">{{ old('description', $product->description) }}</textarea>

                </div>

            </div>

        </div>

    </div>


    {{-- Pricing & Status --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-1">
                Pricing & Status
            </h5>

            <p class="text-muted small mb-4">
                Update the product price, minimum stock, and status.
            </p>


            <div class="row g-4">

                {{-- Price --}}
                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Price
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            ₱
                        </span>

                        <input
                            type="number"
                            name="price"
                            class="form-control"
                            value="{{ old('price', $product->price) }}"
                            min="0"
                            step="0.01"
                            required>

                    </div>

                </div>


                {{-- Current Stock --}}
                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Current Stock
                    </label>

                    <div class="form-control bg-light">

                        {{ $product->stock }}

                    </div>

                    <small class="text-muted">
                        Manage stock through Inventory.
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
                        value="{{ old('minimum_stock', $product->minimum_stock) }}"
                        min="0"
                        required>

                </div>


                {{-- Status --}}
                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select"
                        required>

                        <option
                            value="Available"
                            {{ old('status', $product->status) === 'Available' ? 'selected' : '' }}>

                            Available

                        </option>

                        <option
                            value="Out of Stock"
                            {{ old('status', $product->status) === 'Out of Stock' ? 'selected' : '' }}>

                            Out of Stock

                        </option>

                        <option
                            value="Archived"
                            {{ old('status', $product->status) === 'Archived' ? 'selected' : '' }}>

                            Archived

                        </option>

                    </select>

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
                Update the main product image if needed.
            </p>


            <div class="row align-items-center">

                <div class="col-md-4">

                    @if($product->featured_image)

                        <img
                            src="{{ asset('storage/' . $product->featured_image) }}"
                            class="img-fluid rounded-4"
                            style="height: 180px; width: 180px; object-fit: cover;"
                            alt="{{ $product->product_name }}">

                    @else

                        <div
                            class="bg-light rounded-4 d-flex align-items-center justify-content-center"
                            style="height: 180px; width: 180px;">

                            <i class="bi bi-image text-muted fs-1"></i>

                        </div>

                    @endif

                </div>


                <div class="col-md-8">

                    <label class="form-label fw-semibold">
                        Replace Image
                    </label>

                    <input
                        type="file"
                        name="featured_image"
                        class="form-control"
                        accept="image/*">

                    <small class="text-muted">
                        JPG, JPEG, PNG, or WEBP. Maximum 2MB.
                    </small>

                </div>

            </div>

        </div>

    </div>


    {{-- Actions --}}
    <div class="d-flex justify-content-end gap-2 mb-4">

        <a href="{{ route('products.index') }}"
           class="btn btn-light border">

            Cancel

        </a>

        <button type="submit"
                class="btn btn-warning">

            <i class="bi bi-check-circle me-2"></i>

            Save Changes

        </button>

    </div>

</form>

@endsection
