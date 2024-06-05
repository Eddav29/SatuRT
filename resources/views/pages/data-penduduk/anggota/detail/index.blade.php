<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <section class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <div>
            <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />
        </div>
        <div class="p-6 rounded-xl bg-white-snow mt-5 flex flex-col gap-y-7">
            <div class="space-x-4">
                <div>
                    <x-heading text="Data Anggota Keluarga" />
                    @include('pages.data-penduduk.anggota.detail.partials.data-anggota-keluarga-detail')
                </div>
                {{-- Back Button --}}
                <div class="mt-10">
                    <a href="{{ route('data-keluarga.show', [
                        'keluarga' => $toolbar_id,
                    ]) }}"
                        draggable="false"
                        class="select-none bg-white text-black border border-gray-300 px-4 py-2 rounded-md text-sm">Kembali</a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
