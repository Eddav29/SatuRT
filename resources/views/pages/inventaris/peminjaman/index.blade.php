<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10">
        <div class="p-6 rounded-xl bg-white-snow overflow-hidden">

            {{-- Table --}}
            <section>
                <x-datatables id="id_inventaris_detail" url="/inventaris/peminjaman" :columns="[
                    [
                        'label' => 'ID Peminjaman',
                        'key' => 'inventaris_detail_id',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'ID Inventaris',
                        'key' => 'inventaris_id',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'Nama Penduduk',
                        'key' => 'penduduk_id',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'Jumlah',
                        'key' => 'jumlah',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'Kondisi',
                        'key' => 'kondisi',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'Tanggal Pinjam',
                        'key' => 'tanggal_pinjam',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'Tanggal Kembali',
                        'key' => 'tanggal_kembali',
                        'style' => 'text-left',
                    ],
                ]" :aksi="[
                    'detail' => true,
                    'edit' => true,
                    'hapus' => true,
                ]">
                </x-datatables>
            </section>
            {{-- End Table --}}
        </div>
    </div>
</x-app-layout>
