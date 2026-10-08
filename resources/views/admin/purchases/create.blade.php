@extends('admin.layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Add Wholesale Purchase
            </h2>

            <p class="text-muted mb-0">
                Record products purchased from a Mangyan Producer.
            </p>
        </div>

        <a
            href="{{ route('admin.purchases.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="bi bi-arrow-left me-1"></i>
            Back to Purchases
        </a>

    </div>


    {{-- VALIDATION ERRORS --}}
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


    {{-- PURCHASE FORM --}}
    <form
        action="{{ route('admin.purchases.store') }}"
        method="POST"
    >

        @csrf


        {{-- =========================================================
            PURCHASE INFORMATION
        ========================================================== --}}

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">

                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-receipt me-2"></i>
                    Purchase Information
                </h5>

            </div>


            <div class="card-body">

                <div class="row g-3">


                    {{-- PRODUCER --}}
                    <div class="col-md-6">

                        <label
                            for="producer_id"
                            class="form-label fw-semibold"
                        >
                            Producer <span class="text-danger">*</span>
                        </label>

                        <select
                            name="producer_id"
                            id="producer_id"
                            class="form-select @error('producer_id') is-invalid @enderror"
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

                        <small class="text-muted">
                            Products will be filtered according to the selected producer.
                        </small>

                    </div>


                    {{-- PURCHASE DATE --}}
                    <div class="col-md-3">

                        <label
                            for="purchase_date"
                            class="form-label fw-semibold"
                        >
                            Purchase Date
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="purchase_date"
                            id="purchase_date"
                            class="form-control"
                            value="{{ old('purchase_date', now()->format('Y-m-d')) }}"
                            required
                        >

                    </div>


                    {{-- NOTES --}}
                    <div class="col-md-3">

                        <label
                            for="notes"
                            class="form-label fw-semibold"
                        >
                            Notes
                        </label>

                        <input
                            type="text"
                            name="notes"
                            id="notes"
                            class="form-control"
                            value="{{ old('notes') }}"
                            placeholder="Optional"
                        >

                    </div>

                </div>

            </div>

        </div>



        {{-- =========================================================
            PURCHASE ITEMS
        ========================================================== --}}

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="mb-0 fw-semibold">
                        <i class="bi bi-box-seam me-2"></i>
                        Purchase Items
                    </h5>

                    <small class="text-muted">
                        Rejected units are still included in the total amount paid.
                    </small>

                </div>


                <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    id="add-item-btn"
                >
                    <i class="bi bi-plus-lg me-1"></i>
                    Add Item
                </button>

            </div>


            <div class="card-body">

                <div id="purchase-items-container">

                    @php

                        $oldItems = old('items', [
                            [
                                'product_id' => '',
                                'quantity_in' => '',
                                'reject_quantity' => '0',
                                'purchase_price' => '',
                                'received_at' => now()->format('Y-m-d'),
                            ]
                        ]);

                    @endphp


                    @foreach($oldItems as $index => $item)

                        <div class="purchase-item-row border rounded-3 p-3 mb-3">


                            {{-- ITEM HEADER --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <h6 class="fw-semibold mb-0 item-number">
                                    Item #{{ $index + 1 }}
                                </h6>


                                <button
                                    type="button"
                                    class="btn btn-outline-danger btn-sm remove-item-btn"
                                    {{ count($oldItems) === 1 ? 'disabled' : '' }}
                                >
                                    <i class="bi bi-trash"></i>
                                </button>

                            </div>


                            <div class="row g-3">


                                {{-- PRODUCT --}}
                                <div class="col-lg-4">

                                    <label class="form-label">

                                        Product
                                        <span class="text-danger">*</span>

                                    </label>


                                    <select
                                        name="items[{{ $index }}][product_id]"
                                        class="form-select product-select"
                                        required
                                    >

                                        <option value="">
                                            Select Product
                                        </option>


                                        @foreach($products as $product)

                                            <option
                                                value="{{ $product->id }}"
                                                data-producer-id="{{ $product->producer_id }}"
                                                {{ ($item['product_id'] ?? '') == $product->id ? 'selected' : '' }}
                                            >
                                                {{ $product->product_name }}
                                            </option>

                                        @endforeach

                                    </select>


                                    <small class="text-muted product-help">
                                        Select a producer first.
                                    </small>

                                </div>



                                {{-- QUANTITY IN --}}
                                <div class="col-md-6 col-lg-2">

                                    <label class="form-label">

                                        Quantity In
                                        <span class="text-danger">*</span>

                                    </label>


                                    <input
                                        type="number"
                                        name="items[{{ $index }}][quantity_in]"
                                        class="form-control quantity-in"
                                        min="1"
                                        value="{{ $item['quantity_in'] ?? '' }}"
                                        required
                                    >

                                </div>



                                {{-- REJECT --}}
                                <div class="col-md-6 col-lg-2">

                                    <label class="form-label">
                                        Reject
                                    </label>


                                    <input
                                        type="number"
                                        name="items[{{ $index }}][reject_quantity]"
                                        class="form-control reject-quantity"
                                        min="0"
                                        value="{{ $item['reject_quantity'] ?? 0 }}"
                                        required
                                    >

                                </div>



                                {{-- GOOD --}}
                                <div class="col-md-6 col-lg-2">

                                    <label class="form-label">
                                        Good
                                    </label>


                                    <input
                                        type="number"
                                        class="form-control good-quantity bg-light"
                                        value="0"
                                        readonly
                                    >

                                </div>



                                {{-- PURCHASE PRICE --}}
                                <div class="col-md-6 col-lg-2">

                                    <label class="form-label">

                                        Purchase Price
                                        <span class="text-danger">*</span>

                                    </label>


                                    <input
                                        type="number"
                                        name="items[{{ $index }}][purchase_price]"
                                        class="form-control purchase-price"
                                        min="0"
                                        step="0.01"
                                        value="{{ $item['purchase_price'] ?? '' }}"
                                        required
                                    >

                                </div>



                                {{-- RECEIVED DATE --}}
                                <div class="col-md-6">

                                    <label class="form-label">

                                        Received Date
                                        <span class="text-danger">*</span>

                                    </label>


                                    <input
                                        type="date"
                                        name="items[{{ $index }}][received_at]"
                                        class="form-control"
                                        value="{{ $item['received_at'] ?? now()->format('Y-m-d') }}"
                                        required
                                    >

                                </div>



                                {{-- TOTAL PAID --}}
                                <div class="col-md-6">

                                    <label class="form-label">
                                        Total Paid
                                    </label>


                                    <input
                                        type="text"
                                        class="form-control item-total-paid bg-light"
                                        value="₱0.00"
                                        readonly
                                    >

                                </div>


                            </div>

                        </div>

                    @endforeach

                </div>



                {{-- =================================================
                    SUMMARY
                ================================================== --}}

                <div class="border-top pt-4 mt-4">

                    <div class="row justify-content-end">

                        <div class="col-md-5 col-lg-4">


                            {{-- TOTAL QUANTITY --}}
                            <div class="d-flex justify-content-between mb-2">

                                <span class="text-muted">
                                    Total Quantity In
                                </span>

                                <strong id="summary-quantity-in">
                                    0
                                </strong>

                            </div>


                            {{-- TOTAL REJECT --}}
                            <div class="d-flex justify-content-between mb-2">

                                <span class="text-muted">
                                    Total Reject
                                </span>

                                <strong id="summary-reject">
                                    0
                                </strong>

                            </div>


                            {{-- TOTAL GOOD --}}
                            <div class="d-flex justify-content-between mb-2">

                                <span class="text-muted">
                                    Total Good
                                </span>

                                <strong id="summary-good">
                                    0
                                </strong>

                            </div>


                            {{-- TOTAL PAID --}}
                            <div class="d-flex justify-content-between border-top pt-3 mt-3">

                                <span class="fw-semibold">
                                    Total Paid
                                </span>

                                <strong
                                    class="fs-5 text-success"
                                    id="summary-total-paid"
                                >
                                    ₱0.00
                                </strong>

                            </div>


                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- =========================================================
            ACTIONS
        ========================================================== --}}

        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">

            <a
                href="{{ route('admin.purchases.index') }}"
                class="btn btn-outline-secondary"
            >
                Cancel
            </a>


            <button
                type="submit"
                class="btn btn-primary"
            >
                <i class="bi bi-check-lg me-1"></i>
                Save Purchase
            </button>

        </div>


    </form>

</div>



{{-- ===============================================================
    ITEM TEMPLATE
================================================================ --}}

<template id="purchase-item-template">

    <div class="purchase-item-row border rounded-3 p-3 mb-3">


        {{-- ITEM HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <h6 class="fw-semibold mb-0 item-number">
                Item
            </h6>


            <button
                type="button"
                class="btn btn-outline-danger btn-sm remove-item-btn"
            >
                <i class="bi bi-trash"></i>
            </button>

        </div>


        <div class="row g-3">


            {{-- PRODUCT --}}
            <div class="col-lg-4">

                <label class="form-label">

                    Product
                    <span class="text-danger">*</span>

                </label>


                <select
                    name="items[INDEX][product_id]"
                    class="form-select product-select"
                    required
                    disabled
                >

                    <option value="">
                        Select Product
                    </option>


                    @foreach($products as $product)

                        <option
                            value="{{ $product->id }}"
                            data-producer-id="{{ $product->producer_id }}"
                        >
                            {{ $product->product_name }}
                        </option>

                    @endforeach

                </select>


                <small class="text-muted product-help">
                    Select a producer first.
                </small>

            </div>



            {{-- QUANTITY IN --}}
            <div class="col-md-6 col-lg-2">

                <label class="form-label">

                    Quantity In
                    <span class="text-danger">*</span>

                </label>


                <input
                    type="number"
                    name="items[INDEX][quantity_in]"
                    class="form-control quantity-in"
                    min="1"
                    required
                >

            </div>



            {{-- REJECT --}}
            <div class="col-md-6 col-lg-2">

                <label class="form-label">
                    Reject
                </label>


                <input
                    type="number"
                    name="items[INDEX][reject_quantity]"
                    class="form-control reject-quantity"
                    min="0"
                    value="0"
                    required
                >

            </div>



            {{-- GOOD --}}
            <div class="col-md-6 col-lg-2">

                <label class="form-label">
                    Good
                </label>


                <input
                    type="number"
                    class="form-control good-quantity bg-light"
                    value="0"
                    readonly
                >

            </div>



            {{-- PURCHASE PRICE --}}
            <div class="col-md-6 col-lg-2">

                <label class="form-label">

                    Purchase Price
                    <span class="text-danger">*</span>

                </label>


                <input
                    type="number"
                    name="items[INDEX][purchase_price]"
                    class="form-control purchase-price"
                    min="0"
                    step="0.01"
                    required
                >

            </div>



            {{-- RECEIVED DATE --}}
            <div class="col-md-6">

                <label class="form-label">

                    Received Date
                    <span class="text-danger">*</span>

                </label>


                <input
                    type="date"
                    name="items[INDEX][received_at]"
                    class="form-control"
                    value="{{ now()->format('Y-m-d') }}"
                    required
                >

            </div>



            {{-- TOTAL PAID --}}
            <div class="col-md-6">

                <label class="form-label">
                    Total Paid
                </label>


                <input
                    type="text"
                    class="form-control item-total-paid bg-light"
                    value="₱0.00"
                    readonly
                >

            </div>


        </div>

    </div>

</template>



<script>

document.addEventListener('DOMContentLoaded', function () {


    const container =
        document.getElementById(
            'purchase-items-container'
        );


    const addButton =
        document.getElementById(
            'add-item-btn'
        );


    const template =
        document.getElementById(
            'purchase-item-template'
        );


    const producerSelect =
        document.getElementById(
            'producer_id'
        );


    let itemIndex =
        {{ count($oldItems) }};



    /* =========================================================
       FILTER PRODUCTS BY PRODUCER
    ========================================================== */

    function filterProductsByProducer() {

        const selectedProducerId =
            producerSelect.value;


        container
            .querySelectorAll('.purchase-item-row')
            .forEach(function (row) {

                const productSelect =
                    row.querySelector('.product-select');


                const helpText =
                    row.querySelector('.product-help');


                Array
                    .from(productSelect.options)
                    .forEach(function (option) {

                        if (!option.value) {

                            option.hidden = false;

                            return;
                        }


                        const optionProducerId =
                            option.getAttribute(
                                'data-producer-id'
                            );


                        option.hidden =
                            !selectedProducerId ||
                            optionProducerId !== selectedProducerId;

                    });


                /*
                |--------------------------------------------------------------------------
                | Enable / Disable Product Dropdown
                |--------------------------------------------------------------------------
                */

                productSelect.disabled =
                    !selectedProducerId;


                /*
                |--------------------------------------------------------------------------
                | Clear Invalid Product
                |--------------------------------------------------------------------------
                */

                if (!selectedProducerId) {

                    productSelect.value = '';

                    helpText.textContent =
                        'Select a producer first.';

                } else {

                    const selectedOption =
                        productSelect.options[
                            productSelect.selectedIndex
                        ];


                    if (
                        selectedOption &&
                        selectedOption.value &&
                        selectedOption.hidden
                    ) {

                        productSelect.value = '';

                    }


                    helpText.textContent =
                        'Only products from the selected producer are shown.';

                }

            });

    }



    /* =========================================================
       UPDATE ROW CALCULATION
    ========================================================== */

    function updateRow(row) {

        const quantityInput =
            row.querySelector('.quantity-in');


        const rejectInput =
            row.querySelector('.reject-quantity');


        const goodInput =
            row.querySelector('.good-quantity');


        const priceInput =
            row.querySelector('.purchase-price');


        const totalInput =
            row.querySelector('.item-total-paid');


        const quantity =
            parseInt(
                quantityInput.value
            ) || 0;


        const reject =
            parseInt(
                rejectInput.value
            ) || 0;


        const price =
            parseFloat(
                priceInput.value
            ) || 0;


        const good =
            Math.max(
                quantity - reject,
                0
            );


        const total =
            quantity * price;


        goodInput.value =
            good;


        totalInput.value =
            '₱' +
            total.toLocaleString(
                'en-PH',
                {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }
            );

    }



    /* =========================================================
       UPDATE SUMMARY
    ========================================================== */

    function updateSummary() {

        let totalQuantity = 0;

        let totalReject = 0;

        let totalGood = 0;

        let totalPaid = 0;


        container
            .querySelectorAll('.purchase-item-row')
            .forEach(function (row) {


                const quantity =
                    parseInt(
                        row.querySelector(
                            '.quantity-in'
                        ).value
                    ) || 0;


                const reject =
                    parseInt(
                        row.querySelector(
                            '.reject-quantity'
                        ).value
                    ) || 0;


                const price =
                    parseFloat(
                        row.querySelector(
                            '.purchase-price'
                        ).value
                    ) || 0;


                totalQuantity +=
                    quantity;


                totalReject +=
                    reject;


                totalGood +=
                    Math.max(
                        quantity - reject,
                        0
                    );


                totalPaid +=
                    quantity * price;

            });


        document
            .getElementById(
                'summary-quantity-in'
            )
            .textContent =
            totalQuantity;


        document
            .getElementById(
                'summary-reject'
            )
            .textContent =
            totalReject;


        document
            .getElementById(
                'summary-good'
            )
            .textContent =
            totalGood;


        document
            .getElementById(
                'summary-total-paid'
            )
            .textContent =
            '₱' +
            totalPaid.toLocaleString(
                'en-PH',
                {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }
            );

    }



    /* =========================================================
       REFRESH ITEM NUMBERS
    ========================================================== */

    function refreshItemNumbers() {

        const rows =
            container.querySelectorAll(
                '.purchase-item-row'
            );


        rows.forEach(function (row, index) {

            row.querySelector(
                '.item-number'
            ).textContent =
                'Item #' +
                (index + 1);

        });


        const removeButtons =
            container.querySelectorAll(
                '.remove-item-btn'
            );


        removeButtons.forEach(function (button) {

            button.disabled =
                rows.length === 1;

        });

    }



    /* =========================================================
       BIND ROW
    ========================================================== */

    function bindRow(row) {


        row.querySelectorAll(
            '.quantity-in, .reject-quantity, .purchase-price'
        )
        .forEach(function (input) {

            input.addEventListener(
                'input',
                function () {

                    updateRow(row);

                    updateSummary();

                }
            );

        });


        row.querySelector(
            '.remove-item-btn'
        )
        .addEventListener(
            'click',
            function () {

                const rows =
                    container.querySelectorAll(
                        '.purchase-item-row'
                    );


                if (rows.length === 1) {
                    return;
                }


                row.remove();


                refreshItemNumbers();

                updateSummary();

            }
        );


        updateRow(row);

    }



    /* =========================================================
       INITIALIZE EXISTING ROWS
    ========================================================== */

    container
        .querySelectorAll('.purchase-item-row')
        .forEach(function (row) {

            bindRow(row);

        });



    /* =========================================================
       PRODUCER CHANGE
    ========================================================== */

    producerSelect.addEventListener(
        'change',
        function () {

            /*
            |--------------------------------------------------------------------------
            | Clear current product selections when producer changes
            |--------------------------------------------------------------------------
            |
            | This prevents a previously selected product from belonging
            | to another producer.
            |
            */

            container
                .querySelectorAll('.product-select')
                .forEach(function (select) {

                    select.value = '';

                });


            filterProductsByProducer();

        }
    );



    /* =========================================================
       ADD ITEM
    ========================================================== */

    addButton.addEventListener(
        'click',
        function () {

            if (!producerSelect.value) {

                window.alert(
                    'Please select a producer first.'
                );

                return;
            }


            const html =
                template.innerHTML.replace(
                    /INDEX/g,
                    itemIndex
                );


            container.insertAdjacentHTML(
                'beforeend',
                html
            );


            const rows =
                container.querySelectorAll(
                    '.purchase-item-row'
                );


            const newRow =
                rows[rows.length - 1];


            bindRow(newRow);


            itemIndex++;


            refreshItemNumbers();

            filterProductsByProducer();

            updateSummary();

        }
    );



    /* =========================================================
       INITIAL SETUP
    ========================================================== */

    refreshItemNumbers();

    filterProductsByProducer();

    updateSummary();

});

</script>

@endsection