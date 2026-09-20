@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Edit Category</h3>
            <p class="text-muted mb-0">
                Update the selected product category.
            </p>
        </div>

        <a
            href="{{ route('categories.index') }}"
            class="btn btn-secondary"
        >
            <i class="bi bi-arrow-left me-1"></i>
            Back to Categories
        </a>
    </div>


    @if($errors->any())
        <div class="alert alert-danger">
            <div class="fw-semibold mb-2">
                Please correct the following errors:
            </div>

            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form
                action="{{ route('categories.update', $category) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label
                        for="category_name"
                        class="form-label fw-semibold"
                    >
                        Category Name
                    </label>

                    <input
                        type="text"
                        name="category_name"
                        id="category_name"
                        class="form-control"
                        value="{{ old('category_name', $category->category_name) }}"
                        placeholder="Enter category name"
                        required
                    >
                </div>


                <div class="mb-3">
                    <label
                        for="description"
                        class="form-label fw-semibold"
                    >
                        Description
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        rows="4"
                        placeholder="Enter category description"
                    >{{ old('description', $category->description) }}</textarea>
                </div>


                <div class="mb-4">
                    <label
                        for="status"
                        class="form-label fw-semibold"
                    >
                        Status
                    </label>

                    <select
                        name="status"
                        id="status"
                        class="form-select"
                        required
                    >
                        <option value="Active"
                            {{ old('status', $category->status) === 'Active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="Inactive"
                            {{ old('status', $category->status) === 'Inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>


                <div class="d-flex justify-content-end gap-2">

                    <a
                        href="{{ route('categories.index') }}"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="btn btn-warning"
                    >
                        <i class="bi bi-pencil-fill me-1"></i>
                        Update Category
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection