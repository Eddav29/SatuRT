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
                    <div>
                        <h5 class="font-semibold">Judul Catatan</h5>
                        <p>{{ $detailKeuangan->judul }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Asal</h5>
                        <p>{{ $detailKeuangan->keuangan->penduduk->nama }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Jenis Catatan</h5>
                        <p>{{ $detailKeuangan->jenis_keuangan }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Nominal</h5>
                        <p>{{ $detailKeuangan->nominal }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Saldo Sebelum</h5>
                        <p>{{ $detailKeuangan->keuangan->total_keuangan }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Saldo Sesudah</h5>
                        <p>{{ $detailKeuangan->nominal }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Dibuat Pada</h5>
                        <p>{{ $detailKeuangan->created_at }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Terakhri Diubah</h5>
                        <p>{{ $detailKeuangan->updated_at }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <h5 class="font-semibold">Keterangan</h5>
                        <p>{{ $detailKeuangan->keterangan }}</p>
                    </div>
                </div>
            </section>
            {{-- Akhir Detail Keuangan --}}
        </div>
    </div>
</x-app-layout>
