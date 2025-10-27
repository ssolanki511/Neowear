@extends('amaster')

@section('main_content')
    <div class="p-6 bg-white shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add New Slider</h2>
        <form action="{{ url('/add_slider') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Slider Title</label>
                <input type="text" name="title" id="title" placeholder="Enter slider title" value="{{ old('title') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('title')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
            </div>
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Slider Image</label>
                <input type="file" name="image" id="image"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('image')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
            </div>
            <button type="submit"
                class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Add Slider
            </button>
        </form>
    </div>
@endsection
