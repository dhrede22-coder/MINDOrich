@extends('admin.layouts.app')

@section('title', 'Create Order')

@section('content')

<div class="container-fluid">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Create Order
            </h2>

            <p class="text-muted mb-0">
                Create a new walk-in or online order.
            </p>

        </div>

        <a href="{{ route('orders.index') }}"
           class="btn btn-light border">

            <i class="bi bi-arrow-left me-2"></i>

            Back to Orders

        </a>

    </div>


    {{-- =========================================================
        CREATE ORDER FORM
    ========================================================== --}}
    <form method="POST"
          action="{{ route('orders.store') }}"
          id="createOrderForm">

        @csrf

        <div class="row g-4">


            {{-- =================================================
                LEFT SIDE — ORDER INFORMATION
            ================================================== --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-1">
                            Order Information
                        </h5>

                        <p class="text-muted small mb-4">
                            Enter the details of the new order.
                        </p>


                        {{-- =================================================
                            ORDER TYPE
                        ================================================== --}}
                        <div class="mb-4">

    <label class="form-label fw-semibold">
        Order Type
    </label>

    <input
        type="text"
        class="form-control"
        value="Walk-in"
        readonly
    >

    <input
        type="hidden"
        name="sale_type"
        value="Walk-in"
    >

</div>


                        {{-- =================================================
                            CUSTOMER
                        ================================================== --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Customer
                            </label>

                            <select name="user_id"
                                    class="form-select">

                                <option value="">
                                    Walk-in Customer
                                </option>

                            </select>

                            <small class="text-muted">
                                Leave this as Walk-in Customer for customers without an account.
                            </small>

                        </div>


                        {{-- =================================================
                            CATEGORY FILTER
                        ================================================== --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Category
                            </label>

                            <select id="categoryFilter"
                                    class="form-select">

                                <option value="">
                                    All Categories
                                </option>

                                @foreach($categories as $category)

                                    <option value="{{ $category->id }}">
                                        {{ $category->category_name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- =================================================
                            PRODUCT SEARCH
                            -------------------------------------------------
                            Search products here.
                            Eye icon is handled in JavaScript below.
                        ================================================== --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Product
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>

                                <input
                                    type="text"
                                    id="productSearch"
                                    class="form-control"
                                    placeholder="Search product by name..."
                                >

                            </div>

                            {{-- Search Results --}}
                            <div
                                id="productResults"
                                class="list-group mt-2"
                            ></div>

                        </div>


                        {{-- =================================================
                            SELECTED PRODUCTS
                        ================================================== --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold d-block">
                                Selected Products
                            </label>

                            <div id="selectedProducts">

                                <div class="border rounded-3 p-3 text-center text-muted small">

                                    No products added to this order yet.

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                            PAYMENT METHOD
                        ================================================== --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Payment Method
                            </label>

                            <select name="payment_method"
                                    class="form-select">

                                <option value="">
                                    Select Payment Method
                                </option>

                                <option value="Cash">
                                    Cash
                                </option>

                                <option value="GCash">
                                    GCash
                                </option>

                            </select>

                        </div>


                        {{-- =================================================
                            NOTES
                        ================================================== --}}
                        <div class="mb-0">

                            <label class="form-label fw-semibold">
                                Notes
                            </label>

                            <textarea
                                name="notes"
                                class="form-control"
                                rows="4"
                                placeholder="Optional order notes..."
                            ></textarea>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                RIGHT SIDE — ORDER SUMMARY
            ================================================== --}}
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4">
                            Order Summary
                        </h5>


                        {{-- Selected Items --}}
                        <div class="d-flex justify-content-between mb-3">

                            <span class="text-muted">
                                Selected Items
                            </span>

                            <span id="summaryItemCount">
                                —
                            </span>

                        </div>


                        {{-- Total Quantity --}}
                        <div class="d-flex justify-content-between mb-3">

                            <span class="text-muted">
                                Total Quantity
                            </span>

                            <span id="summaryQuantity">
                                0
                            </span>

                        </div>


                        <hr>


                        {{-- Total --}}
                        <div class="d-flex justify-content-between">

                            <span class="fw-bold">
                                Total
                            </span>

                            <span
                                class="fw-bold fs-5"
                                id="summaryTotal"
                            >
                                ₱0.00
                            </span>

                        </div>


                        {{-- Create Order Button --}}
                        <button
                            type="submit"
                            class="btn btn-warning w-100 mt-4"
                        >

                            <i class="bi bi-check-circle me-1"></i>

                            Create Order

                        </button>


                        {{-- Validation Message --}}
                        <div
                            id="orderValidationMessage"
                            class="text-danger small mt-2 d-none"
                            role="alert"
                        >
                            Please add at least one product to this order.
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
            HIDDEN ORDER ITEMS
            ---------------------------------------------------------
            JavaScript generates:
            items[0][product_id]
            items[0][quantity]
        ========================================================== --}}
        <div id="orderItemsInputs"></div>

    </form>

</div>



{{-- ================================================================
    PRODUCT DETAILS MODAL
    ----------------------------------------------------------------
    Kapag pinindot ang EYE ICON, dito lalabas ang details.
================================================================ --}}
<div
    class="modal fade"
    id="productDetailsModal"
    tabindex="-1"
    aria-labelledby="productDetailsModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">


            {{-- =================================================
                MODAL HEADER
            ================================================== --}}
            <div class="modal-header border-bottom px-4 py-3">

                <div>

                    <h5
                        class="modal-title fw-bold mb-0"
                        id="productDetailsModalLabel"
                    >
                        Product Details
                    </h5>

                    <small class="text-muted">
                        View product information
                    </small>

                </div>

                {{-- =================================================
                     MODAL CLOSE / X BUTTON
                     -------------------------------------------------
                     Direct JavaScript handler is attached below.
                ================================================== --}}
                <button
                    type="button"
                    class="btn-close"
                    id="closeProductDetailsX"
                    aria-label="Close"
                ></button>

            </div>


            {{-- =================================================
                MODAL BODY
            ================================================== --}}
            <div class="modal-body p-4">

                <div class="row g-4 align-items-start">


                    {{-- =================================================
                        PRODUCT IMAGE
                    ================================================== --}}
                    <div class="col-md-5">

                        <div
                            class="product-detail-image-wrapper
                                   border
                                   rounded-4
                                   overflow-hidden
                                   bg-light
                                   d-flex
                                   align-items-center
                                   justify-content-center"
                            style="height: 280px;"
                        >

                            <img
                                id="detailProductImage"
                                src=""
                                alt="Product Image"
                                class="img-fluid w-100 h-100"
                                style="object-fit: cover; display: none;"
                            >

                            <div
                                id="detailNoImage"
                                class="text-center text-muted"
                            >

                                <i class="bi bi-image fs-1 d-block mb-2"></i>

                                <small>
                                    No image available
                                </small>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        PRODUCT INFORMATION
                    ================================================== --}}
                    <div class="col-md-7">

                        <h3
                            class="fw-bold mb-2"
                            id="detailProductName"
                        ></h3>


                        {{-- Category + Producer --}}
                        <div class="d-flex flex-wrap gap-2 mb-4">

                            <span
                                class="badge rounded-pill bg-light text-dark border px-3 py-2"
                                id="detailProductCategory"
                            ></span>

                            <span
                                class="badge rounded-pill bg-light text-dark border px-3 py-2"
                                id="detailProductProducer"
                            ></span>

                        </div>


                        {{-- =================================================
                            PRICE & STOCK
                        ================================================== --}}
                        <div class="row g-3 mb-4">

                            <div class="col-6">

                                <div class="border rounded-3 p-3 h-100">

                                    <small class="text-muted d-block mb-1">
                                        Price
                                    </small>

                                    <span
                                        class="fw-bold fs-4"
                                        id="detailProductPrice"
                                    ></span>

                                </div>

                            </div>


                            <div class="col-6">

                                <div class="border rounded-3 p-3 h-100">

                                    <small class="text-muted d-block mb-1">
                                        Available Stock
                                    </small>

                                    <span
                                        class="fw-bold fs-4"
                                        id="detailProductStock"
                                    ></span>

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                            DESCRIPTION
                        ================================================== --}}
                        <div>

                            <small class="text-muted fw-semibold d-block mb-1">
                                Description
                            </small>

                            <p
                                class="text-secondary mb-0"
                                id="detailProductDescription"
                            ></p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                MODAL FOOTER
            ================================================== --}}
            <div class="modal-footer border-top px-4 py-3">

                {{-- =================================================
                     MODAL CANCEL BUTTON
                     -------------------------------------------------
                     Direct JavaScript handler is attached below.
                ================================================== --}}
                <button
                    type="button"
                    class="btn btn-light border px-4"
                    id="closeProductDetails"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    class="btn btn-warning px-4"
                    id="addProductToOrder"
                >

                    <i class="bi bi-cart-plus me-1"></i>

                    Add to Order

                </button>

            </div>

        </div>

    </div>

