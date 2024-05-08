<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>


    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 rounded-xl bg-white-snow overflow-hidden">
            {{-- Table --}}
            <section>
                <x-datatables id="pelaporan_id" url="/pelaporan" :columns="[
                    [
                        'label' => 'ID Laporan',
                        'key' => 'pelaporan_id',
                        'style' => 'text-left',
                    ],
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
                        'label' => 'Tanggal',
                        'key' => 'tanggal',
                        'style' => 'text-center',
                    ],
                ]" :aksi="[
                    'detail' => true,
                    'edit' => true,
                    'hapus' => true,
                ]" :filter="[
                    ['label' => 'Pengaduan', 'key' => 'Pengaduan', 'columnIndex' => 2],
                    ['label' => 'Kritik', 'key' => 'Kritik', 'columnIndex' => 2],
                    ['label' => 'Saran', 'key' => 'Saran', 'columnIndex' => 2],
                    ['label' => 'Lainnya', 'key' => 'Lainnya', 'columnIndex' => 2],
                ]"
                    :layoutTopEnd="true">
                </x-datatables>
            </section>
            {{-- End Table --}}
        </div>
    </div>
</x-app-layout>
