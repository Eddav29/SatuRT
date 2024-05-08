<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 rounded-xl bg-white-snow overflow-hidden">

            {{-- Table --}}
            <section>
                <x-datatables id="inventaris_id" url="/inventaris" :columns="[
                    [
                        'label' => 'ID Inventaris',
                        'key' => 'inventaris_id',
                        'style' => 'text-left',
                    ],
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
                        'label' => 'Kondisi',
                        'key' => 'kondisi',
                        'style' => 'text-left',
                        'customStyle' => [
                            'Cukup' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-yellow-500/30 text-yellow-800',
                            'Baik' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-blue-500/30 text-blue-800',
                            'Baru' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-green-500/30 text-green-800',
                            'Cacat' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-orange-500/30 text-orange-800',
                            'Rusak' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-red-500/30 text-red-800',
                        ],
                    ],
                ]" :aksi="[
                    'detail' => true,
                    'edit' => true,
                    'hapus' => true,
                ]" :filter="[
                    ['label' => 'Cukup', 'key' => 'Cukup', 'columnIndex' => 3],
                    ['label' => 'Baik', 'key' => 'Baik', 'columnIndex' => 3],
                    ['label' => 'Baru', 'key' => 'Baru', 'columnIndex' => 3],
                    ['label' => 'Cacat', 'key' => 'Cacat', 'columnIndex' => 3],
                    ['label' => 'Rusak', 'key' => 'Rusak', 'columnIndex' => 3],
                ]"
                    :layoutTopEnd="true">
                </x-datatables>
            </section>
            {{-- End Table --}}
        </div>
    </div>
</x-app-layout>
