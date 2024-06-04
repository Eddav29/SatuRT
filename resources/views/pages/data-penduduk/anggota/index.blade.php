<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>
    <section class="p-6 rounded-xl bg-white-snow mt-5 flex flex-col gap-y-7 max-w-screen-2xl mx-auto">
        <div>
            <x-heading text="Data Kartu Keluarga" />
            @include('pages.data-penduduk.keluarga.detail.partials.data-keluarga-detail')
        </div>
        <div>
            <x-heading text="Data Anggota Keluarga" />
            @include('pages.data-penduduk.keluarga.detail.partials.data-anggota-keluarga')
        </div>
    </section>
</x-app-layout>
