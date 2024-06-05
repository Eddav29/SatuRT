<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>


    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 rounded-xl bg-white-snow overflow-hidden">
            {{-- Table --}}
            <section>
                <x-datatables id="informasi_id" url="/informasi" :columns="[
                    [
                        'label' => 'Judul Informasi',
                        'key' => 'judul_informasi',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'Jenis Informasi',
                        'key' => 'jenis_informasi',
                        'style' => 'text-left truncate',
                        'customStyle' => [
                            'Dokumentasi Kegiatan' =>
                                'w-[15rem] py-2 px-3 text-center rounded-md bg-green-500/30 text-green-500',
                            'Dokumentasi Rapat' =>
                                'w-[15rem] py-2 px-3 text-center rounded-md bg-red-500/30 text-red-800',
                            'Pengumuman' =>
                                'w-[15rem] py-2 px-3 text-center rounded-md bg-yellow-500/30 text-yellow-800',
                            'Berita' => 'w-[15rem] py-2 px-3 text-center rounded-md bg-orange-500/30 text-orange-800',
                            'Artikel' => 'w-[15rem] py-2 px-3 text-center rounded-md bg-blue-500/30 text-blue-800',
                        ],
                    ],
                    [
                        'label' => 'Dibuat Pada',
                        'key' => 'created_at',
                        'style' => 'text-left truncate',
                    ],
                ]" :aksi="[
                    'detail' => true,
                    'edit' => true,
                    'hapus' => true,
                ]" :filter="[
                    [
                        'title' => 'Jenis Informasi',
                        'data' => [
                            ['label' => 'Artikel', 'key' => 'Artikel', 'columnIndex' => 1],
                            ['label' => 'Pengumuman', 'key' => 'Pengumuman', 'columnIndex' => 1],
                            ['label' => 'Berita', 'key' => 'Berita', 'columnIndex' => 1],
                            ['label' => 'Dokumentasi Kegiatan', 'key' => 'Dokumentasi', 'columnIndex' => 1],
                            ['label' => 'Dokumentasi Rapat', 'key' => 'Dokumentasi', 'columnIndex' => 1],
                        ],
                    ],
                ]"
                    :layoutTopEnd="true">
                </x-datatables>
            </section>
            {{-- End Table --}}
        </div>
    </div>
</x-app-layout>
