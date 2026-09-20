@extends('admin.layouts.app')

@section('title', 'Promotions')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Promotions
            </h2>

            <p class="text-muted mb-0">
                Manage Hot Deals and product discounts.
            </p>
        </div>

        <a
            href="{{ route('promotions.create') }}"
            class="btn btn-warning"
        >
            <i class="bi bi-plus-lg me-1"></i>
            Add Promotion
        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
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


    {{-- Promotions Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">
                                PROMOTION
                            </th>

                            <th>
                                DISCOUNT
                            </th>

                            <th>
                                SCHEDULE
                            </th>

                            <th>
                                STATUS
                            </th>

                            <th>
                                PRODUCTS
                            </th>

                            <th class="text-end pe-4">
                                ACTIONS
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($promotions as $promotion)

                            <tr>

                                {{-- Promotion --}}
                                <td class="ps-4">

                                    <div class="fw-semibold">
                                        {{ $promotion->name }}
                                    </div>

                                    <small class="text-muted">
                                        #{{ $promotion->id }}
                                    </small>

                                </td>


                                {{-- Discount --}}
                                <td>

                                    @if($promotion->discount_type === 'percentage')

                                        <span class="fw-semibold">
                                            {{ rtrim(rtrim(number_format($promotion->discount_value, 2), '0'), '.') }}%
                                        </span>

                                    @else

                                        <span class="fw-semibold">
                                            ₱{{ number_format($promotion->discount_value, 2) }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Schedule --}}
                                <td>

                                    <div class="small">

                                        <div>
                                            <span class="text-muted">
                                                Start:
                                            </span>

                                            {{ $promotion->starts_at
                                                ? $promotion->starts_at->format('M d, Y h:i A')
                                                : 'Anytime' }}
                                        </div>

                                        <div>
                                            <span class="text-muted">
                                                End:
                                            </span>

                                            {{ $promotion->ends_at
                                                ? $promotion->ends_at->format('M d, Y h:i A')
                                                : 'No end date' }}
                                        </div>

                                    </div>

                                </td>


                                {{-- Status --}}
                                <td>

                                    @if($promotion->status)

                                        <span class="badge bg-success">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Inactive
                                        </span>

                                    @endif

                                </td>


                                {{-- Products --}}
                                <td>

                                    <span class="badge bg-light text-dark border">
                                        {{ $promotion->products_count }}
                                        {{ $promotion->products_count === 1 ? 'Product' : 'Products' }}
                                    </span>

                                </td>


                                {{-- Actions --}}
                                <td class="text-end pe-4">

                                    <div class="d-inline-flex gap-2">

                                        <a
                                            href="{{ route('promotions.edit', $promotion) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Edit Promotion"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form
                                            action="{{ route('promotions.destroy', $promotion) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this promotion?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Delete Promotion"
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

                                    <i class="bi bi-tags fs-1 text-muted"></i>

                                    <h5 class="fw-bold mt-3">
                                        No Promotions Yet
                                    </h5>

                                    <p class="text-muted mb-3">
                                        Create your first Hot Deal promotion.
                                    </p>

                                    <a
                                        href="{{ route('promotions.create') }}"
                                        class="btn btn-warning"
                                    >
                                        <i class="bi bi-plus-lg me-1"></i>
                                        Add Promotion
                                    </a>

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