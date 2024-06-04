<x-app-layout>

    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>
    <section class="bg-white p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10">
        <form action="{{ route('data-anggota.store', [
            'keluargaid' => $id,
        ]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <div>
                    <x-heading text="Tambah Data Anggota Keluarga" />
                    @include('pages.data-penduduk.partials.data-anggota-keluarga-form')
                </div>
            </div>

            <div class="flex justify-start gap-3 px-5 flex-wrap mt-5">
                <button type="submit" class="bg-blue-500 px-4 py-3 text-white rounded-md text-sm">Simpan</button>
                <button type="submit" name="save_and_more"
                    class="bg-white px-4 py-3 text-black border border-gray-300 rounded-md text-wrap text-sm">Simpan &
                    Tambah Lagi</button>
                <a href="{{ route('data-keluarga.index') }}" draggable="false"
                    class="select-none bg-white text-black border  border-gray-300 px-4 py-3 rounded-md text-sm inline-flex justify-center items-center">Kembali</a>
            </div>
        </form>
    </section>

</x-app-layout>
