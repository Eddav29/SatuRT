<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10">
        <div class="p-6 rounded-xl bg-white-snow overflow-hidden">

            {{-- Table --}}
            <section>
                <x-datatables id="inventaris_detail_id" url="/inventaris/peminjaman" :columns="[
                    [
                        'label' => 'Nama Barang',
                        'key' => 'nama_inventaris',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'Nama Penduduk',
                        'key' => 'nama',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'Status',
                        'key' => 'status',
                        'style' => 'text-left',
                        'customStyle' => [
                            'Dipinjam' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-yellow-500/30 text-yellow-800',
                            'Dikembalikan' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-green-500/30 text-green-800',
                        ],
                    ],
                ]" :aksi="[
                    'detail' => true,
                    'edit' => true,
                    'hapus' => true,
                ]"
                    :filter="[
                        [
                            'title' => 'Status',
                            'data' => [
                                ['label' => 'Dipinjam', 'key' => 'Dipinjam', 'columnIndex' => 2],
                                ['label' => 'Dikembalikan', 'key' => 'Dikembalikan', 'columnIndex' => 2],
                            ],
                        ],
                    ]" :layoutTopEnd="true">
                </x-datatables>
            </section>
            {{-- End Table --}}
        </div>
    </div>
</x-app-layout>
