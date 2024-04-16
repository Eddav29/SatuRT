@props(['href', 'id'])

@php
    $currentRoute = request()->route()->getName();
@endphp

<section>
    <div class="grid grid-rows-1 grid-cols-3 w-fit bg-white p-3 rounded-lg">
        <div>
            <a href="{{ url($href) }}/{{ $id }}" class="">
                <div
                    class="flex gap-2 justify-center items-center {{ $currentRoute == 'informasi.show' ? 'bg-azure-blue/10' : '' }} p-3 rounded-md text-azure-blue">
                    <x-heroicon-o-eye class="w-5 h-5" />
                    <p>Detail</p>
                </div>
            </a>
        </div>
        <div>
            <a href="{{ url($href) }}/{{ $id }}/edit" class="">
                <div
                    class="flex gap-2 justify-center items-center {{ $currentRoute == 'informasi.edit' ? 'bg-green-500/10' : '' }} p-3 rounded-md text-green-500">
                    <x-heroicon-o-eye class="w-5 h-5" />
                    <p>Edit</p>
                </div>
            </a>
        </div>
        <div>
            <form action="{{ url($href) }}/{{ $id }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">
                    <div
                        class="flex gap-2 justify-center items-center {{ $currentRoute == 'informasi.destroy' ? 'bg-red-500/10' : '' }} p-3 rounded-md text-red-500">
                        <x-heroicon-o-eye class="w-5 h-5" />
                        <p>Delete</p>
                    </div>
                </button>
            </form>
        </div>
    </div>
</section>
