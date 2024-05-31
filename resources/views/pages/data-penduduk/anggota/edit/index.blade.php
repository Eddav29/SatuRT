<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <section class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <div>
            <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />
        </div>
        <form
            action="{{ route('data-anggota.update', [
                'keluargaid' => $toolbar_id,
                'anggotum' => $id,
            ]) }}"
            method="POST" enctype="multipart/form-data" class="p-6 rounded-xl bg-white-snow mt-5 flex flex-col gap-y-5">
            @csrf
            @method('PATCH')
            <div class="space-y-6">
                <div>
                    <x-heading text="Edit Data Anggota Keluarga" />
                    @include('pages.data-penduduk.partials.data-anggota-keluarga-form')
                </div>
            </div>

            <div class="flex justify-start space-x-4 px-5 mt-5">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md text-sm">Simpan</button>
                <a href="{{ route('data-keluarga.show', [
                    'keluarga' => $toolbar_id,
                ]) }}"
                    draggable="false"
                    class="select-none bg-white text-black border border-gray-300 px-4 py-2 rounded-md text-sm">Kembali</a>
            </div>
        </form>
    </section>
</x-app-layout>
