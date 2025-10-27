@extends('amaster')
@section('main_content')
    <div tabindex="-1"
        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full backdrop-blur-sm bg-gray-900/30">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm border-2 border-gray-200">
                <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Edit Order
                    </h3>
                    <button onclick="window.location.href = '{{ route('orders') }}'" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="{{ route('edit_order') }}" method="post" class="p-4 md:p-5">
                    @csrf
                    <input type="hidden" name="id" value="{{ $order->id }}">
                    <div class="grid gap-4 mb-4 grid-cols-1 md:grid-cols-2">
                        <div>
                            <label for="order_id" class="block mb-2 text-sm font-medium text-gray-900">Order ID</label>
                            <input type="text" name="order_id" value="{{ old('order_id', $order->o_id) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                placeholder="Order ID">
                            @error('order_id')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="user" class="block mb-2 text-sm font-medium text-gray-900">User</label>
                            <input type="text" name="user" value="{{ old('user', $order->u_name) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                placeholder="User">
                            @error('user')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="address" class="block mb-2 text-sm font-medium text-gray-900">Address</label>
                            <input type="text" name="address" value="{{ old('address', $order->o_address) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                placeholder="Address">
                            @error('address')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $order->o_phone_number) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                placeholder="Phone">
                            @error('phone')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="payment_method" class="block mb-2 text-sm font-medium text-gray-900">Payment Method</label>
                            <input type="text" name="payment_method" value="{{ old('payment_method', $order->o_payment_method) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                placeholder="Payment Method">
                            @error('payment_method')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="total_amount" class="block mb-2 text-sm font-medium text-gray-900">Total Amount</label>
                            <input type="number" name="total_amount" value="{{ old('total_amount', $order->total_amount) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                placeholder="Total Amount">
                            @error('total_amount')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                            <select name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full py-2.5 text-start px-2">
                                <option value="Pending" {{ old('status', $order->o_status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Processing" {{ old('status', $order->o_status) == 'Processing' ? 'selected' : '' }}>Processing</option>
                                <option value="Completed" {{ old('status', $order->o_status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Cancelled" {{ old('status', $order->o_status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Products</label>
                        <ul class="list-disc ml-5">
                            @foreach($order->orderItems as $item)
                                <li>{{ $item->product_name }} (Qty: {{ $item->quantity }}, ₹{{ $item->price }})</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Edit Order
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection