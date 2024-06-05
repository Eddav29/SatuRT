<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">

        <div class="p-6 mt-10 rounded-xl bg-white-snow overflow-hidden">

            {{-- Table --}}
            <section>
                @php
                    $layoutTop2Start = Auth::user()->role->role_name === 'Ketua RT' ? false : true;
                @endphp
                <x-datatables id="persuratan_id" url="/persuratan" :columns="[
                    // [
                    //     'label' => 'NIK',
                    //     'key' => 'nik',
                    //     'style' => 'text-left',
                    // ],
                    [
                        'label' => 'Pemohon',
                        'key' => 'nama',
                        'style' => 'text-left truncate',
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
                        'label' => 'Keperluan',
                        'key' => 'keperluan',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'Tanggal',
                        'key' => 'created_at',
                        'style' => 'text-left truncate',
                    ],
                ]" :aksi="[
                    'detail' => true,
                    'edit' => false,
                    'hapus' => false,
                ]" :filter="[
                    [
                        'title' => 'Status',
                        'data' => [
                            ['label' => 'Semua', 'key' => '', 'columnIndex' => 1],
                            ['label' => 'Menunggu Persetujuan', 'key' => 'Menunggu Persetujuan', 'columnIndex' => 1],
                            ['label' => 'Diterima', 'key' => 'Diterima', 'columnIndex' => 1],
                            ['label' => 'Ditolak', 'key' => 'Ditolak', 'columnIndex' => 1],
                        ],
                    ],
                    [
                        'title' => 'Keperluan',
                        'data' => [
                            ['label' => 'Semua', 'key' => '', 'columnIndex' => 2],
                            ['label' => 'Surat Pengantar KTP', 'key' => 'Surat Pengantar KTP', 'columnIndex' => 2],
                            [
                                'label' => 'Surat Pengantar Kartu Keluarga',
                                'key' => 'Surat Pengantar Kartu Keluarga',
                                'columnIndex' => 2,
                            ],
                            [
                                'label' => 'Surat Pengantar Akta Kelahiran',
                                'key' => 'Surat Pengantar Akta Kelahiran',
                                'columnIndex' => 2,
                            ],
                            [
                                'label' => 'Surat Pengantar Akta Kematian',
                                'key' => 'Surat Pengantar Akta Kematian',
                                'columnIndex' => 2,
                            ],
                            ['label' => 'Surat Pengantar SKCK', 'key' => 'Surat Pengantar SKCK', 'columnIndex' => 2],
                            ['label' => 'Surat Pengantar Nikah', 'key' => 'Surat Pengantar Nikah', 'columnIndex' => 2],
                            ['label' => 'Lainnya', 'key' => 'Lainnya', 'columnIndex' => 2],
                        ],
                    ],
                ]"
                    :layoutTopEnd="true" :layoutTop2Start="$layoutTop2Start">
                </x-datatables>
        </div>
    </div>
</x-app-layout>
