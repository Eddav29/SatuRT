<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 rounded-xl bg-white-snow overflow-hidden">

            {{-- Table --}}
            <section>
                <x-datatables :layoutTop2Start="Auth::user()->role->role_name == 'Ketua RT' ? true : false" id="umkm_id" url="/umkm" :columns="[
                    [
                        'label' => 'Pemilik',
                        'key' => 'nama',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'Nama Usaha',
                        'key' => 'nama_umkm',
                        'style' => 'text-left truncate max-w-xs',
                    ],
                    [
                        'label' => 'Jenis Usaha',
                        'key' => 'jenis_umkm',
                        'customStyle' => [
                            'Makanan dan Minuman' => 'px-4 py-2 text-center rounded-md bg-orange-100 text-orange-800',
                            'Pakaian' => 'px-4 py-2 text-center rounded-md bg-blue-100 text-blue-800',
                            'Peralatan' => 'px-4 py-2 text-center rounded-md bg-pink-100 text-pink-800',
                            'Jasa' => 'px-4 py-2 text-center rounded-md bg-indigo-300 text-indigo-800',
                            'Lainnya' => 'px-4 py-2 text-center rounded-md bg-gray-200 text-gray-800',
                        ],
                    ],
                    [
                        'label' => 'Status',
                        'key' => 'status',
                        'customStyle' => [
                            'Aktif' => 'px-4 py-2 text-center rounded-md bg-green-100 text-green-800',
                            'Nonaktif' => 'px-4 py-2 text-center rounded-md bg-red-100 text-red-800',
                        ],
                    ],
                ]" :aksi="[
                    'detail' => true,
                    'edit' => true,
                    'hapus' => true,
                ]"
                    :filter="[
                        [
                            'title' => 'Jenis Usaha',
                            'data' => [
                                ['label' => 'Semua', 'key' => '', 'columnIndex' => 2],
                                ['label' => 'Makanan dan Minuman', 'key' => 'Makanan dan Minuman', 'columnIndex' => 2],
                                ['label' => 'Pakaian', 'key' => 'Pakaian', 'columnIndex' => 2],
                                ['label' => 'Peralatan', 'key' => 'Peralatan', 'columnIndex' => 2],
                                ['label' => 'Jasa', 'key' => 'Jasa', 'columnIndex' => 2],
                                ['label' => 'Lainnya', 'key' => 'Lainnya', 'columnIndex' => 2],
                            ],
                        ],  
                        [
                            'title' => 'Status',
                            'data' => [
                                ['label' => 'Semua', 'key' => '', 'columnIndex' => 3],
                                ['label' => 'Aktif', 'key' => 'Aktif', 'columnIndex' => 3],
                                ['label' => 'Nonaktif', 'key' => 'Nonaktif', 'columnIndex' => 3],
                            ],
                        ],
                    ]" :layoutTopEnd="true">
                </x-datatables>
            </section>
            {{-- End Table --}}
        </div>
    </div>
</x-app-layout>
