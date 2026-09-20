@extends('customer.layouts.customer')

@section('title', $product->product_name)

@section('content')

<div class="product-details-page">

    {{-- Breadcrumb --}}
    <div class="container py-4">
        <div class="product-breadcrumb">
            <a href="{{ route('customer.shop') }}">
                Shop
            </a>

            <i class="bi bi-chevron-right"></i>

            <span>
                {{ $product->product_name }}
            </span>
        </div>
    </div>


    {{-- Product Details --}}
    <section class="product-details-section">

        <div class="container">

            <div class="row g-5 align-items-start">

                {{-- =====================================================
                     PRODUCT IMAGES
                ====================================================== --}}

                <div class="col-lg-6">

                    <div class="product-gallery">

                        {{-- Main Image --}}
                        <div class="product-main-image">

                            @if($product->featured_image)

                                <img
                                    id="mainProductImage"
                                    src="{{ asset('storage/' . $product->featured_image) }}"
                                    alt="{{ $product->product_name }}"
                                >

                            @else

                                <div class="product-no-image">
                                    <i class="bi bi-image"></i>
                                    <span>No Image Available</span>
                                </div>

                            @endif

                        </div>


                        {{-- Thumbnails --}}
                        <div class="product-thumbnails">

                            {{-- Featured Image --}}
                            @if($product->featured_image)

                                <button
                                    type="button"
                                    class="product-thumbnail active"
                                    onclick="changeProductImage(
                                        '{{ asset('storage/' . $product->featured_image) }}',
                                        this
                                    )"
                                >

                                    <img
                                        src="{{ asset('storage/' . $product->featured_image) }}"
                                        alt="{{ $product->product_name }}"
                                    >

                                </button>

                            @endif


                            {{-- Additional Product Images --}}
                            @foreach($product->productImages as $image)

                                @if($image->image)

                                    <button
                                        type="button"
                                        class="product-thumbnail"
                                        onclick="changeProductImage(
                                            '{{ asset('storage/' . $image->image) }}',
                                            this
                                        )"
                                    >

                                        <img
                                            src="{{ asset('storage/' . $image->image) }}"
                                            alt="{{ $product->product_name }}"
                                        >

                                    </button>

                                @endif

                            @endforeach

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                     PRODUCT INFORMATION
                ====================================================== --}}

                <div class="col-lg-6">

                    <div class="product-information">

                        {{-- Category --}}
                        <div class="product-category">

                            <i class="bi bi-tag"></i>

                            {{ $product->category?->category_name ?? 'Handicraft' }}

                        </div>


                        {{-- Product Name --}}
                        <h1 class="product-title">
                            {{ $product->product_name }}
                        </h1>


                        {{-- Rating --}}
@php
    $reviewCount = $product->reviews->count();
    $averageRating = $reviewCount
        ? round($product->reviews->avg('rating'), 1)
        : 0;

    $fullStars = (int) floor($averageRating);
    $hasHalfStar = ($averageRating - $fullStars) >= 0.5;
    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
@endphp

<div class="product-rating">

    <div class="rating-stars">

        @for($i = 0; $i < $fullStars; $i++)
            <i class="bi bi-star-fill"></i>
        @endfor

        @if($hasHalfStar)
            <i class="bi bi-star-half"></i>
        @endif

        @for($i = 0; $i < $emptyStars; $i++)
            <i class="bi bi-star"></i>
        @endfor

    </div>

    <span>
        {{ number_format($averageRating, 1) }}
        ({{ $reviewCount }}
        {{ $reviewCount === 1 ? 'review' : 'reviews' }})
    </span>

</div>


                        {{-- Price --}}
@php
    $pricing = $product->pricing();
@endphp

<div class="product-price">

    @if($pricing['promotion'])

        <div class="mb-2">
            <span
                class="badge bg-danger"
                style="font-size:12px;"
            >
                🔥 HOT DEAL
            </span>
        </div>

        <div>
            <span
                class="text-muted text-decoration-line-through me-2"
                style="font-size:18px;"
            >
                ₱{{ number_format($pricing['original_price'], 2) }}
            </span>

            <strong>
                ₱{{ number_format($pricing['effective_price'], 2) }}
            </strong>
        </div>

    @else

        ₱{{ number_format($pricing['original_price'], 2) }}

    @endif

</div>


                        {{-- Description --}}
                        <div class="product-description">

                            <h5>
                                Product Description
                            </h5>

                            <p>
                                {{ $product->description ?? 'No product description available.' }}
                            </p>

                        </div>


                        {{-- Producer --}}
                        @if($product->producer)

    <div class="product-info-row">

        <span>
            <i class="bi bi-person"></i>
            Craftsman
        </span>

        <strong>
            {{ $product->producer->producer_name }}
        </strong>

    </div>

@endif


                        {{-- Category --}}
                        <div class="product-info-row">

                            <span>
                                <i class="bi bi-grid"></i>
                                Category
                            </span>

                            <strong>
                                {{ $product->category?->category_name ?? 'Uncategorized' }}
                            </strong>

                        </div>


                        {{-- Stock --}}
                        <div class="product-stock-row">

                            @if($product->stock > 0)

                                <span class="stock-available">
                                    <i class="bi bi-check-circle-fill"></i>
                                    {{ $product->stock }} available
                                </span>

                            @else

                                <span class="stock-unavailable">
                                    <i class="bi bi-x-circle-fill"></i>
                                    Out of Stock
                                </span>

                            @endif

                        </div>


                        <hr class="product-divider">


                        {{-- Add to Cart --}}
@if($product->stock > 0)

    {{-- Quantity --}}
    <div class="quantity-section">

        <label>
            Quantity
        </label>

        <div class="quantity-control">

            <button
                type="button"
                onclick="decreaseQuantity()"
            >
                <i class="bi bi-dash"></i>
            </button>

            <input
                type="number"
                id="productQuantity"
                value="1"
                min="1"
                max="{{ $product->stock }}"
                oninput="syncBuyNowQuantity()"
            >

            <button
                type="button"
                onclick="increaseQuantity()"
            >
                <i class="bi bi-plus"></i>
            </button>

        </div>

    </div>


    {{-- ACTION BUTTONS --}}
    <div class="product-action-buttons">

        {{-- ADD TO CART --}}
        <form
            action="{{ route('customer.cart.add', $product->id) }}"
            method="POST"
            class="product-cart-form"
        >

            @csrf

            <input
                type="hidden"
                name="quantity"
                id="cartQuantity"
                value="1"
            >

            <button
                type="submit"
                class="product-add-cart"
            >
                <i class="bi bi-cart-plus"></i>
                Add to Cart
            </button>

        </form>


        {{-- BUY NOW --}}
        <form
            action="{{ route('customer.checkout.buy-now', $product->id) }}"
            method="POST"
            class="buy-now-form"
        >

            @csrf

            <input
                type="hidden"
                name="quantity"
                id="buyNowQuantity"
                value="1"
            >

            <button
                type="submit"
                class="product-buy-now"
            >
                <i class="bi bi-lightning-fill"></i>
                Buy Now
            </button>

        </form>

    </div>

@else

                            <button
                                type="button"
                                class="product-add-cart disabled"
                                disabled
                            >

                                <i class="bi bi-x-circle"></i>

                                Out of Stock

                            </button>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </section>

    {{-- =====================================================
     CUSTOMER REVIEWS
===================================================== --}}
<section class="product-reviews-section py-5">
    <div class="container">

        <div class="mb-4">
            <span class="text-uppercase small fw-semibold text-muted">
                CUSTOMER FEEDBACK
            </span>

            <h2 class="fw-bold mb-1">
                Reviews & Ratings
            </h2>

            <p class="text-muted mb-0">
                See what customers say about this product.
            </p>
        </div>

        @if($product->reviews->count())

            @foreach($product->reviews->sortByDesc('created_at') as $review)

                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-start gap-3">

                            <div>
                                <h6 class="fw-bold mb-1">
                                    {{ $review->user->name ?? 'Customer' }}
                                </h6>

                                <div class="text-warning mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>

                            <small class="text-muted">
                                {{ $review->created_at->format('M d, Y') }}
                            </small>

                        </div>

                        @if($review->body)
                            <p class="text-muted mb-0">
                                {{ $review->body }}
                            </p>
                        @else
                            <p class="text-muted small fst-italic mb-0">
                                No written review.
                            </p>
                        @endif

                    </div>
                </div>

            @endforeach

        @else

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5 text-center">

                    <i class="bi bi-chat-square-text fs-1 text-muted"></i>

                    <h5 class="fw-bold mt-3">
                        No reviews yet
                    </h5>

                    <p class="text-muted mb-0">
                        Be the first customer to review this product.
                    </p>

                </div>
            </div>

        @endif

    </div>
