<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="px-8">
        <div class="rounded-lg bg-white px-6 py-0 overflow-hidden">
            @if (session('success'))
                <div role="alert" class="rounded border-s-4 border-green-500 bg-white p-4">
                    <div class="flex items-start gap-4">
                        <span class="text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>

                        <div class="flex-1">
                            <strong class="block font-medium text-gray-900">Berhasil</strong>

                            <p class="mt-1 text-sm text-gray-700">Data berhasil ditambahkan</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div role="alert" class="rounded border-s-4 border-red-500 bg-red-50 p-4">
                    <div class="flex items-center gap-2 text-red-800">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd"
                                d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" />
                        </svg>
                        <strong class="block font-medium"> Terjadi Kesalahan </strong>
                    </div>

                    <p class="mt-2 text-sm text-red-700">
                        {{ session('error') }}
                    </p>
                </div>
            @endif
            
            {{-- Table --}}
                    <section>
                        <x-datatables id="kriteria_id" url="/spk/kriteria" :columns="[
                            [
                                'label' => 'ID',
                                'key' => 'kriteria_id',
                                'style' => [
                                    'text-align' => 'left',
                                ],
                            ],
                            [
                                'label' => 'Nama Kriteria',
                                'key' => 'nama_kriteria',
                                'style' => [
                                    'text-align' => 'left',
                                ],
                            ],
                            [
                                'label' => 'Jenis Kriteria',
                                'key' => 'jenis_kriteria',
                                'style' => [
                                    'text-align' => 'left',
                                ],
                            ],
                            [
                                'label' => 'Bobot',
                                'key' => 'bobot',
                                'style' => [
                                    'text-align' => 'left',
                                ],
                            ]
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