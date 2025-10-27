@extends('amaster')
@section('main_content')
    <div tabindex="-1"
        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full backdrop-blur-sm bg-gray-900/30">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm border-2 border-gray-200">
                <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Add New Category
                    </h3>
                    <button onclick="window.location.href = '{{ route('categories') }}'" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="{{ route('add_category') }}" method="post" enctype="multipart/form-data"
                    class="p-4 md:p-5">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-1 md:grid-cols-2">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Category Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                placeholder="Enter Category Name">
                            @error('name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Category Description</label>
                            <textarea name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300" placeholder="Enter category description">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Add Category
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection 