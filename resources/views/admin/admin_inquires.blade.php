@extends('amaster')
@section('main_content')
    <div class="p-4">
        <div class="rounded-lg pb-4">
            <div class="container-fluid p-0 z-50 flex flex-wrap justify-center w-full h-auto">
                @if (session('success'))
                    <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="bg-green-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
                @endif
                <div class="w-full flex flex-col lg:flex-row justify-between p-2 border-b-2 border-gray-200 gap-4">
                    <div class="text-3xl text-start font-medium mt-1">
                        <span>Customer Inquiries</span>
                    </div>
                    <div class="mx-3">
                        <form action="#" class="flex flex-wrap gap-3">
                            <div class="w-full sm:w-auto">
                                <div class="relative">
                                    <select
                                        class="bg-white placeholder:text-slate-400 text-gray-500 text-sm border border-slate-500 rounded h-10 pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer w-full sm:w-auto">
                                        <option value="all">All Inquiries</option>
                                        <option value="new">New</option>
                                        <option value="closed">Pending</option>
                                        <option value="replied">Replied</option>
                                    </select>
                                </div>
                            </div>
                            <div class="w-full sm:w-auto">
                                <div class="w-full max-w-sm min-w-[200px] relative">
                                    <div class="relative">
                                        <input
                                            class="bg-white w-full pr-11 h-10 pl-3 py-2 placeholder:text-slate-400 text-slate-700 text-sm border border-slate-500 rounded transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
                                            placeholder="Search for inquiries..." />
                                        <button
                                            class="absolute h-8 w-8 right-1 top-1 my-auto px-2 flex items-center bg-white rounded "
                                            type="button">
                                            <i class="ri-search-line w-8 h-8 text-slate-600"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full sm:w-auto">
                                <button id="apply" type="submit"
                                    class="rounded border border-blue-600 py-2 px-3 text-center text-sm font-semibold text-blue-600 transition-all hover:bg-blue-600 hover:text-white hover:shadow-md hover:shadow-blue-600/20 active:bg-blue-700 active:text-white active:opacity-[0.85] w-full sm:w-auto">Apply</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div
                    class="relative flex flex-col px-1 w-full h-full overflow-auto text-gray-700 bg-white border-x-3 border-dashed border-neutral-100 bg-clip-border">
                    <table class="w-full text-left table-auto min-w-max">
                        <thead>
                            <tr class="border-b border-slate-300">
                                {{-- <th class="p-4 text-sm font-normal leading-none text-slate-500">Username</th> --}}
                                <th class="p-4 text-sm font-normal leading-none text-slate-500">Email</th>
                                <th class="p-4 text-sm font-normal leading-none text-slate-500">Message</th>
                                <th class="p-4 text-sm font-normal leading-none text-slate-500">Date</th>
                                <th class="p-4 text-sm font-normal leading-none text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($u_messages) > 0)
                                @foreach ($u_messages as $u_message)
                                    <tr class="hover:bg-slate-50">
                                        {{-- <td class="p-4 border-b border-slate-500 py-5">
                                    <p class="block font-semibold text-sm text-slate-800">John Doe</p>
                                </td> --}}
                                        <td class="p-4 border-b border-slate-500 py-5">
                                            <p class="text-sm text-slate-500">{{ $u_message->u_email }}</p>
                                        </td>
                                        <td class="p-4 border-b border-slate-500 py-5">
                                            <p class="text-sm text-slate-800 max-w-xs truncate">{{ $u_message->u_message }}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-500 py-5">
                                            <p class="text-sm text-slate-500">{{ $u_message->created_at }}</p>
                                        </td>
                                        <td class="p-4 border-b border-slate-500 py-5">
                                            <button
                                                onclick="window.location.href='{{ url('view_inquiry/' . $u_message->id) }}'"
                                                class="font-medium text-blue-600 hover:underline cursor-pointer">View</button>
                                            <button
                                                onclick="window.location.href='{{ url('reply_inquiry/' . $u_message->id) }}'"
                                                class="font-medium text-green-600 hover:underline cursor-pointer ms-3 {{ $u_message->status == 'Replied' ? 'disabled:grayscale-100' : '' }}"
                                                {{ $u_message->status == 'Replied' ? 'disabled' : '' }}>
                                                Reply
                                            </button>

                                            <button
                                                onclick="window.location.href='{{ url('remove_inquiry/' . $u_message->id) }}'"
                                                class="font-medium text-red-600 hover:underline cursor-pointer ms-3">Remove</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
