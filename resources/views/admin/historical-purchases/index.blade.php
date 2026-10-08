@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Historical Purchases</h4>
            <p class="text-muted mb-0">
                Records of purchases made before the system was implemented.
            </p>
        </div>

        <a href="{{ route('historical-purchases.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Add Historical Purchase
        </a>
    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- Error Message --}}
    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            <i class="bi bi-exclamation-circle me-2"></i>

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>Purchase #</th>

                            <th>Date</th>

                            <th>Producer</th>

                            <th>Items</th>

                            <th>Total Purchase Cost</th>

                            <th>Status</th>

                            <th class="text-end">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($historicalPurchases as $purchase)

                            <tr>

                                {{-- Purchase Number --}}
                                <td>

                                    <strong>
                                        {{ $purchase->purchase_number }}
                                    </strong>

                                </td>


                                {{-- Date --}}
                                <td>

                                    {{ $purchase->purchase_date->format('M d, Y') }}

                                </td>


                                {{-- Producer --}}
                                <td>

                                    {{ $purchase->producer->producer_name ?? '—' }}

                                </td>


                                {{-- Items --}}
                                <td>

                                    {{ $purchase->items->count() }}

                                </td>


                                {{-- Total --}}
                                <td>

                                    ₱{{ number_format(
                                        $purchase->total_purchase_cost,
                                        2
                                    ) }}

                                </td>


                                {{-- Status --}}
                                <td>

                                    <span class="badge bg-success">

                                        {{ $purchase->status }}

                                    </span>

                                </td>


                                {{-- Actions --}}
                                <td class="text-end">

                                    <div class="d-flex justify-content-end gap-1">

                                        {{-- View --}}
                                        <a href="{{ route(
                                            'historical-purchases.show',
                                            $purchase
                                        ) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="View">

                                            <i class="bi bi-eye"></i>

                                        </a>


                                        {{-- Edit --}}
                                        <a href="{{ route(
                                            'historical-purchases.edit',
                                            $purchase
                                        ) }}"
                                           class="btn btn-sm btn-outline-secondary"
                                           title="Edit">

                                            <i class="bi bi-pencil"></i>

                                        </a>


                                        {{-- Delete --}}
                                        <form
                                            action="{{ route(
                                                'historical-purchases.destroy',
                                                $purchase
                                            ) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm(
                                                'Are you sure you want to delete this historical purchase?'
                                            );"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Delete"
                                            >

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center py-5">

                                    <i class="bi bi-clock-history fs-1 text-muted"></i>

                                    <h6 class="mt-3">
                                        No Historical Purchases
                                    </h6>

                                    <p class="text-muted mb-3">
                                        No historical purchase records have been added yet.
                                    </p>

                                    <a href="{{ route(
                                        'historical-purchases.create'
                                    ) }}"
                                       class="btn btn-primary">

                                        <i class="bi bi-plus-lg me-1"></i>

                                        Add Historical Purchase

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