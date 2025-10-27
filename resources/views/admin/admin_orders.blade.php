@extends('amaster')
@section('main_content')
    <div class="p-4">
        <div class="rounded-lg pb-4">
            <div class="container-fluid p-0 z-50 flex flex-wrap justify-center w-full h-auto">
                @if (session('success'))
                    <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
                @endif
                <div class="w-full flex flex-col lg:flex-row justify-between p-2 border-b-2 border-gray-200 gap-4">
                    <div class="text-3xl text-start font-medium mt-1">
                        <span>Orders</span>
                    </div>
                    <div class="mx-3">
                        <form action="#"
                            class="flex flex-col sm:flex-row items-start sm:items-center p-1 rounded-lg gap-3 w-full lg:w-auto">
                            <div class="w-full sm:w-auto">
                                <div class="relative">
                                    <select
                                        class="bg-white placeholder:text-slate-400 text-gray-500 text-sm border border-slate-500 rounded h-10 pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer w-full sm:w-auto">
                                        <option value="all">All Orders</option>
                                        <option value="pending">Pending</option>
                                        <option value="processing">Processing</option>
                                        {{-- <option value="shipped">Shipped</option> --}}
                                        {{-- <option value="delivered">Delivered</option> --}}
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="w-full sm:w-auto sm:mx-3">
                                <div class="w-full max-w-sm min-w-[200px] relative">
                                    <div class="relative">
                                        <input
                                            class="bg-white w-full pr-11 h-10 pl-3 py-2 placeholder:text-slate-400 text-slate-700 text-sm border border-slate-500 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
                                            placeholder="Search for orders..." />
                                        <button
                                            class="absolute h-8 w-8 right-1 top-1 my-auto px-2 flex items-center bg-white rounded "
                                            type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="3" stroke="currentColor" class="w-8 h-8 text-slate-600">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full sm:w-auto">
                                <button id="apply" type="submit"
                                    class="rounded border border-blue-600 py-2 px-3 text-center text-sm font-semibold text-blue-600 transition-all hover:bg-blue-600 hover:text-white hover:shadow-md hover:shadow-blue-600/20 active:bg-blue-700 active:text-white active:opacity-[0.85] w-full sm:w-auto">Apply</button>
                            </div>
                        </form>
                    </div>
                    {{-- <button onclick="window.location.href='{{ url('add_order') }}'" type="button"
                        class="rounded border border-blue-600 px-3 mt-1 h-10 text-center text-sm font-semibold text-blue-600 transition-all hover:bg-blue-600 hover:text-white hover:shadow-md hover:shadow-blue-600/20 active:bg-blue-700 active:text-white active:opacity-[0.85] w-full lg:w-auto">
                        <span>Add New Order</span>
                    </button> --}}
                </div>

                <div
                    class="relative flex flex-col px-1 w-full h-full overflow-auto text-gray-700 bg-white border-x-3 border-dashed border-neutral-100 bg-clip-border">
                    <table class="w-full text-left table-auto min-w-max">
                        <thead>
                            <tr class="border-b border-slate-300">
                                <th class="p-4 text-sm font-normal leading-none text-slate-500">Order ID</th>
                                <th class="p-4 text-sm font-normal leading-none text-slate-500">Customer</th>
                                <th class="p-4 text-sm font-normal leading-none text-slate-500">Products</th>
                                <th class="p-4 text-sm font-normal leading-none text-slate-500">Total Amount</th>
                                <th class="p-4 text-sm font-normal leading-none text-slate-500">Status</th>
                                <th class="p-4 text-sm font-normal leading-none text-slate-500">Payment</th>
                                <th class="p-4 text-sm font-normal leading-none text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr class="hover:bg-slate-50">
                                <td class="p-4 border-b border-slate-500 py-5">
                                    <p class="block font-semibold text-sm text-slate-800">{{ $order->o_id }}</p>
                                </td>
                                <td class="p-4 border-b border-slate-500 py-5">
                                    <div class="flex items-center">
                                        <img src="{{ $order->user && $order->user->profile_image ? asset('images/users/' . $order->user->profile_image) : asset('images/users/main_user_image.webp') }}"
                                            alt="Customer" class="w-8 h-8 object-cover rounded-full mr-3" />
                                        <div>
                                            <p class="text-sm font-medium text-slate-800">{{ $order->u_name }}</p>
                                            <p class="text-xs text-slate-500">{{ $order->user ? $order->user->email : '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 border-b border-slate-500 py-5">
                                    <p class="text-sm text-slate-500">
                                        @foreach($order->orderItems as $item)
                                            {{ $item->product_name }}@if(!$loop->last), @endif
                                        @endforeach
                                    </p>
                                </td>
                                <td class="p-4 border-b border-slate-500 py-5">
                                    <p class="text-sm font-medium text-slate-800">₹{{ number_format($order->total_amount, 2) }}</p>
                                </td>
                                <td class="p-4 border-b border-slate-500 py-5">
                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">{{ $order->o_status }}</span>
                                </td>
                                <td class="p-4 border-b border-slate-500 py-5">
                                    <span class="text-xs">{{ $order->o_payment_method }}</span>
                                </td>
                                <td class="p-4 border-b border-slate-500 py-5">
                                    <button onclick="window.location.href='{{ url('view_order/'.$order->id) }}'"
                                        class="font-medium text-blue-600 hover:underline cursor-pointer">View</button>
                                    <button onclick="window.location.href='{{ url('edit_order/'.$order->id) }}'"
                                        class="font-medium text-green-600 hover:underline cursor-pointer ms-3">Edit</button>
                                    <button
                                        class="font-medium text-red-600 hover:underline cursor-pointer ms-3">Remove</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection