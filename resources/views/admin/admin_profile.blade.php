@extends('amaster')
@section('main_content')
    <div class="p-4">
        <div class="rounded-lg pb-4">
            <div class="container-fluid p-0 z-50 flex flex-wrap justify-center w-full h-auto">
                @if (session('success'))
                    <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
                @endif
                @if (session('success'))
                    <div class="bg-green-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
                @endif
                <div class="w-full flex flex-col lg:flex-row justify-between p-2 border-b-2 border-gray-200 gap-4">
                    <div class="text-3xl text-start font-medium mt-1">
                        <span>Admin Profile</span>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="window.location.href='{{ url('edit_profile') }}'" type="button"
                            class="text-blue-600 font-semibold text-sm h-10 mt-1 px-3 bg-transparent border-none hover:underline focus:outline-none transition-all w-full lg:w-auto">
                            <span>Edit Profile</span>
                        </button>
                        <button onclick="window.location.href='{{ url('change_password') }}'" type="button"
                            class="text-yellow-600 font-semibold text-sm h-10 mt-1 px-3 bg-transparent border-none hover:underline focus:outline-none transition-all w-full lg:w-auto">
                            <span>Change Password</span>
                        </button>
                        <form action="{{ route('logout') }}" method="Get" class="inline">
                            @csrf
                            <button type="submit"
                                class="text-red-600 font-semibold text-sm h-10 mt-1 px-3 bg-transparent border-none hover:underline focus:outline-none transition-all w-full lg:w-auto cursor-pointer">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>

                <div class="w-full mt-6">
                    <!-- Vertical Profile Card -->
                    <div class="bg-white rounded-lg shadow-sm border-2 border-gray-200 p-6 max-w-2xl mx-auto">
                        <!-- Profile Image Section -->
                        <div class="text-start mb-6 flex justify-around">
                            <div class="relative inline-block">
                                <img src="{{ $u->profile_image ? asset('images/users/' . $u->profile_image) : asset('images/users/main_user_image.webp') }}"
                                    alt="Admin Profile"
                                    class="w-32 h-32 object-cover rounded-full border-4 border-gray-200 shadow-lg" />
                            </div>
                            <div class="flex flex-col">
                                <h2 class="text-2xl font-bold text-gray-900 mt-4"> {{ $u->username }} </h2>
                                <p class="text-gray-600">Administrator</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $u->email }}</p>
                            </div>
                        </div>

                        <!-- Profile Details Section -->
                        <div class="border-t border-gray-200 pt-6">
                            {{-- <h3 class="text-lg font-semibold text-gray-900 mb-6">Profile Information</h3> --}}

                            <div class="space-y-4">
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-3 border-b border-gray-100">
                                    <label class="block text-sm font-medium text-gray-700 mb-1 sm:mb-0">Username</label>
                                    <p class="text-gray-900 font-medium"> {{ $u->username }}</p>
                                </div>
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-3 border-b border-gray-100">
                                    <label class="block text-sm font-medium text-gray-700 mb-1 sm:mb-0">Email
                                        Address</label>
                                    <p class="text-gray-900 font-medium"> {{ $u->email }}</p>
                                </div>
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-3 border-b border-gray-100">
                                    <label class="block text-sm font-medium text-gray-700 mb-1 sm:mb-0">Role</label>
                                    <p class="text-gray-900 font-medium"> {{ $u->role }}</p>
                                </div>
                                {{-- <div
                                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-3 border-b border-gray-100">
                                    <label class="block text-sm font-medium text-gray-700 mb-1 sm:mb-0">Status</label>
                                    <span
                                        class="px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full"> {{ $u->status }}</span>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
