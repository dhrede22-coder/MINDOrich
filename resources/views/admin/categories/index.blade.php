@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Categories</h3>
            <p class="text-muted mb-0">
                Manage product categories.
            </p>
        </div>

        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Add Category
        </a>
    </div>


    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    @if($errors->has('delete'))
        <div class="alert alert-danger">
            {{ $errors->first('delete') }}
        </div>
    @endif


    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Products</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($categories as $category)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $category->category_name }}
                                </td>

                                <td>
                                    {{ $category->description ?: '—' }}
                                </td>

                                <td>
                                    @if($category->status === 'Active')
                                        <span class="badge bg-success">
                                            Active
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $category->products_count }}
                                </td>

                                <td class="text-end">

    <a
        href="{{ route('categories.edit', $category) }}"
        class="btn btn-sm btn-warning"
        title="Edit Category"
    >
        <i class="bi bi-pencil-fill"></i>
    </a>

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
                class="btn btn-sm btn-danger"
                title="Delete Category"
            >
                <i class="bi bi-trash-fill"></i>
            </button>

        </form>

    @else

        <button
            type="button"
            class="btn btn-sm btn-secondary"
            disabled
            title="This category is currently assigned to products."
        >
            <i class="bi bi-trash-fill"></i>
        </button>

    @endif

</td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    No categories found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

@endsection