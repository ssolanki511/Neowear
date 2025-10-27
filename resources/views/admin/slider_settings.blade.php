@extends('amaster')

@section('main_content')
    <div class="p-4">
        <div class="rounded-lg pb-4">
            <div class="container-fluid p-0 z-50 flex flex-wrap justify-center w-full h-auto">
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
                <div class="w-full flex flex-col lg:flex-row justify-between p-2 border-b-2 border-gray-200 gap-4">
                    <div class="text-3xl text-start font-medium mt-1">
                        <span>Sliders</span>
                    </div>
                    <div class="mx-3">
                        <button onclick="window.location.href='{{ url('add_slider') }}'" type="button"
                            class="rounded border border-blue-600 py-2 px-3 text-center text-sm font-semibold text-blue-600 transition-all hover:bg-blue-600 hover:text-white hover:shadow-md hover:shadow-blue-600/20 active:bg-blue-700 active:text-white active:opacity-[0.85] w-full sm:w-auto mt-6 sm:mt-0">
                            Add Slider
                        </button>
                    </div>
                </div>
                <div class="w-full mt-6">
                    <div
                        class="relative flex flex-col px-1 w-full h-full overflow-auto text-gray-700 bg-white border-x-3 border-dashed border-neutral-100 bg-clip-border">
                        <table class="w-full text-left table-auto min-w-max">
                            <thead>
                                <tr class="border-b border-slate-300">
                                    <th class="p-4 text-sm font-normal leading-none text-slate-500">Image</th>
                                    <th class="p-4 text-sm font-normal leading-none text-slate-500">Title</th>
                                    <th class="p-4 text-sm font-normal leading-none text-slate-500">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sliders as $slider)
                                <tr class="hover:bg-slate-50 border-b border-slate-500">
                                    <td class="p-2 py-2">
                                        <img src="{{ asset('images/slider_images/' . $slider->s_image) }}"
                                            alt="Slider Image" class="w-16 h-16 object-cover rounded" />
                                    </td>
                                    <td class="p-4 py-5">
                                        <span class="font-semibold text-sm text-slate-800">{{ $slider->s_title }}</span>
                                    </td>
                                    <td class="p-4 py-5">
                                        <button onclick="window.location.href='{{ url('edit_slider/' . $slider->id) }}'" type="button"
                                            class="font-medium text-green-600 hover:underline cursor-pointer">Update</button>
                                        <form action="{{ url('admin/sliders/' . $slider->id . '/delete') }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this slider?')"
                                                class="font-medium text-red-600 hover:underline cursor-pointer ms-3">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-gray-500">No sliders found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




