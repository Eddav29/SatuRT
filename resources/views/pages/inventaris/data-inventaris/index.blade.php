<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 rounded-xl bg-white-snow overflow-hidden">

            {{-- Table --}}
            <section>
                <x-datatables id="inventaris_id" url="/inventaris/data-inventaris" :columns="[
                    [
                        'label' => 'Nama',
                        'key' => 'nama_inventaris',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'Jumlah',
                        'key' => 'jumlah',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'Sumber',
                        'key' => 'sumber',
                        'style' => 'text-left',
                        'customStyle' => [
                            'Hibah' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-green-500/30 text-green-800',
                            'Beli' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-blue-700/30 text-blue-800',
                            'Donasi' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-pink-500/30 text-pink-800',
                            'Bantuan' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-purple-500/30 text-purple-800',
                            'Pinjaman' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-orange-500/30 text-orange-800',
                        ],
                    ],
                ]" :aksi="[
                    'detail' => true,
                    'edit' => true,
                    'hapus' => true,
                ]"
                    :filter="[
                        [
                            'title' => 'Sumber',
                            'data' => [
                                ['label' => 'Hibah', 'key' => 'Hibah', 'columnIndex' => 2],
                                ['label' => 'Beli', 'key' => 'Beli', 'columnIndex' => 2],
                                ['label' => 'Donasi', 'key' => 'Donasi', 'columnIndex' => 2],
                                ['label' => 'Bantuan', 'key' => 'Bantuan', 'columnIndex' => 2],
                                ['label' => 'Pinjaman', 'key' => 'Pinjaman', 'columnIndex' => 2],
                            ],
                        ],
                    ]" :layoutTopEnd="true">
                </x-datatables>
            </section>
            {{-- End Table --}}
        </div>
    </div>
</x-app-layout>
