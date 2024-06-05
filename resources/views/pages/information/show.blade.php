<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />
        @if (
            ($information->jenis_informasi == 'Pengumuman' || $information->jenis_informasi == 'Dokumentasi Rapat') &&
                $fileType == 'file')
            <div class="p-6 rounded-xl bg-white-snow mt-5">
                <h1 class="font-semibold text-lg">Lampiran</h1>
                <div class="flex gap-x-2 items-center">
                    @php
                        $pos = strpos($information->thumbnail_url, '-');
                        $fileName = '';
                        if ($pos !== false) {
                            $fileName = substr($information->thumbnail_url, $pos + 1);
                        }
                    @endphp
                    <div id="file-icon"></div>
                    <div class="flex flex-col" id="preview-file-container">
                        @if ($file_extension == 'pdf')
                            <a id="preview-file"
                                href="{{ route('file.show', ['path' => 'pengumuman', 'identifier' => $information->informasi_id]) }}"
                                class="text-blue-500 py-3 text-sm font-light">{{ $fileName }}</a>
                        @else
                            <a id="preview-file"
                                href="{{ route('file.download', ['path' => 'pengumuman', 'identifier' => $information->informasi_id]) }}"
                                class="text-blue-500 py-3 text-sm font-light" target="_blank">{{ $fileName }}</a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        <div class="p-6 rounded-xl bg-white-snow mt-5">
            {{-- Information Details --}}
            <section>
                <div
                    class="flex flex-col {{ ($information->jenis_informasi == 'Pengumuman' || $information->jenis_informasi == 'Dokumentasi Rapat') && $fileType == 'file' ? 'gap-y-5' : 'gap-y-10' }}">
                    <div class="flex flex-col gap-y-3">
                        <div class="grid grid-rows-2 grid-cols-1 gap-y-3 lg:grid-cols-2 lg:grid-rows-1">
                            <p class="text-xs md:text-sm break-words">Diposting pada {{ $information->created_at }}</p>
                            @if ($information->created_at != $information->updated_at)
                                <p class="text-xs md:text-sm break-words lg:flex lg:justify-end">Terakhir diperbarui
                                    pada {{ $information->created_at }}</p>
                            @endif
                        </div>
                        <p class="text-xs md:text-sm break-words">Dibuat oleh {{ $information->penduduk->nama }}</p>
                        <h1 class="font-bold text-3xl md:text-4xl break-words">{{ $information->judul_informasi }}</h1>
                        <div @if ($information->jenis_informasi === 'Artikel') <p
                                    class="text-[1rem]/[1.618rem] w-fit py-2 px-3 text-center rounded-md bg-blue-500/30 text-blue-800">
                                    {{ $information->jenis_informasi }}</p> @endif
                            @if ($information->jenis_informasi === 'Dokumentasi Kegiatan') <p
                                    class="text-[1rem]/[1.618rem] w-fit py-2 px-3 text-center rounded-md bg-green-500/30 text-green-500">
                                    {{ $information->jenis_informasi }}</p> @endif
                            @if ($information->jenis_informasi === 'Berita') <p
                                    class="text-[1rem]/[1.618rem] w-fit py-2 px-3 text-center rounded-md bg-orange-500/30 text-orange-800">
                                    {{ $information->jenis_informasi }}</p> @endif
                            @if ($information->jenis_informasi === 'Pengumuman') <p
                                    class="text-[1rem]/[1.618rem] w-fit py-2 px-3 text-center rounded-md bg-yellow-500/30 text-yellow-800">
                                    {{ $information->jenis_informasi }}</p> @endif
                            @if ($information->jenis_informasi === 'Dokumentasi Rapat') <p
                                    class="text-[1rem]/[1.618rem] w-fit py-2 px-3 text-center rounded-md bg-red-500/30 text-red-800">
                                    {{ $information->jenis_informasi }}</p> @endif
                            </div>
                        </div>
                        @if ($information->jenis_informasi != 'Pengumuman' && $information->jenis_informasi != 'Dokumentasi Rapat')
                            @if (strpos($information->thumbnail_url, 'https://') === 0)
                                <div>
                                    <img src="{{ $information->thumbnail_url }}" alt=""
                                        class="w-full object-cover rounded-lg">
                                </div>
                            @else
                                <div>
                                    <img src="{{ asset('storage/images_storage/' . $information->thumbnail_url) }}"
                                        alt="" class="w-full object-cover rounded-lg">
                                </div>
                            @endif
                        @elseif (
                            ($information->jenis_informasi == 'Pengumuman' || $information->jenis_informasi == 'Dokumentasi Rapat') &&
                                $fileType == 'image')
                            <div>
                                <img src="{{ route('storage.announcement', ['filename' => $information->thumbnail_url]) }}"
                                    alt="" class="w-full object-cover rounded-lg">
                            </div>
                        @endif
                        <div id="content">
                            {!! $information->isi_informasi !!}
                        </div>
                    </div>

                    {{-- Back Button --}}
                    <div class="mt-10 flex gap-x-5">
                        <button onclick="window.history.back()" class="text-black border-2 py-3 px-5 rounded-lg mt-4">
                            <p">Kembali</p>
                        </button>
                    </div>
            </section>
            {{-- End Information Details --}}
        </div>
    </div>

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

    @push('scripts')
        <script>
            const pdfIcon = () => {
                return `
                <svg height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                        <path style="fill:#E2E5E7;"
                            d="M128,0c-17.6,0-32,14.4-32,32v448c0,17.6,14.4,32,32,32h320c17.6,0,32-14.4,32-32V128L352,0H128z" />
                        <path style="fill:#B0B7BD;" d="M384,128h96L352,0v96C352,113.6,366.4,128,384,128z" />
                        <polygon style="fill:#CAD1D8;" points="480,224 384,128 480,128 " />
                        <path style="fill:#F15642;"
                            d="M416,416c0,8.8-7.2,16-16,16H48c-8.8,0-16-7.2-16-16V256c0-8.8,7.2-16,16-16h352c8.8,0,16,7.2,16,16 V416z" />
                        <g>
                            <path style="fill:#FFFFFF;"
                                d="M101.744,303.152c0-4.224,3.328-8.832,8.688-8.832h29.552c16.64,0,31.616,11.136,31.616,32.48 c0,20.224-14.976,31.488-31.616,31.488h-21.36v16.896c0,5.632-3.584,8.816-8.192,8.816c-4.224,0-8.688-3.184-8.688-8.816V303.152z M118.624,310.432v31.872h21.36c8.576,0,15.36-7.568,15.36-15.504c0-8.944-6.784-16.368-15.36-16.368H118.624z" />
                            <path style="fill:#FFFFFF;"
                                d="M196.656,384c-4.224,0-8.832-2.304-8.832-7.92v-72.672c0-4.592,4.608-7.936,8.832-7.936h29.296 c58.464,0,57.184,88.528,1.152,88.528H196.656z M204.72,311.088V368.4h21.232c34.544,0,36.08-57.312,0-57.312H204.72z" />
                            <path style="fill:#FFFFFF;"
                                d="M303.872,312.112v20.336h32.624c4.608,0,9.216,4.608,9.216,9.072c0,4.224-4.608,7.68-9.216,7.68 h-32.624v26.864c0,4.48-3.184,7.92-7.664,7.92c-5.632,0-9.072-3.44-9.072-7.92v-72.672c0-4.592,3.456-7.936,9.072-7.936h44.912 c5.632,0,8.96,3.344,8.96,7.936c0,4.096-3.328,8.704-8.96,8.704h-37.248V312.112z" />
                        </g>
                        <path style="fill:#CAD1D8;"
                            d="M400,432H96v16h304c8.8,0,16-7.2,16-16v-16C416,424.8,408.8,432,400,432z" />
                    </svg>
                `
            }

            const docsIcon = () => {
                return `
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25px" height="25px" viewBox="0 0 48 48">
                    <linearGradient id="pg10I3OeSC0NOv22QZ6aWa_v0YYnU84T2c4_gr1" x1="-209.942" x2="-179.36" y1="-3.055" y2="27.526" gradientTransform="translate(208.979 6.006)" gradientUnits="userSpaceOnUse">
                        <stop offset="0" stop-color="#55adfd"></stop><stop offset="1" stop-color="#438ffd"></stop>
                    </linearGradient>
                    <path fill="url(#pg10I3OeSC0NOv22QZ6aWa_v0YYnU84T2c4_gr1)" d="M39.001,13.999v27c0,1.105-0.896,2-2,2h-26	c-1.105,0-2-0.895-2-2v-34c0-1.104,0.895-2,2-2h19l2,7L39.001,13.999z"></path>
                    <path fill="#fff" fill-rule="evenodd" d="M15.999,18.001v2.999	h17.002v-2.999H15.999z" clip-rule="evenodd"></path>
                    <path fill="#fff" fill-rule="evenodd" d="M16.001,24.001v2.999	h17.002v-2.999H16.001z" clip-rule="evenodd"></path><path fill="#fff" fill-rule="evenodd" d="M15.999,30.001v2.999	h12.001v-2.999H15.999z" clip-rule="evenodd"></path>
                    <linearGradient id="pg10I3OeSC0NOv22QZ6aWb_v0YYnU84T2c4_gr2" x1="-197.862" x2="-203.384" y1="-4.632" y2=".89" gradientTransform="translate(234.385 12.109)" gradientUnits="userSpaceOnUse">
                        <stop offset="0" stop-color="#427fdb"></stop><stop offset="1" stop-color="#0c52bb"></stop>
                    </linearGradient>
                    <path fill="url(#pg10I3OeSC0NOv22QZ6aWb_v0YYnU84T2c4_gr2)" d="M30.001,13.999l0.001-9l8.999,8.999L30.001,13.999z"></path>
                </svg>
                `;
            }

            const sheetIcon = () => {
                return `
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25px" height="25px" viewBox="0 0 48 48">
                    <path fill="#43a047" d="M37,45H11c-1.657,0-3-1.343-3-3V6c0-1.657,1.343-3,3-3h19l10,10v29C40,43.657,38.657,45,37,45z"></path>
                    <path fill="#c8e6c9" d="M40 13L30 13 30 3z"></path><path fill="#2e7d32" d="M30 13L40 23 40 13z"></path>
                    <path fill="#e8f5e9" d="M31,23H17h-2v2v2v2v2v2v2v2h18v-2v-2v-2v-2v-2v-2v-2H31z M17,25h4v2h-4V25z M17,29h4v2h-4V29z M17,33h4v2h-4V33z M31,35h-8v-2h8V35z M31,31h-8v-2h8V31z M31,27h-8v-2h8V27z"></path>
                </svg>`;
            };

            document.addEventListener('DOMContentLoaded', function() {
                const file_icon_container = document.querySelector('#file-icon');

                if (file_icon_container) {
                    if ('{{ $file_extension }}' == 'pdf') {
                        file_icon_container.innerHTML = pdfIcon();
                    } else if ('{{ $file_extension }}' == 'doc' || '{{ $file_extension }}' == 'docx') {
                        file_icon_container.innerHTML = docsIcon();
                    } else if ('{{ $file_extension }}' == 'xls' || '{{ $file_extension }}' == 'xlsx') {
                        file_icon_container.innerHTML = sheetIcon();
                    }
                }
            });
        </script>
    @endpush

</x-app-layout>
