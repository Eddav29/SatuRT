<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <section class="bg-white mx-14 my-10 px-6 py-4">
        <x-datatables url="data-keluarga" :columns="[
            ['label' => 'No. Kartu Keluarga', 'key' => 'nomor_kartu_keluarga'],
            ['label' => 'NIK Kepala Keluarga', 'key' => 'penduduk[0].nik'],
            ['label' => 'Nama Kepala Keluarga', 'key' => 'penduduk[0].nama'],
            ['label' => 'Jumlah Anggota', 'key' => 'penduduk_count'],
        ]">
        </x-datatables>
    </section>

</x-app-layout>
