<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>
    <section class="mx-6 md:mx-14 my-4">
        <div class="bg-white">
            <div class=" p-6 space-x-4">
                <div>
                    <x-heading text="Data Kepala Keluarga" />
                    @include('pages.data-penduduk.anggota.detail.partials.data-anggota-keluarga-detail')
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
