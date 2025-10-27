@extends('amaster')
@section('main_content')
    <div tabindex="-1"
        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full backdrop-blur-sm bg-gray-900/30">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm border-2 border-gray-200">
                <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Change Password
                    </h3>
                    <button onclick="window.location.href = '{{ route('profile') }}'" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="{{ route('change_password') }}" method="post" class="p-4 md:p-5">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-1">
                        <div>
                            <label for="old_password" class="block mb-2 text-sm font-medium text-gray-900">Old Password</label>
                            <input type="password" name="old_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Old Password">
                            @error('old_password')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                            @if (session('error'))
                                <span class="text-red-500">{{ session('error') }}</span>
                            @endif
                        </div>
                        <div>
                            <label for="new_password" class="block mb-2 text-sm font-medium text-gray-900">New Password</label>
                            <input type="password" name="new_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="New Password">
                            @error('new_password')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900">Confirm New Password</label>
                            <input type="password" name="confirm_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Confirm New Password">
                            @error('confirm_password')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Change Password
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection 