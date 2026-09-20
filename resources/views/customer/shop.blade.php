@extends('customer.layouts.customer')

@section('title', 'Shop')

@section('content')

<div class="shop-page">

    {{-- =========================
        SHOP HERO
    ========================== --}}
    <section class="shop-hero">

        <div class="shop-hero-pattern pattern-left"></div>
        <div class="shop-hero-pattern pattern-right"></div>

        <div class="shop-hero-content">

            <div class="shop-intro">
                <span class="shop-eyebrow">
                    MINDORICH COLLECTION
                </span>

                <h1>
                    Shop Our Collection
                </h1>

                <p>
                    Discover authentic Mangyan artisan products,
                    thoughtfully crafted and proudly connected to the
                    local community.
                </p>
            </div>

            {{-- Search --}}
            <form
                action="{{ route('customer.shop') }}"
                method="GET"
                class="shop-search"
            >

                <div class="shop-search-input">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search products, categories, artisans..."
                    >

                </div>

                <button type="submit">
                    <i class="bi bi-search"></i>
                    Search
                </button>

            </form>

        </div>

        {{-- =========================
            CATEGORY CHIPS
        ========================== --}}
        <div class="category-list">

            <a
                href="{{ route('customer.shop') }}"
                class="category-chip {{ !request('category') ? 'active' : '' }}"
            >
                <i class="bi bi-grid"></i>
                <span>All Products</span>
            </a>

            @foreach($categories as $category)

                <a
                    href="{{ route('customer.shop', ['category' => $category->id]) }}"
                    class="category-chip {{ request('category') == $category->id ? 'active' : '' }}"
                >
                    <i class="bi bi-bag"></i>
                    <span>{{ $category->category_name }}</span>
                </a>

            @endforeach

        </div>

    </section>


    {{-- =========================
        FILTER BAR
    ========================== --}}
    <section class="shop-filter-wrapper">

        <form
            action="{{ route('customer.shop') }}"
            method="GET"
            class="shop-filter-bar"
        >

            {{-- Keep search --}}
            @if(request('search'))
                <input
                    type="hidden"
                    name="search"
                    value="{{ request('search') }}"
                >
            @endif

            @if(request('category'))
                <input
                    type="hidden"
                    name="category"
                    value="{{ request('category') }}"
                >
            @endif


            {{-- Filter --}}
            <div class="filter-group">

                <span class="filter-label">
                    Filter By:
                </span>

                <button
                    type="button"
                    class="filter-pill active"
                    onclick="clearFilters()"
                >
                    All
                </button>

                <button
                    type="button"
                    class="filter-pill"
                    onclick="filterInStock()"
                >
                    <span class="stock-dot"></span>
                    In Stock
                </button>

            </div>


            {{-- Price --}}
            <div class="price-filter">

                <span class="filter-label">
                    Price Range:
                </span>

                <input
                    type="number"
                    name="min_price"
                    value="{{ request('min_price') }}"
                    placeholder="Min price"
                >

                <span>to</span>

                <input
                    type="number"
                    name="max_price"
                    value="{{ request('max_price') }}"
                    placeholder="Max price"
                >

            </div>


            {{-- Sort --}}
            <div class="sort-group">

                <span class="filter-label">
                    Sort By:
                </span>

                <select
                    name="sort"
                    onchange="this.form.submit()"
                >

                    <option value="latest"
                        {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>
                        Latest
                    </option>

                    <option value="price_low"
                        {{ request('sort') === 'price_low' ? 'selected' : '' }}>
                        Price: Low to High
                    </option>

                    <option value="price_high"
                        {{ request('sort') === 'price_high' ? 'selected' : '' }}>
                        Price: High to Low
                    </option>

                </select>

            </div>


            <button
                type="submit"
                class="filter-search-btn"
            >
                <i class="bi bi-funnel"></i>
                Apply
            </button>

        </form>

    </section>


    {{-- =========================
        PRODUCTS HEADER
    ========================== --}}
    <section class="products-section">

        <div class="products-header">

    <div>

        <span class="products-count">
            {{ $products->total() }} PRODUCTS
        </span>

        <h2>
            Our Products
        </h2>

    </div>

    <div class="d-flex align-items-center gap-3">

        <a
            href="{{ route('customer.favorites') }}"
            class="btn btn-outline-warning"
        >
            <i class="bi bi-heart me-1"></i>
            My Favorites
        </a>

        <div class="product-result-count">
            Showing
            {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}
            of {{ $products->total() }}
        </div>

    </div>

</div>


        {{-- =========================
            PRODUCT GRID
        ========================== --}}
        <div class="product-grid">

            @forelse($products as $product)

                <div
                    class="product-card"
                    data-stock="{{ $product->stock }}"
                >

                    {{-- IMAGE --}}
                    <div class="product-image-wrapper">

                        @if($product->featured_image)

                            <img
                                src="{{ asset('storage/' . $product->featured_image) }}"
                                alt="{{ $product->product_name }}"
                                class="product-image"
                            >

                        @else

                            <div class="product-no-image">
                                <i class="bi bi-image"></i>
                                <span>No Image</span>
                            </div>

                        @endif


                        {{-- Stock --}}
                        @if($product->stock > 0)

                            <span class="product-stock">
                                <span></span>
                                In Stock
                            </span>

                        @else

                            <span class="product-stock out">
                                Out of Stock
                            </span>

                        @endif

{{-- Wishlist --}}
@php
    $isFavorite = auth()->user()
        ->favorites
        ->contains($product->id);
@endphp

<form
    action="{{ route('customer.favorites.toggle', $product) }}"
    method="POST"
    class="wishlist-form"
>
    @csrf

    <button
        type="submit"
        class="wishlist-btn"
        title="{{ $isFavorite ? 'Remove from favorites' : 'Add to favorites' }}"
        aria-label="{{ $isFavorite ? 'Remove from favorites' : 'Add to favorites' }}"
    >
        <i class="bi {{ $isFavorite ? 'bi-heart-fill' : 'bi-heart' }}"></i>
    </button>
</form>

                    </div>


                    {{-- PRODUCT INFO --}}
                    <div class="product-info">

                        <span class="product-category">
                            {{ $product->category?->category_name ?? 'Uncategorized' }}
                        </span>

                        <h3>
                            {{ $product->product_name }}
                        </h3>


                        {{-- Producer --}}
                        <p class="product-producer">

                            Crafted by

                            <strong>
                                {{ $product->producer?->producer_name ?? 'Mangyan Artisan' }}
                            </strong>

                        </p>


                        {{-- Price --}}
@php
    $pricing = $product->pricing();
@endphp

<div class="product-price">

    @if($pricing['promotion'])

        <div class="mb-1">
            <span
                class="badge bg-danger"
                style="font-size:11px;"
            >
                🔥 HOT DEAL
            </span>
        </div>

        <span
            class="text-muted text-decoration-line-through me-2"
            style="font-size:14px;"
        >
            ₱{{ number_format($pricing['original_price'], 2) }}
        </span>

        <strong>
            ₱{{ number_format($pricing['effective_price'], 2) }}
        </strong>

    @else

        ₱{{ number_format($pricing['original_price'], 2) }}

    @endif

</div>


                        {{-- Actions --}}
                        <div class="product-actions">

    {{-- ADD TO CART --}}
    @if($product->stock > 0)

        <form
            action="{{ route('customer.cart.add', $product->id) }}"
            method="POST"
            class="add-cart-form"
        >
            @csrf

            <button
                type="submit"
                class="add-cart-btn"
            >
                <i class="bi bi-cart-plus"></i>
                Add to Cart
            </button>
        </form>

    @else

        <button
            type="button"
            class="add-cart-btn disabled"
            disabled
        >
            Out of Stock
        </button>

    @endif


    {{-- BUY NOW --}}
    <a
        href="{{ route('customer.product.show', $product->id) }}"
        class="buy-now-btn"
    >
        <i class="bi bi-lightning-fill"></i>
        Buy Now
    </a>

</div>


        

                        </div>

                    </div>

                

            @empty

                <div class="empty-shop">

                    <div class="empty-shop-icon">
                        <i class="bi bi-bag-x"></i>
                    </div>

                    <h3>
                        No Products Found
                    </h3>

                    <p>
                        We couldn't find any products matching your search.
                    </p>

                    <a
                        href="{{ route('customer.shop') }}"
                        class="reset-shop-btn"
                    >
                        Browse All Products
                    </a>

                </div>

            @endforelse

        </div>


        {{-- =========================
            PAGINATION
        ========================== --}}
        @if($products->hasPages())

            <div class="shop-pagination">

                {{ $products->links('pagination::bootstrap-5') }}

            </div>

        @endif

    </section>

</div>


{{-- =========================
    JAVASCRIPT
========================== --}}
<script>

function clearFilters()
{
    window.location.href = "{{ route('customer.shop') }}";
}

function filterInStock()
{
    document.querySelectorAll('.product-card').forEach(function(card) {

        const stock = parseInt(
            card.getAttribute('data-stock')
        );

        if(stock <= 0) {
            card.style.display = 'none';
        } else {
            card.style.display = '';
        }

    });
}

</script>

@endsection