<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>


    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 rounded-xl bg-white-snow overflow-hidden">

            {{-- Table --}}
            <section>
                <x-datatables :layoutTop2Start=false id="pelaporan_id" url="/pelaporan" :columns="[
                    [
                        'label' => 'Pelapor',
                        'key' => 'pelapor',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'Status',
                        'key' => 'status',
                        'style' => 'text-center',
                        'customStyle' => [
                            'Menunggu Persetujuan' =>'w-[10rem] py-2 px-3 text-center rounded-md bg-yellow-500/30 text-yellow-800',
                            'Diterima' =>'w-[10rem] py-2 px-3 text-center rounded-md bg-green-500/30 text-green-500',
                            'Ditolak' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-red-500/30 text-orange-800',
                            'Dibatalkan' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-orange-500/30 text-red-800',
                        ],
                    ],
                    [
                        'label' => 'Jenis Laporan',
                        'key' => 'jenis_pelaporan',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'Tanggal',
                        'key' => 'tanggal',
                        'style' => 'text-left',
                    ],
                ]"
                    :aksi="[
                        'detail' => true,
                        'edit' => false,
                        'hapus' => false,
                    ]" :filter="[
                        ['label' => 'Pengaduan', 'key' => 'Pengaduan', 'columnIndex' => 2],
                        ['label' => 'Kritik', 'key' => 'Kritik', 'columnIndex' => 2],
                        ['label' => 'Saran', 'key' => 'Saran', 'columnIndex' => 2],
                        ['label' => 'Lainnya', 'key' => 'Lainnya', 'columnIndex' => 2],
                    ]" :layoutTop2End="true">
                </x-datatables>
            </section>
            {{-- End Table --}}
        </div>
    </div>
</x-app-layout>
