<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <x-action-button :href="'pelaporan'" :id="$pelaporan->pelaporan_id" />
        <div class="p-6 rounded-xl bg-white-snow">
            {{-- Information Details --}}
            <section>
                <div class="flex flex-col gap-y-10">
                    {{-- <div class="flex flex-col gap-y-3">
                        <p class="text-sm">Diposting pada {{ $pelaporan->created_at }}</p>
                        <p class="text-sm">Dibuat oleh {{ $pelaporan->penduduk->nama }}</p>
                        <h1 class="font-bold text-4xl">{{ $pelaporan->judul_pelaporan }}</h1>
                        <div
                            class="{{ (($pelaporan->jenis_pelaporan == 'Dokumentasi' ? 'bg-green-500/30 text-green-500' : $pelaporan->jenis_pelaporan == 'Pengumuman') ? 'bg-yellow-500/30 text-yellow-500' : $pelaporan->jenis_pelaporan == 'Artikel') ? 'bg-blue-500/30 text-blue-500' : 'bg-red-500/30 text-red-500' }} w-fit px-4 py-2 rounded-md">
                            <p>{{ $pelaporan->jenis_pelaporan }}</p>
                        </div>
                    </div> --}}
                    <div>
                        <img src="{{ asset('storage/resident-report_images/' . $pelaporan->image_url) }}"
                            alt="" class="w-full object-cover rounded-lg">
                    </div>
                    <div>
                        {!! $pelaporan->isi_pelaporan !!}
                    </div>
                </div>
            </section>
            {{-- End Information Details --}}
        </div>
    </div>

</x-app-layout>
