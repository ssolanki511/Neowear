@extends('amaster')
@section('main_content')
<div tabindex="-1"
    class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full backdrop-blur-sm bg-gray-900/30">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm border-2 border-gray-200">
            <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    Product Details
                </h3>
                <button onclick="closeModal()" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                <div class="flex flex-col items-center mb-4">
                    <img src="{{ asset('images/product_images/'.$p->p_image) }}"
                        alt="Product Image" class="w-32 h-32 object-cover rounded mb-3" />
                    <span class="text-2xl font-bold text-gray-900">{{ $p->p_name }}</span>
                </div>
                {{-- Display other images --}}
                @if(!empty($p->p_other_images))
                <div class="mb-4 flex flex-wrap justify-center gap-2">
                    @foreach(explode(',', $p->p_other_images) as $otherImage)
                        @if(trim($otherImage) !== '')
                        <img src="{{ asset('images/product_images/' . trim($otherImage)) }}"
                             alt="Other Image"
                             class="w-17 h-17 object-cover rounded border p-0.5 border-gray-500" />
                        @endif
                    @endforeach
                </div>
                @endif
                <div class="mb-2">
                    <span class="font-semibold text-gray-700">Category:</span>
                    <span class="ml-2 text-gray-900">{{ $p->p_category }}</span>
                </div>
                <div class="mb-2">
                    <span class="font-semibold text-gray-700">Price:</span>
                    <span class="ml-2 text-gray-900">{{ $p->p_price }}</span>
                </div>
                <div class="mb-2">
                    <span class="font-semibold text-gray-700">Offer:</span>
                    <span class="ml-2 text-gray-900">{{ $p->p_offer }}</span>
                </div>
                <div class="mb-2">
                    <span class="font-semibold text-gray-700">Sizes & Quantity:</span>
                    @php
                        $sizes = json_decode($p->p_size_quatity, true) ?? [];
                    @endphp
                    <ul class="ml-2 text-gray-900">
                        @forelse($sizes as $size => $qty)
                            <li>{{ $size }}: {{ $qty }}</li>
                        @empty
                            <li>No sizes available</li>
                        @endforelse
                    </ul>
                </div>
                <div class="mb-2">
                    <span class="font-semibold text-gray-700">Description:</span>
                    <span class="ml-2 text-gray-900">{{ $p->p_description }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function closeModal() {
        window.location.href = "{{ url('admin_products') }}";
    }
</script>
@endsection