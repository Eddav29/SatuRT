<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />
        <div class="p-6 rounded-xl bg-white-snow">
            {{-- Detail Keuangan --}}
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
                    <h1 class="text-2xl font-semibold">Detail Keuangan</h1>
                </div>
            </section>
            {{-- Forms Keuangan --}}
            <section>

                <div class="mx-3 my-4 flex  max-lg:flex-col flex-nowrap font-bold">
                    <div class="w-1/2">
                        <div>Judul Catatan</div>
                        <div class="font-normal my-2">{{ $detailKeuangan->judul }}</div>
                    </div>
                    <div class="w-1/2">
                        <div>Asal</div>
                        <div class="font-normal my-2">{{ $detailKeuangan->keuangan->penduduk->nama }}</div>
                    </div>
                </div>

                <div class="mx-3 my-6 flex  max-lg:flex-col flex-nowrap font-bold">
                    <div class="w-1/2">
                        <div>Jenis Catatan</div>
                        <div class="font-normal my-2">{{ $detailKeuangan->jenis_keuangan }}</div>
                    </div>
                    <div class="w-1/2">
                        <div>Nominal</div>
                        <div class="font-normal my-2">{{ $detailKeuangan->nominal }}</div>
                    </div>
                </div>

                <div class="mx-3 my-6 flex max-lg:flex-col flex-nowrap font-bold">
                    <div class="w-1/2">
                        <div>Saldo Sebelum</div>
                        <div class="font-normal my-2">{{ $detailKeuangan->keuangan->total_keuangan }}</div>
                    </div>
                    <div class="w-1/2">
                        <div>Saldo Sesudah</div>
                        <div class="font-normal my-2">{{ $detailKeuangan->nominal }}</div>
                    </div>
                </div>

                <div class="mx-3 my-6 flex max-lg:flex-col flex-nowrap font-bold">
                    <div class="w-1/2">
                        <div>Dibuat Pada</div>
                        <div class="font-normal my-2">{{ $detailKeuangan->created_at }}</div>
                    </div>
                    <div class="w-1/2">
                        <div>Terakhir diubah</div>
                        <div class="font-normal my-2">{{ $detailKeuangan->updated_at }}</div>
                    </div>
                </div>

                <div class="mx-3 my-6 font-bold my-2">
                    <div>
                        <div>Keterangan</div>
                        <textarea
                            class="w-full h-48 p-2.5 rounded border border-neutral-900 border-opacity-30 justify-start items-start gap-2.5 inline-flex font-normal">{{ $detailKeuangan->keterangan }}</textarea>
                    </div>
                </div>
            </section>
            {{-- Akhir Detail Keuangan --}}
        </div>
    </div>

    @push('scripts')
        <script>
            const textarea = document.querySelector('textarea');
            textarea.readOnly = true;
        </script>
    @endpush

</x-app-layout>
