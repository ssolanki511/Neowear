@extends('amaster')
@section('main_content')
{{-- Loader Overlay --}}
<div id="loader-overlay" class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-opacity duration-500">
    <div class="flex flex-col items-center">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500 border-solid mb-4"></div>
        <span class="text-blue-600 font-bold text-lg" style="font-family: 'Orbitron', Arial, sans-serif;">NeoWear</span>
    </div>
</div>

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 py-12 px-4">
    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col items-center mb-10">
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight mb-1" style="font-family: 'Orbitron', Arial, sans-serif;">
                Welcome to <span class="text-blue-600">NeoWear</span> Dashboard
            </h1>
            {{-- <p class="text-sm text-gray-500 text-center max-w-xl">Manage your e-commerce business with style and ease.</p> --}}
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3  gap-4">
            <!-- Products Card -->
            <a href="{{ route('products') }}"
                class="group bg-white rounded-lg shadow-md border-t-4 border-blue-200 hover:border-blue-500 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl flex flex-col items-center p-3 cursor-pointer w-full max-w-xs mx-auto">
                <div class="bg-blue-100 rounded-full p-2 mb-2 transition-all duration-300 group-hover:scale-105">
                    <i class="ri-shopping-bag-3-line text-lg text-blue-600"></i>
                </div>
                <h3 class="text-sm font-bold text-gray-800 mb-0.5">Products</h3>
                <p class="text-xs text-gray-500 mb-1">Total Products: <span class="font-semibold">{{ $product_count }}</span></p>
                <span class="inline-flex items-center text-blue-600 font-semibold group-hover:underline text-xs">
                    See More
                    <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="m9 18 6-6-6-6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </a>
            <!-- Orders Card -->
            <a href="{{ route('orders') }}"
                class="group bg-white rounded-lg shadow-md border-t-4 border-green-200 hover:border-green-500 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl flex flex-col items-center p-3 cursor-pointer w-full max-w-xs mx-auto">
                <div class="bg-green-100 rounded-full p-2 mb-2 transition-all duration-300 group-hover:scale-105">
                    <i class="ri-file-list-3-line text-lg text-green-600"></i>
                </div>
                <h3 class="text-sm font-bold text-gray-800 mb-0.5">Orders</h3>
                <p class="text-xs text-gray-500 mb-1">Total Orders: <span class="font-semibold">{{ $orders_count }}</span></p>
                <span class="inline-flex items-center text-green-600 font-semibold group-hover:underline text-xs">
                    See More
                    <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="m9 18 6-6-6-6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </a>
            <!-- Users Card -->
            <a href="{{ route('users') }}"
                class="group bg-white rounded-lg shadow-md border-t-4 border-purple-200 hover:border-purple-500 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl flex flex-col items-center p-3 cursor-pointer w-full max-w-xs mx-auto">
                <div class="bg-purple-100 rounded-full p-2 mb-2 transition-all duration-300 group-hover:scale-105">
                    <i class="ri-user-3-line text-lg text-purple-600"></i>
                </div>
                <h3 class="text-sm font-bold text-gray-800 mb-0.5">Users</h3>
                <p class="text-xs text-gray-500 mb-1">Total Users: <span class="font-semibold">{{ $users_count }}</span></p>
                <span class="inline-flex items-center text-purple-600 font-semibold group-hover:underline text-xs">
                    See More
                    <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="m9 18 6-6-6-6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </a>
            <!-- Inquiries Card -->
            <a href="{{ route('inquires') }}"
                class="group bg-white rounded-lg shadow-md border-t-4 border-yellow-200 hover:border-yellow-500 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl flex flex-col items-center p-3 cursor-pointer w-full max-w-xs mx-auto">
                <div class="bg-yellow-100 rounded-full p-2 mb-2 transition-all duration-300 group-hover:scale-105">
                    <i class="ri-question-answer-line text-lg text-yellow-600"></i>
                </div>
                <h3 class="text-sm font-bold text-gray-800 mb-0.5">Inquiries</h3>
                <p class="text-xs text-gray-500 mb-1">Total Inquiries: <span class="font-semibold">{{ $users_msg_count }}</span></p>
                <span class="inline-flex items-center text-yellow-600 font-semibold group-hover:underline text-xs">
                    See More
                    <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="m9 18 6-6-6-6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </a>
            <!-- Offers Card -->
            <a href="{{ route('offers') }}"
                class="group bg-white rounded-lg shadow-md border-t-4 border-pink-200 hover:border-pink-500 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl flex flex-col items-center p-3 cursor-pointer w-full max-w-xs mx-auto">
                <div class="bg-pink-100 rounded-full p-2 mb-2 transition-all duration-300 group-hover:scale-105">
                    <i class="ri-price-tag-3-line text-lg text-pink-600"></i>
                </div>
                <h3 class="text-sm font-bold text-gray-800 mb-0.5">Offers</h3>
                <p class="text-xs text-gray-500 mb-1">Total Offers: <span class="font-semibold">{{ $offers_count }}</span></p>
                <span class="inline-flex items-center text-pink-600 font-semibold group-hover:underline text-xs">
                    See More
                    <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="m9 18 6-6-6-6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </a>
            <!-- Categories Card -->
            <a href="{{ route('categories') }}"
                class="group bg-white rounded-lg shadow-md border-t-4 border-indigo-200 hover:border-indigo-500 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl flex flex-col items-center p-3 cursor-pointer w-full max-w-xs mx-auto">
                <div class="bg-indigo-100 rounded-full p-2 mb-2 transition-all duration-300 group-hover:scale-105">
                    <i class="ri-apps-2-line text-lg text-indigo-600"></i>
                </div>
                <h3 class="text-sm font-bold text-gray-800 mb-0.5">Categories</h3>
                <p class="text-xs text-gray-500 mb-1">Total Categories: <span class="font-semibold">{{ $categories_count }}</span></p>
                <span class="inline-flex items-center text-indigo-600 font-semibold group-hover:underline text-xs">
                    See More
                    <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="m9 18 6-6-6-6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </a>
        </div>
    </div>
</div>

{{-- jQuery CDN (if not already included) --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(window).on('load', function () {
        $('#loader-overlay').fadeOut(600);
    });
</script>
@endsection
