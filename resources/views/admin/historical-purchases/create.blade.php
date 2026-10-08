@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Add Historical Purchase</h4>
            <p class="text-muted mb-0">
                Record a purchase made before MINDOrich was implemented.
            </p>
        </div>

        <a href="{{ route('historical-purchases.index') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please check the following:</strong>

            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('historical-purchases.store') }}"
          method="POST">

        @csrf

        {{-- Purchase Information --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white">
                <h6 class="mb-0">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    Purchase Information
                </h6>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    {{-- Purchase Number --}}
                    <div class="col-md-4">
                        <label class="form-label">
                            Purchase Number <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="purchase_number"
                               class="form-control"
                               value="{{ old('purchase_number') }}"
                               placeholder="e.g. HP-0001"
                               required>
                    </div>

                    {{-- Purchase Date --}}
                    <div class="col-md-4">
                        <label class="form-label">
                            Purchase Date <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                               name="purchase_date"
                               class="form-control"
                               value="{{ old('purchase_date') }}"
                               required>
                    </div>

                    {{-- Producer --}}
                    <div class="col-md-4">
                        <label class="form-label">
                            Producer <span class="text-danger">*</span>
                        </label>

                        <select name="producer_id"
                                class="form-select"
                                required>

                            <option value="">
                                Select Producer
                            </option>

                            @foreach($producers as $producer)

                                <option value="{{ $producer->id }}"
                                    {{ old('producer_id') == $producer->id ? 'selected' : '' }}>

                                    {{ $producer->producer_name }}

                                </option>

                            @endforeach

                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4">
                        <label class="form-label">
                            Status <span class="text-danger">*</span>
                        </label>

                        <select name="status"
                                class="form-select"
                                required>

                            <option value="Completed"
                                {{ old('status', 'Completed') === 'Completed' ? 'selected' : '' }}>
                                Completed
                            </option>

                        </select>
                    </div>

                    {{-- Notes --}}
                    <div class="col-md-8">
                        <label class="form-label">
                            Notes
                        </label>

                        <input type="text"
                               name="notes"
                               class="form-control"
                               value="{{ old('notes') }}"
                               placeholder="Optional notes">
                    </div>

                </div>

            </div>

        </div>


        {{-- Purchase Items --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white d-flex justify-content-between align-items-center">

                <h6 class="mb-0">
                    <i class="bi bi-box-seam me-2"></i>
                    Purchase Items
                </h6>

                <button type="button"
                        class="btn btn-sm btn-primary"
                        id="addItemBtn">

                    <i class="bi bi-plus-lg me-1"></i>
                    Add Item

                </button>

            </div>

            <div class="card-body">

                <div id="itemsContainer">

                    <div class="purchase-item border rounded p-3 mb-3">

                        <div class="row g-3 align-items-end">

                            {{-- Product --}}
                            <div class="col-md-4">

                                <label class="form-label">
                                    Product <span class="text-danger">*</span>
                                </label>

                                <select name="items[0][product_id]"
                                        class="form-select"
                                        required>

                                    <option value="">
                                        Select Product
                                    </option>

                                    @foreach($products as $product)

                                        <option value="{{ $product->id }}">

                                            {{ $product->product_name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- Quantity In --}}
                            <div class="col-md-2">

                                <label class="form-label">
                                    Quantity In <span class="text-danger">*</span>
                                </label>

                                <input type="number"
                                       name="items[0][quantity_in]"
                                       class="form-control"
                                       min="1"
                                       required>

                            </div>


                            {{-- Reject --}}
                            <div class="col-md-2">

                                <label class="form-label">
                                    Reject
                                </label>

                                <input type="number"
                                       name="items[0][reject_quantity]"
                                       class="form-control"
                                       min="0"
                                       value="0"
                                       required>

                            </div>


                            {{-- Purchase Price --}}
                            <div class="col-md-2">

                                <label class="form-label">
                                    Purchase Price <span class="text-danger">*</span>
                                </label>

                                <input type="number"
                                       name="items[0][purchase_price]"
                                       class="form-control"
                                       min="0"
                                       step="0.01"
                                       required>

                            </div>


                            {{-- Remove --}}
                            <div class="col-md-2">

                                <button type="button"
                                        class="btn btn-outline-danger w-100 remove-item">

                                    <i class="bi bi-trash me-1"></i>
                                    Remove

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Buttons --}}
        <div class="d-flex justify-content-end gap-2">

            <a href="{{ route('historical-purchases.index') }}"
               class="btn btn-outline-secondary">

                Cancel

            </a>

            <button type="submit"
                    class="btn btn-primary">

                <i class="bi bi-save me-1"></i>
                Save Historical Purchase

            </button>

        </div>

    </form>

</div>


{{-- Add / Remove Items --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('itemsContainer');
    const addButton = document.getElementById('addItemBtn');

    let itemIndex = 1;


    addButton.addEventListener('click', function () {

        const item = document.createElement('div');

        item.classList.add(
            'purchase-item',
            'border',
            'rounded',
            'p-3',
            'mb-3'
        );

        item.innerHTML = `
            <div class="row g-3 align-items-end">

                <div class="col-md-4">

                    <label class="form-label">
                        Product <span class="text-danger">*</span>
                    </label>

                    <select name="items[${itemIndex}][product_id]"
                            class="form-select"
                            required>

                        <option value="">
                            Select Product
                        </option>

                        @foreach($products as $product)

                            <option value="{{ $product->id }}">
                                {{ $product->product_name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="col-md-2">

                    <label class="form-label">
                        Quantity In <span class="text-danger">*</span>
                    </label>

                    <input type="number"
                           name="items[${itemIndex}][quantity_in]"
                           class="form-control"
                           min="1"
                           required>

                </div>


                <div class="col-md-2">

                    <label class="form-label">
                        Reject
                    </label>

                    <input type="number"
                           name="items[${itemIndex}][reject_quantity]"
                           class="form-control"
                           min="0"
                           value="0"
                           required>

                </div>


                <div class="col-md-2">

                    <label class="form-label">
                        Purchase Price <span class="text-danger">*</span>
                    </label>

                    <input type="number"
                           name="items[${itemIndex}][purchase_price]"
                           class="form-control"
                           min="0"
                           step="0.01"
                           required>

                </div>


                <div class="col-md-2">

                    <button type="button"
                            class="btn btn-outline-danger w-100 remove-item">

                        <i class="bi bi-trash me-1"></i>
                        Remove

                    </button>

                </div>

            </div>
        `;

        container.appendChild(item);

        itemIndex++;

    });


    container.addEventListener('click', function (event) {

        const removeButton =
            event.target.closest('.remove-item');

        if (!removeButton) {
            return;
        }

        const items =
            container.querySelectorAll('.purchase-item');

        if (items.length === 1) {
            alert('At least one purchase item is required.');
            return;
        }

        removeButton.closest('.purchase-item').remove();

    });

});

</script>

@endsection