@extends('amaster')

@section('main_content')
    <div class="p-4 bg-white shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">About Settings</h2>

        {{-- Success/Error messages --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
        @endif


        <div class="container-fluid p-0 z-50 flex flex-wrap justify-center w-full h-auto">
            <div class="w-full">
                <form method="POST" action="{{ route('admin.about.update') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900">About Title</label>
                        <input type="text" name="title" id="title" value="{{ $about->title }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900">About
                            Description</label>
                        <textarea name="description" id="description" rows="6"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">{{ $about->description }}</textarea>
                        @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Add 3 link fields --}}
                    @for ($i = 0; $i < 3; $i++)
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900">Link Title {{ $i+1 }}</label>
                            <input type="text" name="links[{{ $i }}][link_name]"
                                value="{{ old('links.'.$i.'.link_name', isset($about_links[$i]) ? $about_links[$i]->link_name : '') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                            @error('links.'.$i.'.link_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900">Link URL {{ $i+1 }}</label>
                            <input type="url" name="links[{{ $i }}][link_url]"
                                value="{{ old('links.'.$i.'.link_url', isset($about_links[$i]) ? $about_links[$i]->link_url : '') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                            @error('links.'.$i.'.link_url')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    @endfor

                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Save About Settings
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
