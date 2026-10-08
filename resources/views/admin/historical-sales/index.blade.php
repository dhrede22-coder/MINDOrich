@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">Historical Sales</h4>

            <p class="text-muted mb-0">
                Records of sales made before the system was implemented.
            </p>
        </div>

        <a href="{{ route('historical-sales.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-lg me-1"></i>

            Add Historical Sale

        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show"
             role="alert">

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

        <div class="alert alert-danger alert-dismissible fade show"
             role="alert">

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

                            <th>OR Number</th>

                            <th>Date</th>

                            <th>Customer</th>

                            <th>Sale Type</th>

                            <th>Items</th>

                            <th>Total Amount</th>

                            <th>Actions</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($historicalSales as $sale)

                            <tr>

                                {{-- OR Number --}}
                                <td>

                                    <strong>
                                        {{ $sale->or_number ?? '—' }}
                                    </strong>

                                </td>


                                {{-- Date --}}
                                <td>

                                    {{ $sale->sales_date->format('M d, Y') }}

                                </td>


                                {{-- Customer --}}
                                <td>

                                    {{ $sale->customer_name ?? '—' }}

                                </td>


                                {{-- Sale Type --}}
                                <td>

                                    @if($sale->sale_type === 'Online')

                                        <span class="badge bg-primary">
                                            Online
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Walk-in
                                        </span>

                                    @endif

                                </td>


                                {{-- Items --}}
                                <td>

                                    {{ $sale->items->count() }}

                                </td>


                                {{-- Total --}}
                                <td>

                                    ₱{{ number_format(
                                        $sale->total_amount,
                                        2
                                    ) }}

                                </td>


                                {{-- Actions --}}
                                <td>

                                    <div class="d-flex gap-1">

                                        {{-- View --}}
                                        <a href="{{ route(
                                            'historical-sales.show',
                                            $sale
                                        ) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="View">

                                            <i class="bi bi-eye"></i>

                                        </a>


                                        {{-- Edit --}}
                                        <a href="{{ route(
                                            'historical-sales.edit',
                                            $sale
                                        ) }}"
                                           class="btn btn-sm btn-outline-secondary"
                                           title="Edit">

                                            <i class="bi bi-pencil"></i>

                                        </a>


                                        {{-- Delete --}}
                                        <form
                                            action="{{ route(
                                                'historical-sales.destroy',
                                                $sale
                                            ) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm(
                                                'Are you sure you want to delete this historical sale?'
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

                                    <i class="bi bi-receipt fs-1 text-muted"></i>

                                    <h6 class="mt-3">
                                        No Historical Sales
                                    </h6>

                                    <p class="text-muted mb-3">
                                        No historical sales records have been added yet.
                                    </p>

                                    <a href="{{ route(
                                        'historical-sales.create'
                                    ) }}"
                                       class="btn btn-primary">

                                        <i class="bi bi-plus-lg me-1"></i>

                                        Add Historical Sale

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