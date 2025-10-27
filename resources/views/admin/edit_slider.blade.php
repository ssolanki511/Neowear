@extends('amaster')

@section('main_content')
    <div class="p-6 bg-white shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Slider</h2>
        
        {{-- Success/Error messages --}}
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
        
        <form method="POST" action="{{ url('edit_slider/' . $slider->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Slider Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $slider->s_title) }}" placeholder="Enter slider title"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Slider Image</label>
                <input type="file" name="image" id="image"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('image') border-red-500 @enderror">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Leave empty to keep current image</p>
                <div class="mt-4">
                    <p class="text-sm text-gray-700 mb-2">Current Image:</p>
                    <img src="{{ asset('images/slider_images/' . $slider->s_image) }}" alt="Current Slider Image" class="w-32 h-32 object-cover rounded-md shadow-md">
                </div>
            </div>
            <button type="submit"
                class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Update Slider
            </button>
        </form>
    </div>
@endsection
