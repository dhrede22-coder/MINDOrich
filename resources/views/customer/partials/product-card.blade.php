<div class="card h-100">
    <img
        src="{{ $product->featured_image ? asset('storage/' . $product->featured_image) : asset('image/placeholder.png') }}"
        class="card-img-top"
        style="height:180px;object-fit:cover;"
        alt="{{ $product->product_name }}"
    >

    <div class="card-body d-flex flex-column">

        <h6 class="card-title">
            {{ $product->product_name }}
        </h6>

        <p class="card-text text-muted mb-2">
            ₱{{ number_format($product->price, 2) }}
        </p>

        @if(isset($product->units_sold))
            <small class="text-muted mb-2">
                Sold: {{ $product->units_sold }}
            </small>
        @endif

        <div class="mt-auto d-flex justify-content-between align-items-center">

            <form
                action="{{ route('customer.cart.add', $product->id) }}"
                method="POST"
                class="m-0"
            >
                @csrf

                <button
                    type="submit"
                    class="btn btn-sm btn-warning"
                >
                    Add to Cart
                </button>
            </form>

            <a href="#" class="text-muted">
                <i class="bi bi-heart"></i>
            </a>

        </div>

    </div>
</div>