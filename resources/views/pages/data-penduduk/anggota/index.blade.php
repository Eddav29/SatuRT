<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>
    <section class="mx-6 md:mx-14 my-4">
        <div class="bg-white">
            <div class="mt-8 p-6 space-x-4">
            @include('pages.data-penduduk.keluarga.detail.partials.data-keluarga-detail')
            </div>
            <div class="mt-8 p-6 space-x-4">
                @include('pages.data-penduduk.keluarga.detail.partials.data-anggota-keluarga')
            </div>
        </div>
    </section>
</x-app-layout>
