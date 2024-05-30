<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 rounded-xl bg-white-snow overflow-hidden">
            {{-- Table --}}
            <section>
                <x-datatables id="kriteria_id" url="/pendukung-keputusan/kriteria" :columns="[
                    [
                        'label' => 'ID',
                        'key' => 'kriteria_id',
                        'style' => 'text-left truncate',
                    ],
                    [
                        'label' => 'Nama Kriteria',
                        'key' => 'nama_kriteria',
                        'style' => 'text-left truncate',
                    ],
                    [
                        'label' => 'Jenis Kriteria',
                        'key' => 'jenis_kriteria',
                        'style' => 'text-left truncate',
                        'customStyle' => [
                            'Benefit' => 'bg-green-500/20 text-green-500 w-fit py-2 px-3 text-center rounded-md',
                            'Cost' => 'bg-red-500/20 text-red-500 w-fit py-2 px-3 text-center rounded-md',
                        ],
                    ],
                    [
                        'label' => 'Bobot',
                        'key' => 'bobot',
                        'style' => 'text-left truncate',
                    ],
                ]" :filter="[
                    [
                        'title' => 'Jenis Kriteria',
                        'data' => [
                            [
                                'label' => 'Cost',
                                'key' => 'Cost',
                                'columnIndex' => 2,
                            ],
                            [
                                'label' => 'Benefit',
                                'key' => 'Benefit',
                                'columnIndex' => 2,
                            ],
                        ],
                    ],
                ]"
                    :layoutTop2Start="false" :layoutTop2End="true" :layoutTopEnd="true">
                </x-datatables>
            </section>
            {{-- End Table --}}
        </div>
    </div>
</x-app-layout>
