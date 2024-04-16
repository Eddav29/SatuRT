<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>
    <section class="mx-6 md:mx-14 my-4">
        <div>
            <x-toolbar :toolbar_id="$toolbar_id " :active="$active" :toolbar_route="$toolbar_route"/>
        </div>
        <div class="bg-white">
            <div class="mt-8 p-6 space-x-4">
                <div>
                    <x-heading text="Data Kepala Keluarga" />
                    @include('pages.data-penduduk.keluarga.detail.partials.data-keluarga-detail')
                </div>
            </div>
            <div class="mt-8 p-6 space-x-4">
                <div>
                    <x-heading text="Data Anggota Keluarga" />
                    @include('pages.data-penduduk.keluarga.detail.partials.data-anggota-keluarga')
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
