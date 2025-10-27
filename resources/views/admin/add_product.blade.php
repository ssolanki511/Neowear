@extends('amaster')
@section('main_content')
    <div class="container mx-auto p-4 max-w-2xl">
        <div id="add_product-modal" tabindex="-1"
            class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full backdrop-blur-sm bg-gray-900/30 transition-opacity duration-300 opacity-0 pointer-events-none">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm border-2 border-gray-200">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Add New Product
                        </h3>
                        <button onclick="close_add_product_modal()" id="close-add-product-modal" type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form action="{{ route('add_product') }}" method="post" id="add_product_form"
                        enctype="multipart/form-data" class="product-form p-4 md:p-5">
                        @csrf
                        <div class="grid gap-4 mb-4 grid-cols-1 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                                <input type="text" name="pn" value="{{ old('pn') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                    placeholder="Enter Name">
                                @error('pn')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div>
                                <label for="pqty" class="block mb-2 text-sm font-medium text-gray-900">Sizes</label>
                                <input type="text" name="sizes[name][]"
                                    placeholder="Size (e.g., S, M, XL), Respected to Quantity."
                                    value="{{ old('sizes[name][]') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                @error('pqty')
                                <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="pqty" class="block mb-2 text-sm font-medium text-gray-900">
                                    Quantities</label>
                                <input type="text" name="sizes[quantity][]"
                                    placeholder="Quantities (e.g., 5, 10, 15), Respected to Sizes." min="0"
                                    value="{{ old('sizes[quantity][]') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                @error('pqty')
                                <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="md:col-span-2">
                                <label class="block mb-2 text-sm font-medium text-gray-900">
                                    <h3>Enter Quantity for Each Size</h3>
                                    <p>(Leave a field blank if that size is not available)</p>
                                </label>
                                <div class="flex">
                                <div class="w-1/4">
                                    <label class="block mb-1.5 text-sm font-medium text-gray-900" for="size-s">Size S:</label>
                                    <input class="w-3/4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2" type="number" id="size-s" name="sizes[S]" min="0" placeholder="e.g., 10">
                                    @error('sizes.S') <span style="color:red">{{ $message }}</span> @enderror
                                </div>
                                <div class="w-1/4">
                                    <label class="block mb-1.5 text-sm font-medium text-gray-900" for="size-m">Size M:</label>
                                    <input class="w-3/4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2" type="number" id="size-m" name="sizes[M]" min="0" placeholder="e.g., 25">
                                    @error('sizes.M') <span style="color:red">{{ $message }}</span> @enderror
                                </div>
                                <div class="w-1/4">
                                    <label class="block mb-1.5 text-sm font-medium text-gray-900" for="size-l">Size L:</label>
                                    <input class="w-3/4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2" type="number" id="size-l" name="sizes[L]" min="0" placeholder="e.g., 20">
                                    @error('sizes.L') <span style="color:red">{{ $message }}</span> @enderror
                                </div>
                                <div class="w-1/4">
                                    <label class="block mb-1.5 text-sm font-medium text-gray-900" for="size-xl">Size XL:</label>
                                    <input class="w-3/4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2" type="number" id="size-xl" name="sizes[XL]" min="0" placeholder="e.g., 12">
                                    @error('sizes.XL') <span style="color:red">{{ $message }}</span> @enderror
                                </div>
                                </div>
                            </div>
                            <div>
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Price</label>
                                <input type="number" name="price" value="{{ old('price') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                    placeholder="₹">
                                @error('price')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="p_offer" class="block mb-2 text-sm font-medium text-gray-900">Offer</label>
                                <input type="number" name="p_offer" value="{{ old('p_offer') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                    placeholder="Offer">
                                @error('p_offer')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="category"
                                    class="block mb-2 text-sm font-medium text-gray-900">Category</label>
                                <select id="category" name="options" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full py-2.5 text-start px-2">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->c_name }}" {{ old('options') == $category->c_name ? 'selected' : '' }}>
                                            {{ $category->c_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('options')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="img_file" class="block mb-2 text-sm font-medium text-gray-900">Image</label>
                                <input
                                    class="block w-full px-2 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer py-2.5 bg-gray-50"
                                    id="img_file" name="img_file" type="file" value="{{ old('img_file') }}">
                                @error('img_file')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="other_images" class="block mb-2 text-sm font-medium text-gray-900">Other
                                    Images</label>
                                <input
                                    class="block w-full px-2 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer py-2.5 bg-gray-50"
                                    id="other_images" name="other_images[]" type="file" multiple accept="image/*">
                                @error('other_images')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="product_dis" class="block mb-2 text-sm font-medium text-gray-900">Product
                                    Description</label>
                                <textarea id="product_dis" name="product_dis" value="{{ old('product_dis') }}" rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300"
                                    placeholder="Write product description here"></textarea>
                                @error('product_dis')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Add new product
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <script>
            function close_add_product_modal() {
                // Animate fade out
                const modal = document.getElementById('add_product-modal');
                modal.classList.remove('opacity-100');
                modal.classList.add('opacity-0');
                setTimeout(() => {
                    window.location.href = "{{ route('products') }}";
                }, 300);
            }
            // Animate fade in on page load
            window.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('add_product-modal');
                modal.classList.remove('pointer-events-none');
                modal.classList.add('opacity-100');
                modal.classList.remove('opacity-0');
            });
        </script>
    </div>
@endsection