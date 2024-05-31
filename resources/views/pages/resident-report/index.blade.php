<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>


    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 rounded-xl bg-white-snow overflow-hidden">

            {{-- Table --}}
            <section>
                @php
                    $layoutTop2Start = Auth::user()->role->role_name === 'Ketua RT' ? false : true;
                @endphp
                <x-datatables id="pelaporan_id" url="/pelaporan" :columns="[
                    [
                        'label' => 'Pelapor',
                        'key' => 'pelapor',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'Jenis Laporan',
                        'key' => 'jenis_pelaporan',
                        'style' => 'text-left',
                        'customStyle' => [
                            'Pengaduan' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-red-500/30 text-red-800',
                            'Lainnya' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-blue-500/30 text-blue-800',
                            'Kritik' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-yellow-500/30 text-yellow-800',
                            'Saran' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-green-500/30 text-green-800',
                        ],
                    ],
                    [
                        'label' => 'Status',
                        'key' => 'status',
                        'style' => 'text-left',
                        'customStyle' => [
                            'Menunggu Persetujuan' =>
                                'w-[14rem] py-2 px-3 text-center rounded-md bg-yellow-500/30 text-yellow-800',
                            'Diterima' => 'w-[14rem] py-2 px-3 text-center rounded-md bg-green-500/30 text-green-500',
                            'Ditolak' => 'w-[14rem] py-2 px-3 text-center rounded-md bg-red-500/30 text-orange-800',
                            'Dibatalkan' => 'w-[14rem] py-2 px-3 text-center rounded-md bg-orange-500/30 text-red-800',
                        ],
                    ],
                    [
                        'label' => 'Tanggal',
                        'key' => 'tanggal',
                        'style' => 'text-left',
                    ],
                ]"
                    :aksi="[
                        'detail' => true,
                        'edit' => Auth::user()->role->role_name === 'Ketua RT' ? false : true,
                        'hapus' => Auth::user()->role->role_name === 'Ketua RT' ? false : true,
                    ]" :filter="[
                        [
                            'title' => 'Jenis Pelaporan',
                            'data' => [
                                ['label' => 'Semua Jenis Laporan', 'key' => '', 'columnIndex' => 1],
                                ['label' => 'Pengaduan', 'key' => 'Pengaduan', 'columnIndex' => 1],
                                ['label' => 'Kritik', 'key' => 'Kritik', 'columnIndex' => 1],
                                ['label' => 'Saran', 'key' => 'Saran', 'columnIndex' => 1],
                                ['label' => 'Lainnya', 'key' => 'Lainnya', 'columnIndex' => 1],
                            ],
                        ],
                        [
                            'title' => 'Status',
                            'data' => [
                                ['label' => 'Semua Status Laporan', 'key' => '','columnIndex' => 2],
                                ['label' => 'Diterima', 'key' => 'Diterima', 'columnIndex' => 2],
                                ['label' => 'Ditolak', 'key' => 'Ditolak', 'columnIndex' => 2],
                                ['label' => 'Menunggu Persetujuan', 'key' => 'Menunggu Persetujuan', 'columnIndex' => 2],
                            ],
                        ],
                    ]" :layoutTop2End="true" :layoutTopEnd="true" :layoutTop2Start="$layoutTop2Start">
                </x-datatables>
            </section>
            {{-- End Table --}}
        </div>
    </div>
</x-app-layout>
