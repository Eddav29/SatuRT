<x-app-layout>

    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <section class="bg-white mx-14 my-10 p-6">
        <form action="{{ route('family-card.store')}}" method="POST">
            @csrf
            <div class="space-y-6">
                @include('pages.data-keluarga.tambah.partials.data-keluarga-form')
                @include('pages.data-keluarga.tambah.partials.data-kepala-keluarga-form')
            </div>

            <div class="flex justify-start mt-8 space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Simpan</button>
                <button type="submit" class="bg-white text-black border border-gray-300 px-4 py-2 rounded-md">Simpan dan Tambah Lagi</button>
                <button type="submit" class="bg-white text-black border border-gray-300 px-4 py-2 rounded-md">Kembali</button>
            </div>
        </form>
    </section>

</x-app-layout>
