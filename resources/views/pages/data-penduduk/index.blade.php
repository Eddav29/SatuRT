<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 rounded-xl bg-white-snow overflow-hidden">
            <section>
                <x-datatables id="kartu_keluarga_id" url="/data-penduduk/keluarga" :columns="[
                    [
                        'label' => 'No. Kartu Keluarga',
                        'key' => 'nomor_kartu_keluarga',
                        'style' => 'text-left'
                    ],
                    // [
                    //     'label' => 'NIK Kepala Keluarga',
                    //     'key' => 'nik',
                    //     'style' => 'text-left'
                    // ],
                    [
                        'label' => 'Nama Kepala Keluarga',
                        'key' => 'nama',
                        'style' => 'text-left'
                    ],
                    [
                        'label' => 'Jumlah Anggota',
                        'key' => 'penduduk_count',
                        'style' => 'text-center'
                    ],
                ]" :aksi="[
                    'detail' => true,
                    'edit' => true,
                    'hapus' => true,
                ]">
                </x-datatables>
            </section>
        </div>
    </div>
</x-app-layout>
