<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 rounded-xl bg-white-snow overflow-hidden">

            {{-- Cards --}}
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
                            <h1 class="text-sm/5">Total Pemasukan Tahun ini</h1>
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
                            <h1 class="text-sm/5">Total Pengeluaran Tahun ini</h1>
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
                            <h1 class="text-sm/5">Saldo</h1>
                            <h1 class="text-base/7 font-semibold"> Rp. {{ number_format($total_keseluruhan) }}</h1>
                        </div>
                    </div>

                </div>
            </section>
            {{-- Table --}}
            <section>
                <x-datatables id="detail_keuangan_id" url="/keuangan" :columns="[
                    [
                        'label' => 'Judul keuangan',
                        'key' => 'judul',
                        'style' => 'text-left',
                    ],
                    [
                        'label' => 'Jenis keuangan',
                        'key' => 'jenis_keuangan',
                        'style' => 'text-left',
                        'customStyle' => [
                            'Pemasukan' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-green-500/30 text-green-800',
                            'Pengeluaran' => 'w-[10rem] py-2 px-3 text-center rounded-md bg-red-500/30 text-red-800',
                        ],
                    ],
                    [
                        'label' => 'Nominal',
                        'key' => 'nominal',
                        'style' => 'text-left',
                    ],
                ]" :aksi="[
                    'detail' => true,
                    'edit' => true,
                    'hapus' => true,
                ]"
                    :filter="[
                        [
                            'title' => 'Jenis keuangan',
                            'data' => [
                                ['label' => 'Pemasukan', 'key' => 'Pemasukan', 'columnIndex' => 1],
                                ['label' => 'Pengeluaran', 'key' => 'Pengeluaran', 'columnIndex' => 1],
                            ],
                        ],
                    ]" :layoutTopEnd="true">
                </x-datatables>
            </section>
            {{-- End Table --}}
        </div>
    </div>
</x-app-layout>
