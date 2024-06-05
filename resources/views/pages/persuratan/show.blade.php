<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        @if (Auth::user()->role->role_name !== 'Ketua RT' && Auth::user()->role->role_name !== 'Admin')
            <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />
        @endif
        <div class="p-6 rounded-xl bg-white-snow mt-6">
            {{-- Detail Permohonan Surat --}}
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
                    <h1 class="font-bold md:text-2xl text-xl">Detail Permohonan Surat</h1>
                </div>
            </section>
            {{-- Form Permohonan Surat --}}
            <section>
                <form
                    class="p-6 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col md:grid md:grid-cols-1 md:auto-rows-auto gap-y-5">
                    <div class="md:grid md:grid-cols-4">
                        <h5 class="font-semibold">NIK</h5>
                        <p class="md:col-span-3">{{ Str::mask($persuratan->pengajuan->penduduk->nik ?? '', '*', 6) }}</p>
                    </div>
                    <div class="md:grid md:grid-cols-4">
                        <h5 class="font-semibold">Nama</h5>
                        <p class="md:col-span-3">{{ $persuratan->pemohon()->nama }}</p>
                    </div>
                    <div class="md:grid md:grid-cols-4">
                        <h5 class="font-semibold">Jenis Surat</h5>
                        <p class="md:col-span-3">{{ $persuratan->jenis_surat }}</p>
                    </div>
                    <div class="md:grid md:grid-cols-4">
                        <h5 class="font-semibold">Disetujui Tanggal</h5>
                        <p class="md:col-span-3">
                            {{ \Carbon\Carbon::parse($persuratan->pengajuan->accepted_at)->format('d-m-Y | H:i:s') }}
                        </p>
                    </div>
                    @if ($persuratan->jenis_surat === 'Lainnya')
                        <div class="md:grid md:grid-cols-1 md:grid-rows-2">
                            <h5 class="font-semibold">Keperluan</h5>
                            <p class="md:col-span-3">{{ $persuratan->pengajuan->keperluan }}</p>
                        </div>
                    @endif
                    <div class="md:flex md:flex-col">
                        <h5 class="font-semibold">Keterangan</h5>
                        <div class="w-full h-48 p-2.5 rounded border border-neutral-900 border-opacity-30 justify-start items-start gap-2.5 inline-flex font-normal">
                            {!! $persuratan->pengajuan->keterangan !!}
                        </div>
                        {{-- <textarea id="textarea" readonly
                            class="w-full h-48 p-2.5 rounded border border-neutral-900 border-opacity-30 justify-start items-start gap-2.5 inline-flex font-normal"></textarea> --}}
                    </div>
                    @if ($persuratan->pengajuan->status->nama === 'Diterima')
                        <a href="{{ route('persuratan.pdf', $persuratan->persuratan_id) }}"
                            class="bg-blue-500 text-white-snow text-sm px-4 py-2 rounded-md flex justify-center items-center gap-x-3"
                            target="_blank">Unduh PDF</a>
                    @else
                        <a class="bg-gray-400 text-white-snow text-sm px-4 py-2 rounded-md flex justify-center items-center gap-x-3"
                            style="opacity: 0.5; cursor: not-allowed;">Unduh PDF (Belum disetujui)</a>
                    @endif
                    {{-- Tombol Setujui dan Tolak --}}
                    {{-- Tombol Setuju dan Tolak hanya jika role adalah "Ketua RT" atau "Admin" --}}
                    @if (
                        (Auth::user()->role->role_name === 'Ketua RT' || Auth::user()->role->role_name === 'Admin') &&
                            $persuratan->pengajuan->accepted_by === null)
                        <div class="mt-10 flex gap-x-5">
                            <a href="{{ route('persuratan.approve', $persuratan->persuratan_id) }}"
                                class="bg-green-500 text-white-snow text-sm px-4 py-2 rounded-md flex justify-center items-center gap-x-3">Setuju</a>
                            <a href="{{ route('persuratan.reject', $persuratan->persuratan_id) }}"
                                class="bg-red-500 text-white-snow text-sm px-4 py-2 rounded-md flex justify-center items-center gap-x-3">Tolak</a>
                        </div>
                    @endif

                    {{-- Tombol Kembali --}}
                    <div class="flex gap-x-5">
                        <button onclick="window.history.back()" class="text-black border-2 py-3 px-5 rounded-lg mt-4">
                            {{-- <p class="max-lg:hidden"><</p> --}}
                            <p">Kembali</p>
                        </button>
                    </div>
                </form>
            </section>
            {{-- Akhir Detail Permohonan Surat --}}
        </div>
    </div>

    @push('scripts')
        <script>
            const textarea = document.querySelector('#textarea');
            textarea.readOnly = true;
        </script>
    @endpush

</x-app-layout>