</div>



<script>

document.addEventListener('DOMContentLoaded', function () {


    /* =========================================================
       PRODUCT DATA
       ---------------------------------------------------------
       Galing ito sa Admin OrderController.
    ========================================================== */

    const products = @json($productData);



    /* =========================================================
       ELEMENTS
    ========================================================== */

    const categoryFilter =
        document.getElementById('categoryFilter');

    const productSearch =
        document.getElementById('productSearch');

    const productResults =
        document.getElementById('productResults');

    const addProductButton =
        document.getElementById('addProductToOrder');

    const productDetailsModal =
        document.getElementById('productDetailsModal');

    /* =========================================================
       PRODUCT DETAILS MODAL CLOSE BUTTONS
       ---------------------------------------------------------
       These handlers make X and Cancel work directly.
       They do not change the existing layout.
    ========================================================== */

    const closeProductDetails =
        document.getElementById('closeProductDetails');

    const closeProductDetailsX =
        document.getElementById('closeProductDetailsX');


    /* =========================================================
       CLOSE PRODUCT DETAILS MODAL
       ---------------------------------------------------------
       Uses Bootstrap when available, with a fallback.
    ========================================================== */

    function closeProductModal()
    {
        if (!productDetailsModal) {
            return;
        }

        if (typeof bootstrap !== 'undefined') {

            const modal =
                bootstrap.Modal.getInstance(
                    productDetailsModal
                );

            if (modal) {
                modal.hide();
                return;
            }

            const newModal =
                bootstrap.Modal.getOrCreateInstance(
                    productDetailsModal
                );

            newModal.hide();
            return;
        }

        /* -----------------------------------------------------
           FALLBACK IF BOOTSTRAP MODAL INSTANCE IS UNAVAILABLE
        ------------------------------------------------------ */

        productDetailsModal.classList.remove('show');
        productDetailsModal.style.display = 'none';
        productDetailsModal.setAttribute('aria-hidden', 'true');
        productDetailsModal.removeAttribute('aria-modal');

        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('padding-right');

        document
            .querySelectorAll('.modal-backdrop')
            .forEach(function (backdrop) {
                backdrop.remove();
            });
    }


    /* =========================================================
       X BUTTON CLICK
    ========================================================== */

    if (closeProductDetailsX) {

        closeProductDetailsX.addEventListener(
            'click',
            function (event) {

                event.preventDefault();
                event.stopPropagation();

                closeProductModal();

            }
        );

    }


    /* =========================================================
       CANCEL BUTTON CLICK
    ========================================================== */

    if (closeProductDetails) {

        closeProductDetails.addEventListener(
            'click',
            function (event) {

                event.preventDefault();
                event.stopPropagation();

                closeProductModal();

            }
        );

    }


    const quantityInput =
        document.querySelector(
            'input[name="quantity"]'
        );



    /* =========================================================
       CURRENT PRODUCT / SELECTED PRODUCTS
    ========================================================== */

    let productForModal = null;

    const orderItems = new Map();



    /* =========================================================
       PRODUCT DETAILS MODAL
       ---------------------------------------------------------
       Ito ang naglalagay ng information sa modal.
    ========================================================== */

    window.showProductDetails = function (product)
    {

        productForModal = product;


        /* =====================================================
           PRODUCT NAME
        ====================================================== */

        const productName =
            document.getElementById(
                'detailProductName'
            );

        if (productName) {

            productName.textContent =
                product.name;

        }


        /* =====================================================
           CATEGORY
        ====================================================== */

        const productCategory =
            document.getElementById(
                'detailProductCategory'
            );

        if (productCategory) {

            productCategory.textContent =
                product.category;

        }


        /* =====================================================
           PRODUCER / CRAFTSMAN
        ====================================================== */

        const productProducer =
            document.getElementById(
                'detailProductProducer'
            );

        if (productProducer) {

            productProducer.textContent =
                'Craftsman: ' +
                product.producer;

        }


        /* =====================================================
           PRICE
        ====================================================== */

        const productPrice =
            document.getElementById(
                'detailProductPrice'
            );

        if (productPrice) {

            productPrice.textContent =
                '₱' +
                product.price.toFixed(2);

        }


        /* =====================================================
           STOCK
        ====================================================== */

        const productStock =
            document.getElementById(
                'detailProductStock'
            );

        if (productStock) {

            productStock.textContent =
                product.stock;

        }


        /* =====================================================
           DESCRIPTION
        ====================================================== */

        const productDescription =
            document.getElementById(
                'detailProductDescription'
            );

        if (productDescription) {

            productDescription.textContent =
                product.description;

        }



        /* =====================================================
           PRODUCT IMAGE
        ====================================================== */

        const image =
            document.getElementById(
                'detailProductImage'
            );

        const noImage =
            document.getElementById(
                'detailNoImage'
            );


        if (product.image) {

            if (image) {

                image.src =
                    product.image;

                image.style.display =
                    'block';

            }

            if (noImage) {

                noImage.style.display =
                    'none';

            }

        } else {

            if (image) {

                image.style.display =
                    'none';

            }

            if (noImage) {

                noImage.style.display =
                    'flex';

            }

        }



        /* =====================================================
           OPEN PRODUCT DETAILS MODAL
        ====================================================== */

       /* =========================================================
   OPEN PRODUCT DETAILS MODAL
   ---------------------------------------------------------
   Opens the modal when the eye icon is clicked.
========================================================= */

if (productDetailsModal) {

    if (typeof bootstrap !== 'undefined') {

        const modal =
            bootstrap.Modal.getOrCreateInstance(
                productDetailsModal
            );

        modal.show();

    } else {

        /*
        ------------------------------------------------------
        FALLBACK
        ------------------------------------------------------
        If Bootstrap JavaScript is not loaded, manually show
        the modal.
        */

        productDetailsModal.style.display = 'block';

        productDetailsModal.classList.add('show');

        productDetailsModal.setAttribute(
            'aria-hidden',
            'false'
        );

        productDetailsModal.setAttribute(
            'aria-modal',
            'true'
        );

        productDetailsModal.removeAttribute(
            'aria-hidden'
        );

        document.body.classList.add(
            'modal-open'
        );

    }

}

    };



    /* =========================================================
       ADD PRODUCT TO ORDER
    ========================================================== */

    function addSingleProduct(product)
    {

        productForModal =
            product;


        if (quantityInput) {

            quantityInput.value =
                1;

            quantityInput.min =
                1;

            quantityInput.max =
                product.stock;

        }


        /* -----------------------------------------------------
           Hide Search Results
        ------------------------------------------------------ */

        if (productResults) {

            productResults.style.display =
                'none';

        }

    }



    /* =========================================================
       ADD TO ORDER BUTTON INSIDE MODAL
    ========================================================== */

    /* =========================================================
       ADD TO ORDER BUTTON INSIDE MODAL
       ---------------------------------------------------------
       1. Gets the product currently shown in the modal.
       2. Adds it to Selected Products.
       3. Closes the Product Details modal.
    ========================================================== */

    if (addProductButton) {

        addProductButton.addEventListener(
            'click',
            function (event) {

                event.preventDefault();
                event.stopPropagation();

                if (!productForModal) {

                    window.alert(
                        'Please select a product first.'
                    );

                    return;

                }

                const added =
                    addProduct(productForModal);

                if (!added) {
                    return;
                }

                closeProductModal();

            }
        );

    }



    /* =========================================================
       PRODUCT SEARCH
       ---------------------------------------------------------
       IMPORTANT:
       DITO ANG SEARCH AT EYE ICON FUNCTIONALITY.
    ========================================================== */

    function searchProducts()
    {

        if (
            !productSearch ||
            !categoryFilter ||
            !productResults
        ) {

            return;

        }


        const search =
            productSearch.value
                .trim()
                .toLowerCase();

        const category =
            categoryFilter.value;



        /* =====================================================
           DEFAULT SEARCH MESSAGE
        ====================================================== */

        if (
            search === '' &&
            category === ''
        ) {

            productResults.innerHTML = `

                <div class="text-muted small py-2">

                    Search for a product to add to the order.

                </div>

            `;

            productResults.style.display =
                'block';

            return;

        }



        /* =====================================================
           CLEAR OLD RESULTS
        ====================================================== */

        productResults.innerHTML = '';



        /* =====================================================
           FILTER PRODUCTS
        ====================================================== */

        const matches =
            products.filter(
                function (product) {

                    const matchesSearch =
                        search === '' ||
                        product.name
                            .toLowerCase()
                            .includes(search);


                    const matchesCategory =
                        category === '' ||
                        product.category_id ==
                        category;


                    return (
                        matchesSearch &&
                        matchesCategory
                    );

                }
            );



        /* =====================================================
           NO PRODUCTS FOUND
        ====================================================== */

        if (matches.length === 0) {

            productResults.innerHTML = `

                <div class="list-group-item text-muted">

                    No products found.

                </div>

            `;

            productResults.style.display =
                'block';

            return;

        }



        /* =====================================================
           DISPLAY SEARCH RESULTS
           -----------------------------------------------------
           IMPORTANT:
           ANG EYE ICON DITO AY GINAWANG ACTUAL BUTTON.
           
           Dati:
               <i class="bi bi-eye"></i>
           
           Ngayon:
               <button class="product-view-btn">
                   <i class="bi bi-eye"></i>
               </button>
           
           Kaya clickable na mismo ang eye.
        ========================================================== */

        matches.forEach(
            function (product) {

                /*
                |--------------------------------------------------------------------------
                | Search Result Container
                |--------------------------------------------------------------------------
                */

                const item =
                    document.createElement(
                        'div'
                    );


                item.className =
                    'list-group-item list-group-item-action';


                /*
                |--------------------------------------------------------------------------
                | Search Result Layout
                |--------------------------------------------------------------------------
                | PINANATILI ANG EXISTING LAYOUT.
                |--------------------------------------------------------------------------
                */

                item.innerHTML = `

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="fw-semibold">

                                ${product.name}

                            </div>


                            <small class="text-muted">

                                ${product.category}

                                • ₱${product.price.toFixed(2)}

                                • ${product.stock} in stock

                            </small>

                        </div>


                        {{-- =================================================
                             CLICKABLE EYE BUTTON
                             -------------------------------------------------
                             Ito lang ang pangunahing binago.
                        ================================================== --}}

                        <button
                            type="button"
                            class="btn btn-sm btn-outline-warning product-view-btn"
                            title="View Product"
                            aria-label="View ${product.name}"
                        >

                            <i class="bi bi-eye"></i>

                        </button>

                    </div>

                `;



                /* =====================================================
                   FIND EYE BUTTON
                ====================================================== */

                const viewButton =
                    item.querySelector(
                        '.product-view-btn'
                    );



                /* =====================================================
                   EYE ICON CLICK EVENT
                   -----------------------------------------------------
                   Kapag pinindot:
                   1. Stop default behavior
                   2. Stop parent event
                   3. Open Product Details Modal
                ====================================================== */

                if (viewButton) {

                    viewButton.addEventListener(
                        'click',
                        function (event) {

                            event.preventDefault();

                            event.stopPropagation();

                            showProductDetails(
                                product
                            );

                        }
                    );

                }



                /* =====================================================
                   ADD RESULT TO SEARCH LIST
                ====================================================== */

                productResults.appendChild(
                    item
                );

            }
        );


        productResults.style.display =
            'block';

    }



    /* =========================================================
       SEARCH INPUT EVENT
    ========================================================== */

    if (productSearch) {

        productSearch.addEventListener(
            'input',
            searchProducts
        );

    }



    /* =========================================================
       CATEGORY FILTER EVENT
    ========================================================== */

    if (categoryFilter) {

        categoryFilter.addEventListener(
            'change',
            searchProducts
        );

    }



    /* =========================================================
       UPDATE ORDER SUMMARY
    ========================================================== */

    function updateOrderSummary()
    {

        let totalQuantity = 0;

        let totalAmount = 0;


        orderItems.forEach(
            function (item) {

                totalQuantity +=
                    item.quantity;

                totalAmount +=
                    item.price *
                    item.quantity;

            }
        );


        const summaryItemCount =
            document.getElementById(
                'summaryItemCount'
            );

        const summaryQuantity =
            document.getElementById(
                'summaryQuantity'
            );

        const summaryTotal =
            document.getElementById(
                'summaryTotal'
            );


        if (summaryItemCount) {

            summaryItemCount.textContent =
                orderItems.size;

        }


        if (summaryQuantity) {

            summaryQuantity.textContent =
                totalQuantity;

        }


        if (summaryTotal) {

            summaryTotal.textContent =
                '₱' +
                totalAmount.toFixed(2);

        }

    }



    /* =========================================================
       QUANTITY EVENT
    ========================================================== */

    if (quantityInput) {

        quantityInput.addEventListener(
            'input',
            function () {

                if (!productForModal) {

                    return;

                }


                let quantity =
                    parseInt(
                        this.value
                    ) || 1;


                if (
                    quantity < 1
                ) {

                    quantity =
                        1;

                }


                if (
                    quantity >
                    productForModal.stock
                ) {

                    quantity =
                        productForModal.stock;

                }


                this.value =
                    quantity;


                updateOrderSummary();

            }
        );

    }



    /* =========================================================
       FORMAT CURRENCY
    ========================================================== */

    function formatCurrency(amount)
    {

        return String.fromCharCode(8369) +
            amount.toFixed(2);

    }



    /* =========================================================
       RENDER SELECTED PRODUCTS
    ========================================================== */

    function renderOrderItems()
    {

        const selectedProducts =
            document.getElementById(
                'selectedProducts'
            );

        const orderItemsInputs =
            document.getElementById(
                'orderItemsInputs'
            );

        const summaryItemCount =
            document.getElementById(
                'summaryItemCount'
            );

        const summaryQuantity =
            document.getElementById(
                'summaryQuantity'
            );

        const summaryTotal =
            document.getElementById(
                'summaryTotal'
            );

        const validationMessage =
            document.getElementById(
                'orderValidationMessage'
            );


        if (
            !selectedProducts ||
            !orderItemsInputs
        ) {

            return;

        }


        /* -----------------------------------------------------
           Clear Existing Content
        ------------------------------------------------------ */

        selectedProducts.innerHTML =
            '';

        orderItemsInputs.innerHTML =
            '';



        /* -----------------------------------------------------
           Convert Map To Array
        ------------------------------------------------------ */

        const items =
            Array.from(
                orderItems.values()
            );


        const totalQuantity =
            items.reduce(
                function (total, item) {

                    return total +
                        item.quantity;

                },
                0
            );


        const totalAmount =
            items.reduce(
                function (total, item) {

                    return total +
                        (
                            item.price *
                            item.quantity
                        );

                },
                0
            );



        /* =====================================================
           EMPTY STATE
        ====================================================== */

        if (
            items.length === 0
        ) {

            selectedProducts.innerHTML = `

                <div class="border rounded-3 p-3 text-center text-muted small">

                    No products added to this order yet.

                </div>

            `;

        }



        /* =====================================================
           DISPLAY EACH SELECTED PRODUCT
        ====================================================== */

        items.forEach(
            function (item, index) {

                const subtotal =
                    item.price *
                    item.quantity;


                const line =
                    document.createElement(
                        'div'
                    );


                line.className =
                    'border rounded-3 p-3 mb-2';


                line.innerHTML = `

                    <div class="d-flex justify-content-between align-items-start gap-3">

                        <div>

                            <div class="fw-semibold">

                                ${item.name}

                            </div>

                            <small class="text-muted">

                                Unit price:
                                ${formatCurrency(item.price)}

                            </small>

                        </div>


                        {{-- Remove Product --}}

                        <button
                            type="button"
                            class="btn btn-sm btn-outline-danger"
                            data-action="remove"
                        >

                            <i class="bi bi-trash"></i>

                        </button>

                    </div>


                    <div class="d-flex justify-content-between align-items-center mt-3">


                        {{-- Quantity Controls --}}

                        <div
                            class="btn-group btn-group-sm"
                            role="group"
                        >

                            <button
                                type="button"
                                class="btn btn-light border"
                                data-action="decrease"
                                ${item.quantity <= 1 ? 'disabled' : ''}
                            >

                                <i class="bi bi-dash"></i>

                            </button>


                            <span class="btn btn-light border disabled">

                                ${item.quantity}

                            </span>


                            <button
                                type="button"
                                class="btn btn-light border"
                                data-action="increase"
                                ${item.quantity >= item.stock ? 'disabled' : ''}
                            >

                                <i class="bi bi-plus"></i>

                            </button>

                        </div>


                        {{-- Subtotal --}}

                        <div class="text-end">

                            <small class="text-muted d-block">
                                Subtotal
                            </small>

                            <span class="fw-semibold">

                                ${formatCurrency(subtotal)}

                            </span>

                        </div>

                    </div>

                `;



                /* =================================================
                   DECREASE QUANTITY
                ================================================== */

                line
                    .querySelector(
                        '[data-action="decrease"]'
                    )
                    .addEventListener(
                        'click',
                        function () {

                            updateItemQuantity(
                                item.id,
                                -1
                            );

                        }
                    );



                /* =================================================
                   INCREASE QUANTITY
                ================================================== */

                line
                    .querySelector(
                        '[data-action="increase"]'
                    )
                    .addEventListener(
                        'click',
                        function () {

                            updateItemQuantity(
                                item.id,
                                1
                            );

                        }
                    );



                /* =================================================
                   REMOVE PRODUCT
                ================================================== */

                line
                    .querySelector(
                        '[data-action="remove"]'
                    )
                    .addEventListener(
                        'click',
                        function () {

                            orderItems.delete(
                                item.id
                            );

                            renderOrderItems();

                        }
                    );



                selectedProducts.appendChild(
                    line
                );



                /* =================================================
                   HIDDEN INPUTS FOR LARAVEL
                ================================================== */

                [
                    'product_id',
                    'quantity'
                ].forEach(
                    function (field) {

                        const input =
                            document.createElement(
                                'input'
                            );


                        input.type =
                            'hidden';


                        input.name =
                            `items[${index}][${field}]`;


                        input.value =
                            item[
                                field === 'product_id'
                                    ? 'id'
                                    : field
                            ];


                        orderItemsInputs.appendChild(
                            input
                        );

                    }
                );

            }
        );



        /* =====================================================
           UPDATE SUMMARY
        ====================================================== */

        summaryItemCount.textContent =
            items.length;


        summaryQuantity.textContent =
            totalQuantity;


        summaryTotal.textContent =
            formatCurrency(
                totalAmount
            );



        /* =====================================================
           HIDE VALIDATION MESSAGE
        ====================================================== */

        if (
            items.length > 0 &&
            validationMessage
        ) {

            validationMessage.classList.add(
                'd-none'
            );

        }

    }



    /* =========================================================
       UPDATE PRODUCT QUANTITY
    ========================================================== */

    function updateItemQuantity(
        productId,
        change
    )
    {

        const item =
            orderItems.get(
                productId
            );


        if (!item) {

            return;

        }


        item.quantity =
            Math.min(
                item.stock,
                Math.max(
                    1,
                    item.quantity +
                    change
                )
            );


        renderOrderItems();

    }



    /* =========================================================
       ADD PRODUCT
    ========================================================== */

    function addProduct(product)
    {

        const availableStock =
            Number(product.stock) ||
            0;


        /* -----------------------------------------------------
           OUT OF STOCK
        ------------------------------------------------------ */

        if (
            availableStock < 1
        ) {

            window.alert(
                'This product cannot be added because it is out of stock.'
            );

            return false;

        }



        /* -----------------------------------------------------
           CHECK IF PRODUCT ALREADY EXISTS
        ------------------------------------------------------ */

        const existingItem =
            orderItems.get(
                product.id
            );


        if (existingItem) {

            if (
                existingItem.quantity >=
                existingItem.stock
            ) {

                window.alert(
                    'The selected quantity already matches the available stock.'
                );

                return false;

            }


            existingItem.quantity =
                Math.min(
                    existingItem.stock,
                    existingItem.quantity +
                    1
                );

        } else {

            orderItems.set(
                product.id,
                {
                    ...product,
                    quantity: 1,
                }
            );

        }



        /* -----------------------------------------------------
           Refresh Selected Products
        ------------------------------------------------------ */

        renderOrderItems();



        /* -----------------------------------------------------
           Hide Search Results
        ------------------------------------------------------ */

        if (productResults) {

            productResults.style.display =
                'none';

        }


        return true;

    }



    /* =========================================================
       CREATE ORDER FORM VALIDATION
    ========================================================== */

    const createOrderForm =
        document.getElementById(
            'createOrderForm'
        );


    if (createOrderForm) {

        createOrderForm.addEventListener(
            'submit',
            function (event) {

                if (
                    orderItems.size > 0
                ) {

                    return;

                }


                event.preventDefault();


                const validationMessage =
                    document.getElementById(
                        'orderValidationMessage'
                    );


                if (validationMessage) {

                    validationMessage.classList.remove(
                        'd-none'
                    );

                }

            }
        );

    }



    /* =========================================================
       INITIAL SEARCH STATE
    ========================================================== */

    if (productResults) {

        productResults.innerHTML = `

            <div class="text-muted small py-2">

                Search for a product to add to the order.

            </div>

        `;

        productResults.style.display =
            'block';

    }



    /* =========================================================
       INITIALIZE ORDER ITEMS
    ========================================================== */

    renderOrderItems();

});

</script>

@endsection