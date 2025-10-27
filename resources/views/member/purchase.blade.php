@extends('masterview')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('main')
    <div class="purchase-main-container">
        <h2 class="orders-heading">My Orders</h2>

        <div class="order-card">
            <div class="order-left">
                <span class="order-logo"><i class="fa-solid fa-box-archive"></i></span>
                <div class="order-details">
                    <strong>Men Shirt, Men Jacket</strong>
                    <p>Items: 2</p>
                </div>
            </div>
    
            <div class="order-center">
                <p><strong>GreatStack</strong></p>
                <p>123 Layout, Whitefield</p>
                <p>Bangalore, Karnataka</p>
                <p>0123456789</p>
            </div>
    
            <div class="order-price">
                <strong>₹1426.97</strong>
            </div>
    
            <div class="order-right">
                <p>Method: COD</p>
                <p>Date: 2/14/2025</p>
                <p>Payment: Pending</p>
            </div>
        </div>
        <div class="order-card">
            <div class="order-left">
                <span class="order-logo"><i class="fa-solid fa-box-archive"></i></span>
                <div class="order-details">
                    <strong>Men Shirt, Men Jacket</strong>
                    <p>Items: 2</p>
                </div>
            </div>
    
            <div class="order-center">
                <p><strong>GreatStack</strong></p>
                <p>123 Layout, Whitefield</p>
                <p>Bangalore, Karnataka</p>
                <p>0123456789</p>
            </div>
    
            <div class="order-price">
                <strong>₹1426.97</strong>
            </div>
    
            <div class="order-right">
                <p>Method: COD</p>
                <p>Date: 2/14/2025</p>
                <p>Payment: Pending</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection