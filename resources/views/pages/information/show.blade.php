<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" /> 
        <div class="p-6 rounded-xl bg-white-snow">
            {{-- Information Details --}}
            <section>
                <div class="flex flex-col gap-y-10">
                    <div class="flex flex-col gap-y-3">
                        <p class="text-sm">Diposting pada {{ $information->created_at }}</p>
                        <p class="text-sm">Dibuat oleh {{ $information->penduduk->nama }}</p>
                        <h1 class="font-bold text-4xl">{{ $information->judul_informasi }}</h1>
                        <div
                            class="{{ (($information->jenis_informasi == 'Dokumentasi' ? 'bg-green-500/30 text-green-500' : $information->jenis_informasi == 'Pengumuman') ? 'bg-yellow-500/30 text-yellow-500' : $information->jenis_informasi == 'Artikel') ? 'bg-blue-500/30 text-blue-500' : 'bg-red-500/30 text-red-500' }} w-fit px-4 py-2 rounded-md">
                            <p>{{ $information->jenis_informasi }}</p>
                        </div>
                    </div>
                    <div>
                        <img src="{{ asset('storage/information_images/' . $information->thumbnail_url) }}"
                            alt="" class="w-full object-cover rounded-lg">
                    </div>
                    <div>
                        {!! $information->isi_informasi !!}
                    </div>
                </div>
            </section>
            {{-- End Information Details --}}
        </div>
    </div>

</x-app-layout>
