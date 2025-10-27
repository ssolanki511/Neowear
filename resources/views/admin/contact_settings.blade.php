@extends('amaster')

@section('main_content')
    <div class="p-4 bg-white shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Contact Settings</h2>
        
        {{-- Success/Error messages --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('error') }}</div>
        @endif

        
        <div class="container-fluid p-0 z-50 flex flex-wrap justify-center w-full h-auto">
            <div class="w-full">
                <form method="POST" action="{{ route('admin.contact.update') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Contact Email</label>
                        <input type="email" name="email" id="email" value="{{$contact->email }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="consulting_phone" class="block mb-2 text-sm font-medium text-gray-900">Consulting Phone</label>
                        <input type="text" name="consulting_phone" id="consulting_phone" value="{{ $contact->consulting_phone }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        @error('consulting_phone')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="report_phone" class="block mb-2 text-sm font-medium text-gray-900">Report Phone</label>
                        <input type="text" name="report_phone" id="report_phone" value="{{ $contact->report_phone }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        @error('report_phone')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-900">Address</label>
                        <textarea name="address" id="address" rows="4" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">{{ $contact->address }}</textarea>
                        @error('address')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Save Contact Settings
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection