<x-app-layout>

    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>


    <section class="bg-white mx-6 md:mx-14 my-10 p-6">
        <form action="{{ route('data-keluarga.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <div>
                    <x-heading text="Data Keluarga" />
                    @include('pages.data-penduduk.partials.data-keluarga-form')
                </div>
                <div>
                    <x-heading text="Data Kepala Keluarga" />
                    @include('pages.data-penduduk.partials.data-anggota-keluarga-form')
                </div>
            </div>

            <div class="flex justify-start mt-8 space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Simpan</button>
                <button type="submit" name="save_and_more" class="bg-white text-black border border-gray-300 px-4 py-2 rounded-md">Simpan dan Tambah Lagi</button>
                <a href="{{route('data-keluarga.index')}}" draggable="false" class="select-none bg-white text-black border border-gray-300 px-4 py-2 rounded-md">Kembali</a>
            </div>
        </form>
    </section>

</x-app-layout>
