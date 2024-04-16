<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        {{-- Kartu --}}
        <section>
            <div
                class="grid grid-cols-1 grid-rows-3 md:grid-rows-1 md:grid-cols-3 2xl:grid-cols-3 2xl:grid-rows-1 gap-5 ">
                <div class="flex flex-col px-5 py-7 gap-y-5  bg-blue-300 rounded-xl text-navy-night">
                    <div>
                        <div class="bg-blue-gray rounded-full p-2 w-12 h-12 flex justify-center items-center">
                            <img src="{{ asset('assets/images/keuangan_blue_icon.svg') }}" alt="">
                        </div>
                    </div>
                    <div>
                        <h1 class="text-sm/5">Total Pemasukan</h1>
                        <h1 class="text-base/7 font-semibold"> Rp. {{ number_format($total_pemasukan) }} </h1>
                    </div>
                </div>
                <div class="flex flex-col px-5 py-7 gap-y-5 bg-red-300 rounded-xl">
                    <div>
                        <div class="bg-blue-gray rounded-full p-2 w-12 h-12 flex justify-center items-center">
                            <img src="{{ asset('assets/images/keuangan_blue_icon.svg') }}" alt="">
                        </div>
                    </div>
                    <div>
                        <h1 class="text-sm/5">Total Pengeluaran</h1>
                        <h1 class="text-base/7 font-semibold"> Rp. {{ number_format($total_pengeluaran) }}</h1>
                    </div>
                </div>
                <div class="flex flex-col px-5 py-7 gap-y-5 bg-green-200 rounded-xl">
                    <div>
                        <div class="bg-blue-gray rounded-full p-2 w-12 h-12 flex justify-center items-center">
                            <img src="{{ asset('assets/images/keuangan_blue_icon.svg') }}" alt="">
                        </div>
                    </div>
                    <div>
                        <h1 class="text-sm/5">Total Keuangan</h1>
                        <h1 class="text-base/7 font-semibold"> Rp. {{ number_format($total_keseluruhan) }}</h1>
                    </div>
                </div>

            </div>
        </section>
        {{-- Akhir Kartu --}}
        <div class="p-6 mt-10 rounded-xl bg-white-snow overflow-hidden">
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
                            <strong class="block font-medium text-gray-900">Behasil</strong>

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
                <x-datatables id="keuangan_id" url="/keuangan" :columns="[
                    [
                        'label' => 'Judul keuangan',
                        'key' => 'judul',
                        'style' => [
                            'text-align' => 'left',
                        ],
                    ],
                    [
                        'label' => 'Jenis keuangan',
                        'key' => 'jenis_keuangan',
                        'style' => [
                            'text-align' => 'left',
                        ],
                    ],
                    [
                        'label' => 'Nominal',
                        'key' => 'nominal',
                        'style' => [
                            'text-align' => 'right',
                        ],
                    ],
                    [
                        'label' => 'Tanggal',
                        'key' => 'tanggal',
                        'style' => [
                            'text-align' => 'center',
                        ],
                    ],
                    [
                        'label' => 'Dibuat Pada',
                        'key' => 'created_at',
                        'style' => [
                            'text-align' => 'center',
                        ],
                    ],
                    [
                        'label' => 'Terakhir Diubah',
                        'key' => 'updated_at',
                        'style' => [
                            'text-align' => 'center',
                        ],
                    ],
                ]" :aksi="[
                    'detail' => true,
                    'edit' => true,
                    'hapus' => true,
                ]">
                </x-datatables>
        </div>
    </div>
</x-app-layout>
