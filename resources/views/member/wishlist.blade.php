@extends('masterview')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/wishlist.css') }}">
@endsection

@section('main')
    <div class="wishlist-main-container">
        <h2 class="wishlist-heading">My Wishlist</h2>
        @if(count($products) > 0)
            @foreach ($products as $product)
                <div class="wishlist-card">
                    <div class="wishlist-left">
                        <a href="{{ url('/product/'.$product->id) }}"><img src="{{ asset('images/product_images/'.$product->p_image) }}" alt="Product Image" /></a>
                        <div class="product-details">
                            <a href="{{ url('/product') }}"><strong>{{ $product->p_name }}</strong></a>
                            @php
                                $discountedPrice = floor($product->p_price - ($product->p_price * $product->p_offer / 100));
                            @endphp
                            <p>₹{{ $discountedPrice }}</p>
                        </div>
                    </div>

                    <div class="wishlist-actions">
                        <a href="{{ url('addToCartFromWishlist/'.$product->id) }}" class="add-cart-btn">Add to Cart</a>
                        <a href="{{ url('removeFromWishlist/'.$product->id) }}" class="remove-btn">Remove</a>
                    </div>
                </div>
            @endforeach
        @else
            <p class="wishlist-empty">Your wishlist is empty.</p>
        @endif
    </div>
@endsection

@section('scripts')
@endsection