@extends('amaster')
@section('main_content')
    <div tabindex="-1"
        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full backdrop-blur-sm bg-gray-900/30">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm border-2 border-gray-200">
                <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Reply to Inquiry
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
                    @php
                        use App\Models\User;
                        $user = User::where('email', $u_msg->u_email)->first();
                        $u_name = $user ? $user->username : 'Unknown User';
                    @endphp
                    <div class="mb-4">
                        <span class="font-semibold text-gray-700">Customer:</span>
                        <span class="ml-2 text-gray-900">{{$u_name}} ({{ $u_msg->u_email }})</span>
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
                    <form action="{{ route('reply_inquiry') }}" method="post" class="mt-6">
                        @csrf
                        <div class="mb-4">
                            <label for="user_email" class="block mb-2 text-sm font-medium text-gray-900">User Email</label>
                            <input type="email" id="user_email" name="user_email" value="{{ $u_msg->u_email }}" readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" />
                        </div>
                        <div class="mb-4">
                            <label for="reply" class="block mb-2 text-sm font-medium text-gray-900">Your Reply</label>
                            <textarea id="reply" name="reply" rows="4"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                placeholder="Type your reply here..."></textarea>
                            @error('reply')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Send Reply
                        </button>
                    </form>
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
