@extends('amaster')
@section('main_content')
    <div tabindex="-1"
        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full backdrop-blur-sm bg-gray-900/30">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm border-2 border-gray-200">
                <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Inquiry Details
                    </h3>
                    <button onclick="closeModal()" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5">
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Inquiry ID:</span>
                        <span class="ml-2 text-gray-900">{{ $u_msg->id }}</span>
                    </div>
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Customer:</span>
                        @php
                            use App\Models\User;
                            $user = User::where('email', $u_msg->u_email)->first();
                            $u_name = $user ? $user->username : 'Unknown User';
                        @endphp
                        <span class="ml-2 text-gray-900">{{ $u_name }} ({{ $u_msg->u_email }})</span>
                    </div>
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Status:</span>
                        <span class="ml-2 text-gray-900">{{ $u_msg->status }}</span>
                    </div>
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Message:</span>
                        <span class="ml-2 text-gray-900">{{ $u_msg->u_message }}</span>
                    </div>
                    @php
                        $date = explode(' ', (string) $u_msg->created_at, 2);
                    @endphp
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Date:</span>
                        <span class="ml-2 text-gray-900">{{ $date[0] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function closeModal() {
            window.location.href = "{{ url('admin_inquires') }}";
        }
    </script>
@endsection
