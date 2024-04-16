<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <section class="bg-white mx-6 md:mx-14 my-10 px-6 py-4">
        <x-datatables
        id="kartu_keluarga_id"
        url="/data-penduduk/keluarga"
        :columns="[
            [
                'label' => 'No. Kartu Keluarga',
                'key' => 'kartu_keluarga.nomor_kartu_keluarga',
                'style' => [
                    'text-align' => 'left',
                ],
            ],
            [
                'label' => 'NIK Kepala Keluarga',
                'key' => 'nik',
                'style' => [
                    'text-align' => 'left',
                ],
            ],
            [
                'label' => 'Nama Kepala Keluarga',
                'key' => 'nama',
                'style' => [
                    'text-align' => 'left',
                ],
            ],
            [
                'label' => 'Jumlah Anggota',
                'key' => 'penduduk_count',
                'style' => [
                    'text-align' => 'center',
                ],
            ],
        ]" :aksi="[
            'detail' => true,
            'edit' => true,
            'hapus' => true,
        ]">
        </x-datatables>
    </section>
</x-app-layout>
