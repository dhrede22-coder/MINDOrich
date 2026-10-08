@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">Add Historical Sale</h4>

            <p class="text-muted mb-0">
                Record a sale made before the system was implemented.
            </p>
        </div>

        <a href="{{ route('historical-sales.index') }}"
           class="btn btn-light border">

            <i class="bi bi-arrow-left me-1"></i>

            Back

        </a>

    </div>


    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Please fix the following errors:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form action="{{ route('historical-sales.store') }}"
          method="POST">

        @csrf


        {{-- Sale Information --}}

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white">

                <h6 class="mb-0">
                    <i class="bi bi-receipt me-2"></i>
                    Sale Information
                </h6>

            </div>


            <div class="card-body">

                <div class="row g-3">


                    {{-- Sales Date --}}

                    <div class="col-md-4">

                        <label class="form-label">
                            Sales Date <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                               name="sales_date"
                               class="form-control"
                               value="{{ old('sales_date') }}"
                               required>

                    </div>


                    {{-- OR Number --}}

                    <div class="col-md-4">

                        <label class="form-label">
                            OR Number
                        </label>

                        <input type="text"
                               name="or_number"
                               class="form-control"
                               value="{{ old('or_number') }}"
                               placeholder="e.g. OR-001">

                    </div>


                    {{-- Customer Name --}}

                    <div class="col-md-4">

                        <label class="form-label">
                            Customer Name
                        </label>

                        <input type="text"
                               name="customer_name"
                               class="form-control"
                               value="{{ old('customer_name') }}"
                               placeholder="Customer name">

                    </div>


                    {{-- Sale Type --}}

                    <div class="col-md-4">

                        <label class="form-label">
                            Sale Type <span class="text-danger">*</span>
                        </label>

                        <select name="sale_type"
                                class="form-select"
                                required>

                            <option value="">
                                Select Sale Type
                            </option>

                            <option value="Walk-in"
                                {{ old('sale_type') === 'Walk-in' ? 'selected' : '' }}>
                                Walk-in
                            </option>

                            <option value="Online"
                                {{ old('sale_type') === 'Online' ? 'selected' : '' }}>
                                Online
                            </option>

                        </select>

                    </div>


                    {{-- Payment Method --}}

                    <div class="col-md-4">

                        <label class="form-label">
                            Payment Method <span class="text-danger">*</span>
                        </label>

                        <select name="payment_method"
                                class="form-select"
                                required>

                            <option value="">
                                Select Payment Method
                            </option>

                            <option value="Cash"
                                {{ old('payment_method') === 'Cash' ? 'selected' : '' }}>
                                Cash
                            </option>

                            <option value="GCash"
                                {{ old('payment_method') === 'GCash' ? 'selected' : '' }}>
                                GCash
                            </option>

                            <option value="Bank Transfer"
                                {{ old('payment_method') === 'Bank Transfer' ? 'selected' : '' }}>
                                Bank Transfer
                            </option>

                        </select>

                    </div>


                    {{-- Notes --}}

                    <div class="col-md-4">

                        <label class="form-label">
                            Notes
                        </label>

                        <textarea name="notes"
                                  class="form-control"
                                  rows="1"
                                  placeholder="Optional notes">{{ old('notes') }}</textarea>

                    </div>

                </div>

            </div>

        </div>


        {{-- Sale Items --}}

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white d-flex justify-content-between align-items-center">

                <h6 class="mb-0">

                    <i class="bi bi-box-seam me-2"></i>

                    Sale Items

                </h6>


                <button type="button"
                        class="btn btn-sm btn-primary"
                        id="addItemBtn">

                    <i class="bi bi-plus-lg me-1"></i>

                    Add Item

                </button>

            </div>


            <div class="card-body">


                <div class="table-responsive">

                    <table class="table align-middle"
                           id="itemsTable">

                        <thead class="table-light">

                            <tr>

                                <th style="min-width: 250px;">
                                    Product
                                </th>

                                <th style="width: 150px;">
                                    Quantity
                                </th>

                                <th style="width: 180px;">
                                    Unit Price
                                </th>

                                <th style="width: 180px;">
                                    Subtotal
                                </th>

                                <th style="width: 80px;">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody id="itemsBody">

                            <tr class="item-row">

                                {{-- Product --}}

                                <td>

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

                                </td>


                                {{-- Quantity --}}

                                <td>

                                    <input type="number"
                                           name="items[0][quantity]"
                                           class="form-control quantity-input"
                                           min="1"
                                           value="1"
                                           required>

                                </td>


                                {{-- Unit Price --}}

                                <td>

                                    <input type="number"
                                           name="items[0][unit_price]"
                                           class="form-control price-input"
                                           min="0"
                                           step="0.01"
                                           placeholder="0.00"
                                           required>

                                </td>


                                {{-- Subtotal --}}

                                <td>

                                    <input type="text"
                                           class="form-control subtotal-display"
                                           value="₱0.00"
                                           readonly>

                                </td>


                                {{-- Remove --}}

                                <td>

                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger remove-item"
                                            title="Remove">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>


                {{-- Total --}}

                <div class="d-flex justify-content-end mt-3">

                    <div class="text-end">

                        <small class="text-muted">
                            Total Amount
                        </small>

                        <h4 class="mb-0"
                            id="totalAmount">

                            ₱0.00

                        </h4>

                    </div>

                </div>

            </div>

        </div>


        {{-- Buttons --}}

        <div class="d-flex justify-content-end gap-2 mb-4">

            <a href="{{ route('historical-sales.index') }}"
               class="btn btn-light border">

                Cancel

            </a>

            <button type="submit"
                    class="btn btn-primary">

                <i class="bi bi-check-lg me-1"></i>

                Save Historical Sale

            </button>

        </div>


    </form>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const itemsBody = document.getElementById('itemsBody');

    const addItemBtn = document.getElementById('addItemBtn');

    const totalAmount = document.getElementById('totalAmount');

    let itemIndex = 1;


    function updateTotals() {

        let total = 0;


        document.querySelectorAll('.item-row').forEach(function (row) {

            const quantityInput =
                row.querySelector('.quantity-input');

            const priceInput =
                row.querySelector('.price-input');

            const subtotalDisplay =
                row.querySelector('.subtotal-display');


            const quantity =
                parseFloat(quantityInput.value) || 0;

            const price =
                parseFloat(priceInput.value) || 0;


            const subtotal = quantity * price;


            subtotalDisplay.value =
                '₱' + subtotal.toFixed(2);


            total += subtotal;

        });


        totalAmount.textContent =
            '₱' + total.toFixed(2);

    }


    function attachRowEvents(row) {

        const quantityInput =
            row.querySelector('.quantity-input');

        const priceInput =
            row.querySelector('.price-input');

        const removeButton =
            row.querySelector('.remove-item');


        quantityInput.addEventListener(
            'input',
            updateTotals
        );

        priceInput.addEventListener(
            'input',
            updateTotals
        );


        removeButton.addEventListener(
            'click',
            function () {

                const rows =
                    document.querySelectorAll('.item-row');


                if (rows.length === 1) {

                    alert(
                        'At least one sale item is required.'
                    );

                    return;

                }


                row.remove();

                updateTotals();

            }
        );

    }


    attachRowEvents(
        document.querySelector('.item-row')
    );


    addItemBtn.addEventListener(
        'click',
        function () {

            const row =
                document.createElement('tr');

            row.classList.add('item-row');


            row.innerHTML = `

                <td>

                    <select
                        name="items[${itemIndex}][product_id]"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Select Product
                        </option>

                        @foreach($products as $product)

                            <option value="{{ $product->id }}">

                                {{ $product->product_name }}

                            </option>

                        @endforeach

                    </select>

                </td>


                <td>

                    <input
                        type="number"
                        name="items[${itemIndex}][quantity]"
                        class="form-control quantity-input"
                        min="1"
                        value="1"
                        required
                    >

                </td>


                <td>

                    <input
                        type="number"
                        name="items[${itemIndex}][unit_price]"
                        class="form-control price-input"
                        min="0"
                        step="0.01"
                        placeholder="0.00"
                        required
                    >

                </td>


                <td>

                    <input
                        type="text"
                        class="form-control subtotal-display"
                        value="₱0.00"
                        readonly
                    >

                </td>


                <td>

                    <button
                        type="button"
                        class="btn btn-sm btn-outline-danger remove-item"
                        title="Remove"
                    >

                        <i class="bi bi-trash"></i>

                    </button>

                </td>

            `;


            itemsBody.appendChild(row);

            attachRowEvents(row);

            itemIndex++;

        }
    );


    updateTotals();

});

</script>

@endsection