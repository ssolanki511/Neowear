@extends('amaster')
@section('main_content')
<div class="p-4">
    <div class="rounded-lg pb-4">
        <div class="container-fluid p-0 z-50 flex flex-wrap justify-center w-full h-auto">
            @if (session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="w-full flex flex-col lg:flex-row justify-between p-2 border-b-2 border-gray-200 gap-4">
                <div class="text-3xl text-start font-medium mt-1">
                    <span>Products</span>
                </div>
                <div class="mx-3">
                    <form action="#" class="flex flex-wrap gap-3">
                        <div class="w-full sm:w-auto">
                            <div class="relative">
                                <select id="category" name="options" class="bg-white placeholder:text-slate-400 text-gray-500 text-sm border border-slate-500 rounded h-10 pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 appearance-none cursor-pointer w-full sm:w-auto">
                                    <option value="">Select Category</option>
                                    <?php
                                    use App\Models\Category;
                                     $categories = Category::all(); ?>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->c_name }}" {{ old('options') == $category->c_name ? 'selected' : '' }}>
                                            {{ $category->c_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="w-full sm:w-auto">
                            <div class="w-full max-w-sm relative">
                                <div class="relative">
                                    <input
                                        class="bg-white w-full sm:w-auto pr-11 h-10 pl-3 py-2 placeholder:text-slate-400 text-slate-700 text-sm border border-slate-500 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400"
                                        placeholder="Search for product..." />
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
                <button onclick="openModal()" type="button"
                    class="rounded border border-blue-600 px-3 h-10 text-center text-sm font-semibold text-blue-600 transition-all hover:bg-blue-600 hover:text-white hover:shadow-md hover:shadow-blue-600/20 active:bg-blue-700 active:text-white active:opacity-[0.85] w-full lg:w-auto">
                    Add New Product
                </button>

            </div>

            <div
                class="relative flex flex-col px-1 w-full h-full overflow-auto text-gray-700 bg-white border-x-3 border-dashed border-neutral-100 bg-clip-border">
                <table class="w-full text-left table-auto min-w-max">
                    <thead>
                        <tr class="border-b border-slate-300">
                            <th class="p-4 text-sm font-normal leading-none text-slate-500">Product</th>
                            <th class="p-4 text-sm font-normal leading-none text-slate-500">Name</th>
                            <th class="p-4 text-sm font-normal leading-none text-slate-500">Category</th>
                            <th class="p-4 text-sm font-normal leading-none text-slate-500">Price</th>
                            <th class="p-4 text-sm font-normal leading-none text-slate-500">Offer</th>
                            <th class="p-4 text-sm font-normal leading-none text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                                              <tr class="hover:bg-slate-50">
                            <td class="p-4 border-b border-slate-500 py-5">
                                <img src="{{ asset('images/product_images/'.$product->p_image) }}"
                                    alt="Product 1" class="w-16 h-16 object-cover rounded" />
                            </td>
                            <td class="p-4 border-b border-slate-500 py-5">
                                <p class="block font-semibold text-sm text-slate-800">{{ $product->p_name }}</p>
                            </td>
                            <td class="p-4 border-b border-slate-500 py-5">
                                <p class="text-sm text-slate-500">{{ $product->p_category }}</p>
                            </td>
                            <td class="p-4 border-b border-slate-500 py-5">
                                <p class="text-sm text-slate-500">{{ $product->p_price }}</p>
                            </td>
                            <td class="p-4 border-b border-slate-500 py-5">
                                <p class="text-sm text-slate-500">{{ $product->p_offer   }}</p>
                            </td>
                            <td class="p-4 border-b border-slate-500 py-5">
                                <a href="{{ url('view_product/'.$product->id)}}"
                                    class="font-medium text-blue-600 hover:underline cursor-pointer">View</a>
                                <a href="{{ url('edit_product/'.$product->id) }}"
                                    class="font-medium text-green-600 hover:underline cursor-pointer ms-3">Edit</a>
                                <form action="{{ route('delete_product', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="font-medium text-red-600 hover:underline cursor-pointer ms-3 bg-transparent border-none p-0">Remove</button>
                                </form>
                            </td>
                        </tr>      
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<script>
    function openModal() {
        window.location.href = "{{ url('add_product') }}";
    }
</script>
@endsection