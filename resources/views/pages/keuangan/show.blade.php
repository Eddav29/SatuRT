<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />

        <div class="p-6 rounded-xl bg-white-snow mt-5">
            {{-- Detail Keuangan --}}
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
                    <h1 class="font-bold md:text-2xl text-xl">Detail Keuangan</h1>
                </div>
            </section>

            {{-- Forms Keuangan --}}
            <section>
                <div class="p-6 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col md:grid md:grid-cols-2 gap-5">
                    @if ($detailKeuangan)
                        <div>
                            <h5 class="font-semibold">Judul Catatan</h5>
                            <p>{{ $detailKeuangan->judul ?? 'Tidak Ada Data' }}</p>
                        </div>
                        <div>
                            <h5 class="font-semibold">Asal Keuangan</h5>
                            <p>{{ $detailKeuangan->asal_keuangan ?? 'Tidak Ada Data' }}</p>
                        </div>
                        <div>
                            <h5 class="font-semibold">Jenis Catatan</h5>
                            <p>{{ $detailKeuangan->jenis_keuangan ?? 'Tidak Ada Data' }}</p>
                        </div>
                        <div>
                            <h5 class="font-semibold">Nominal</h5>
                            <p>{{ $detailKeuangan->nominal ?? 'Tidak Ada Data' }}</p>
                        </div>
                        <div>
                            <h5 class="font-semibold">Saldo Sebelum</h5>
                            <p>{{ $saldoSebelum ?? 'Tidak Ada Data' }}</p>
                        </div>
                        <div>
                            <h5 class="font-semibold">Saldo Sesudah</h5>
                            <p>{{ $detailKeuangan->keuangan->total_keuangan ?? 'Tidak Ada Data' }}</p>
                        </div>
                        <div>
                            <h5 class="font-semibold">Dibuat Pada</h5>
                            <p>{{ $detailKeuangan->created_at ?? 'Tidak Ada Data' }}</p>
                        </div>
                        <div>
                            <h5 class="font-semibold">Terakhir Diubah</h5>
                            <p>{{ $detailKeuangan->updated_at ?? 'Tidak Ada Data' }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <h5 class="font-semibold after:content-['*'] after:ml-0.5 after:text-red-500">Keterangan
                            </h5>
                            <div
                                class="w-full h-48 p-2.5 rounded border border-neutral-900 border-opacity-30 flex justify-start items-start gap-2.5">
                                <div class="flex justify-start items-center gap-2.5">
                                    <div class="text-neutral-900 text-lg font-normal font-['Poppins'] leading-7">
                                        <p>{!! $detailKeuangan->keterangan ?? 'Tidak Ada Data' !!}</p>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Tombol Kembali --}}
                        <div class="flex gap-x-5">
                            <button onclick="window.history.back()"
                                class="text-black border-2 py-3 px-5 rounded-lg mt-4">
                                {{-- <p class="max-lg:hidden"><</p> --}}
                                <p">Kembali</p>
                            </button>
                        </div>
                    @else
                        <div>
                            <p>Tidak ada data yang ditemukan.</p>
                        </div>
                    @endif
                </div>
            </section>

            {{-- Akhir Detail Keuangan --}}
        </div>
    </div>
</x-app-layout>
