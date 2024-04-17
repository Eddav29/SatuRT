<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        
        <div class="p-6 rounded-xl bg-white-snow">
            {{-- Detail Permohonan Surat --}}
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
                    <h1 class="text-2xl font-semibold">Detail Permohonan Surat</h1>
                </div>
            </section>
            {{-- Forms Permhonan Surat --}}
            <section>
                <div class="mx-3 my-4  max-lg:flex-col flex-nowrap font-bold">
                    <div class="w-1/2">
                        <div>NIK</div>
                        <div class="font-normal my-2">{{ $persuratan->pengajuan->penduduk->nik }}</div>
                    </div>
                    <div class="w-1/2">
                        <div>Nama</div>
                        <div class="font-normal my-2">{{ $persuratan->pengajuan->penduduk->nama }}</div>
                    </div>
                </div>

                <div class="mx-3 my-4  max-lg:flex-col flex-nowrap font-bold">
                    <div class="w-1/2">
                        <div>Jenis Surat</div>
                        <div class="font-normal my-2">{{ $persuratan->jenis_surat }}</div>
                    </div>
                    <div class="w-1/2">
                        <div>Tanggals</div>
                        <div class="font-normal my-2">{{ $persuratan->pengajuan->accepted_at }}</div>
                    </div>
                </div>
                <div class="mx-3 my-6 font-bold my-2">
                    <div>
                        <div>Keperluan</div>
                        <textarea id="textarea"
                            class="w-full h-48 p-2.5 rounded border border-neutral-900 border-opacity-30 justify-start items-start gap-2.5 inline-flex font-normal">{{ $persuratan->pengajuan->keperluan }}</textarea>
                    </div>
                </div>
                <div class="mx-3 my-6 font-bold my-2">
                    <div>
                        <div>Keterangan</div>
                        <textarea
                            class="w-full h-48 p-2.5 rounded border border-neutral-900 border-opacity-30 justify-start items-start gap-2.5 inline-flex font-normal">{{ $persuratan->pengajuan->keterangan }}</textarea>
                    </div>
                </div>

                {{-- Tombol Setujui dan Tolak --}}
                <div class="flex justify-end mx-3 mt-6 gap-2.5">
                    <div
                        class="w-36 h-14 px-7 py-3.5 bg-green-500 rounded-md justify-center items-center gap-2.5 inline-flex">
                        <div class="text-center text-zinc-100 text-lg font-normal font-['Poppins'] leading-7">Setujui
                        </div>
                    </div>
                    <div
                        class="w-36 h-14 px-5 py-3.5 bg-red-500 rounded-md justify-center items-center gap-2.5 inline-flex">
                        <div class="text-center text-indigo-50 text-lg font-normal font-['Poppins'] leading-7">Tolak
                        </div>
                    </div>
                </div>
            </section>
            {{-- Akhir Detail Keuangan --}}
        </div>
    </div>

    @push('scripts')
        <script>
            const textarea = document.querySelector('#textarea');
            textarea.readOnly = true;
        </script>
    @endpush

</x-app-layout>
