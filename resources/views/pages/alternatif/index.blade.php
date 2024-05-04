<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 rounded-xl bg-white-snow overflow-hidden">
            {{-- Table --}}
            <section>
                <x-datatables id="alternatif_id" url="/pendukung-keputusan/alternatif" :columns="[
                    [
                        'label' => 'ID',
                        'key' => 'alternatif_id',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'Nama Kegiatan',
                        'key' => 'nama_alternatif',
                        'style' => 'text-left',
                    ],
                ]"
                    :aksi="[
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
