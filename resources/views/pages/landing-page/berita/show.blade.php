<x-guest-layout>
    <div class="flex flex-col gap-y-10 w-full max-w-7xl mx-auto">
        <section>
            <div class="flex flex-col gap-y-10">
                <div>
                    <p class="text-[1rem]/[1.618rem]">Diposting pada
                        {{ \Carbon\Carbon::parse($information->created_at)->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY') }}
                    </p>
                    <h1 class="text-[1.618rem]/[2.618rem] font-bold">{{ $information->judul_informasi }}</h1>
                    @if ($information->jenis_informasi === 'Artikel')
                        <p
                            class="text-[1rem]/[1.618rem] w-fit py-2 px-3 text-center rounded-md bg-blue-500/30 text-blue-800">
                            {{ $information->jenis_informasi }}</p>
                    @endif
                    @if ($information->jenis_informasi === 'Dokumentasi Kegiatan')
                        <p
                            class="text-[1rem]/[1.618rem] w-fit py-2 px-3 text-center rounded-md bg-green-500/30 text-green-500">
                            {{ $information->jenis_informasi }}</p>
                    @endif
                    @if ($information->jenis_informasi === 'Berita')
                        <p
                            class="text-[1rem]/[1.618rem] w-fit py-2 px-3 text-center rounded-md bg-orange-500/30 text-orange-800">
                            {{ $information->jenis_informasi }}</p>
                    @endif
                </div>
                <div>
                    <div class="h-[20rem] lg:h-[80vh] overflow-hidden">
                        <img src="{{ strpos($information->thumbnail_url, 'http') === 0 ? $information->thumbnail_url : asset('storage/images_storage/' . $information->thumbnail_url) }}"
                            alt="" class="w-full h-full object-cover rounded-xl">
                    </div>
                </div>
                <div class="lg:grid lg:grid-cols-3 lg:gap-x-5">
                    <div id="content" class="flex flex-col lg:col-span-2">
                        {!! $information->isi_informasi !!}
                    </div>
                    @if (count($otherInformations) > 0)
                        <div class="max-lg:hidden border-l-2 border-gray-300 px-4">
                            <div class="flex flex-col gap-y-5">
                                <div>
                                    <h1 class="font-bold text-[1.618rem]/[2.618rem]">Berita Lainnya</h1>
                                </div>
                                <div class="flex flex-col gap-5">
                                    @foreach ($otherInformations as $otherInformation)
                                        <a href="{{ route('berita-detail', $otherInformation->informasi_id) }}"
                                            class="lg:max-h-[29rem] group">
                                            <div class="relative h-72 lg:h-[15rem]">
                                                <img src="{{ strpos($otherInformation->thumbnail_url, 'http') === 0 ? $otherInformation->thumbnail_url : asset('storage/images_storage/' . $otherInformation->thumbnail_url) }}"
                                                    alt="" class="rounded-xl w-full h-full object-cover"
                                                    loading="lazy">
                                            </div>
                                            <div class="py-3">
                                                <h1 class="group-hover:underline font-bold text-[1rem]/[1.618rem]">
                                                    {{ $otherInformation->judul_informasi }}
                                                </h1>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- Other News --}}
        <section class="lg:hidden">
            @if (count($otherInformations) > 0)
                <div class="mt-10 flex flex-col gap-y-5">
                    <div class="border-b-2 border-gray-300">
                        <h1 class="font-bold text-[1.618rem]/[2.618rem]">Berita Lainnya</h1>
                    </div>
                    <div class="grid grid-rows-4 grid-cols-1 gap-5">
                        @foreach ($otherInformations as $otherInformation)
                            <a href="{{ route('berita-detail', $otherInformation->informasi_id) }}"
                                class="lg:max-h-[29rem] group">
                                <div class="relative h-72 lg:h-[60%]">
                                    <img src="{{ !strpos($otherInformation->thumbnail_url, 'http') ? $otherInformation->thumbnail_url : asset('storage/images_storage/' . $otherInformation->thumbnail_url) }}"
                                        alt="" class="rounded-xl w-full h-full object-cover" loading="lazy">
                                </div>
                                <div class="py-3">
                                    <h1 class="group-hover:underline font-bold text-[1.618rem]/[2.618rem]">
                                        {{ $otherInformation->judul_informasi }}
                                    </h1>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </section>
    </div>
    {{-- End Other News --}}

    @push('styles')
        <style>
            #content h2 {
                display: block;
                font-size: 1.5em;
                font-weight: bold;
            }

            #content h3 {
                display: block;
                font-size: 1.33em;
                font-weight: bold;
            }

            #content h4 {
                display: block;
                font-size: 1.17em;
                font-weight: bold;
            }

            #content ol {
                display: block;
                list-style-type: decimal;
                padding-left: 40px;
            }

            #content ul {
                display: block;
                list-style-type: disc;
                padding-left: 40px;
            }

            #content a {
                color: rgb(59 130 246);
                text-decoration: underline;
                background-color: transparent;
            }

            #content blockquote {
                padding: 1rem;
                margin: 1rem 0;
                border-left: 4px solid rgb(209 213 219);
            }

            #content table {
                table-layout: auto;
                width: 100%;
                font-size: 0.875rem;
                line-height: 1.25rem;
                text-align: left;
                color: #0B1215;
            }

            #content table th {
                background-color: rgb(229 231 235);
                padding: 0.75rem;
                border: 1px solid rgb(209 213 219);
            }

            #content table td {
                border: 1px solid rgb(209 213 219);
                padding: 0.75rem;
            }

            #content blockquote p {
                font-size: 1rem;
                line-height: 1.25rem;
                font-style: italic;
                font-weight: 500;
                line-height: 1.625;
                color: #0B1215;
            }
        </style>
    @endpush
</x-guest-layout>
