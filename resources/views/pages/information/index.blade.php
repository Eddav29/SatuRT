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
                        'style' => 'text-left',
                        'customStyle' => [
                            'Dokumentasi' => 'w-fit py-2 px-3 text-center rounded-md bg-green-500/30 text-green-500',
                            'Pengumuman' => 'w-fit py-2 px-3 text-center rounded-md bg-yellow-500/30 text-yellow-800',
                            'Berita' => 'w-fit py-2 px-3 text-center rounded-md bg-orange-500/30 text-orange-800',
                            'Artikel' => 'w-fit py-2 px-3 text-center rounded-md bg-blue-500/30 text-blue-800',
                        ],
                    ],
                    [
                        'label' => 'Dibuat Pada',
                        'key' => 'created_at',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'Terakhir Diubah',
                        'key' => 'updated_at',
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
