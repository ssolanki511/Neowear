@extends('amaster')
@section('main_content')
<div tabindex="-1"
    class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full backdrop-blur-sm bg-gray-900/30">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm border-2 border-gray-200">
            <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    Order Details
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
                <div class="mb-4">
                    <span class="font-semibold text-gray-700">Order ID:</span>
                    <span class="ml-2 text-gray-900">{{ $order->o_id }}</span>
                </div>
                <div class="mb-4">
                    <span class="font-semibold text-gray-700">Customer:</span>
                    <span class="ml-2 text-gray-900">{{ $order->u_name }}</span>
                    <span class="ml-2 text-sm text-gray-500">({{ $order->user ? $order->user->email : '' }})</span>
                </div>
                <div class="mb-4">
                    <span class="font-semibold text-gray-700">Status:</span>
                    <span class="ml-2 px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">{{ $order->o_status }}</span>
                </div>
                <div class="mb-4">
                    <span class="font-semibold text-gray-700">Order Date:</span>
                    <span class="ml-2 text-gray-900">{{ $order->created_at->format('Y-m-d') }}</span>
                </div>
                <div class="mb-4">
                    <span class="font-semibold text-gray-700">Shipping Address:</span>
                    <span class="ml-2 text-gray-900">{{ $order->o_address }}</span>
                </div>
                <div class="mb-4">
                    <span class="font-semibold text-gray-700">Payment Method:</span>
                    <span class="ml-2 text-gray-900">{{ $order->o_payment_method }}</span>
                </div>
                <div class="mb-6">
                    <span class="font-semibold text-gray-700">Products:</span>
                    <table class="min-w-full mt-2 border border-gray-200 rounded">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Product</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Quantity</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Price</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($order->orderItems as $item)
                                @php $subtotal = $item->price * $item->quantity; $total += $subtotal; @endphp
                                <tr>
                                    <td class="px-4 py-2 text-gray-800">{{ $item->product_name }}</td>
                                    <td class="px-4 py-2 text-gray-800">{{ $item->quantity }}</td>
                                    <td class="px-4 py-2 text-gray-800">₹{{ number_format($item->price, 2) }}</td>
                                    <td class="px-4 py-2 text-gray-800">₹{{ number_format($subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-50">
                                <td colspan="3" class="px-4 py-2 text-right font-semibold text-gray-700">Total:</td>
                                <td class="px-4 py-2 text-gray-900 font-bold">₹{{ number_format($total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function closeModal() {
        window.location.href = "{{ url('admin_orders') }}";
    }
</script>
@endsection