</section>


    {{-- =====================================================
         RELATED PRODUCTS
    ====================================================== --}}

    @if($relatedProducts->count())

        <section class="related-products-section">

            <div class="container">

                <div class="related-products-header">

                    <div>

                        <span class="related-label">
                            EXPLORE MORE
                        </span>

                        <h2>
                            You May Also Like
                        </h2>

                        <p>
                            Discover more authentic Mangyan products.
                        </p>

                    </div>


                    {{-- Slider Controls --}}
                    <div class="related-controls">

                        <button
                            type="button"
                            onclick="scrollRelatedProducts('left')"
                            aria-label="Previous products"
                        >
                            <i class="bi bi-chevron-left"></i>
                        </button>

                        <button
                            type="button"
                            onclick="scrollRelatedProducts('right')"
                            aria-label="Next products"
                        >
                            <i class="bi bi-chevron-right"></i>
                        </button>

                    </div>

                </div>


                {{-- Product Slider --}}
                <div
                    class="related-products-slider"
                    id="relatedProductsSlider"
                >

                    @foreach($relatedProducts as $related)

                        <div class="related-product-card">

                            <a
                                href="{{ route('customer.product.show', $related->id) }}"
                                class="related-product-link"
                            >

                                <div class="related-product-image">

                                    @if($related->featured_image)

                                        <img
                                            src="{{ asset('storage/' . $related->featured_image) }}"
                                            alt="{{ $related->product_name }}"
                                        >

                                    @else

                                        <div class="related-no-image">
                                            <i class="bi bi-image"></i>
                                        </div>

                                    @endif

                                </div>


                                <div class="related-product-info">

                                    <small>
                                        {{ $related->category?->category_name ?? 'Handicraft' }}
                                    </small>

                                    <h5>
                                        {{ $related->product_name }}
                                    </h5>

                                    <div class="related-product-bottom">

                                        <strong>
                                            ₱{{ number_format($related->price, 2) }}
                                        </strong>

                                        @if($related->stock > 0)

                                            <span class="related-stock">
                                                In Stock
                                            </span>

                                        @else

                                            <span class="related-out-stock">
                                                Sold Out
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </a>

                        </div>

                    @endforeach

                </div>

            </div>

        </section>

    @endif

</div>


{{-- =====================================================
     JAVASCRIPT
====================================================== --}}

<script>

    function changeProductImage(imageUrl, thumbnail) {

        const mainImage =
            document.getElementById('mainProductImage');

        if (mainImage) {

            mainImage.style.opacity = '0';

            setTimeout(function () {

                mainImage.src = imageUrl;

                mainImage.onload = function () {

                    mainImage.style.opacity = '1';

                };

            }, 150);

        }


        document
            .querySelectorAll('.product-thumbnail')
            .forEach(function (item) {

                item.classList.remove('active');

            });


        thumbnail.classList.add('active');

    }
    
    function syncBuyNowQuantity() {

    const quantityInput =
        document.getElementById('productQuantity');

    const buyNowQuantity =
        document.getElementById('buyNowQuantity');

    const cartQuantity =
        document.getElementById('cartQuantity');

    if (!quantityInput) return;

    let quantity =
        parseInt(quantityInput.value) || 1;

    const max =
        parseInt(quantityInput.max) || 1;

    if (quantity < 1) {
        quantity = 1;
    }

    if (quantity > max) {
        quantity = max;
    }

    quantityInput.value = quantity;

    if (buyNowQuantity) {
        buyNowQuantity.value = quantity;
    }

    if (cartQuantity) {
        cartQuantity.value = quantity;
    }
}


function increaseQuantity() {

    const input =
        document.getElementById('productQuantity');

    if (!input) return;

    const max =
        parseInt(input.max) || 1;

    const current =
        parseInt(input.value) || 1;

    if (current < max) {

        input.value = current + 1;

    }

    syncBuyNowQuantity();
}


function decreaseQuantity() {

    const input =
        document.getElementById('productQuantity');

    if (!input) return;

    const current =
        parseInt(input.value) || 1;

    if (current > 1) {

        input.value = current - 1;

    }

    syncBuyNowQuantity();
}


    function scrollRelatedProducts(direction) {

        const slider =
            document.getElementById('relatedProductsSlider');

        if (!slider) return;

        const scrollAmount =
            slider.clientWidth * 0.8;

        if (direction === 'left') {

            slider.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });

        } else {

            slider.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });

        }

    }

</script>

@endsection