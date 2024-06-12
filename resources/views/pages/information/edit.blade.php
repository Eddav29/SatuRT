<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />
        <div class="p-6 rounded-xl bg-white-snow mt-5">
            {{-- Header --}}
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
                    <h1 class="font-bold md:text-2xl text-xl">Edit Informasi</h1>
                </div>
            </section>
            {{-- End Header --}}

            {{-- Form --}}
            <section>
                <form action="{{ route('informasi.update', $information->informasi_id) }}" method="POST"
                    enctype="multipart/form-data" class="px-5">
                    @csrf
                    @method('PUT')
                    {{-- Field Judul Informasi --}}
                    <div class="flex flex-col mt-5">
                        <label for="judul"
                            class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night w-fit">Judul</label>
                        @error('judul_informasi')
                            <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                        @enderror
                        <input type="text" placeholder="Judul Informasi" name="judul_informasi" id="judul"
                            value="{{ $information->judul_informasi }}"
                            class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>

                    <div x-data="{ selected: '{{ $information->jenis_informasi }}' }">
                        {{-- Field Jenis Informasi --}}
                        <div class="flex flex-col mt-5">
                            <label for="jenis_informasi"
                                class="block font-semibold text-navy-night after:content-['*'] after:ml-0.5 after:text-red-500 w-fit">Jenis
                                Informasi</label>
                            @error('jenis_informasi')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror
                            <select id="jenis_informasi" name="jenis_informasi" required
                                class="placeholder:font-light invalid:ring-1 invalid:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-navy-night focus:text-navy-night"
                                x-on:change="document.querySelector('input[name=files]').value = ''; document.querySelector('input[name=images]').value = '';">
                                <option value="Pilih Jenis Informasi" @click="selected = 'Pilih Jenis Informasi'"
                                    x-bind:selected="selected === 'Pilih Jenis Informasi'">Pilih Jenis Informasi
                                </option>
                                @foreach ($informationTypes as $informationType)
                                    <option value="{{ $informationType }}" @click="selected = '{{ $informationType }}'"
                                        x-bind:selected="selected === '{{ $informationType }}'">{{ $informationType }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Field File Upload --}}
                        <div class="flex flex-col mt-5" :class="selected === 'Pilih Jenis Informasi' ? 'hidden' : ''">
                            <div x-show="selected !== 'Pengumuman' && selected !== 'Dokumentasi Rapat'">
                                <p class="after:content-['*'] after:ml-0.5 after:text-red-500">Thumbnail</p>
                            </div>
                            <div x-show="selected === 'Pengumuman' || selected === 'Dokumentasi Rapat'">
                                <p>Lampiran</p>
                            </div>

                            @if ($information->thumbnail_url !== null)
                                @if ($information->jenis_informasi !== 'Pengumuman' && $information->jenis_informasi !== 'Dokumentasi Rapat')
                                    <div x-show="selected !== 'Pengumuman' && selected !== 'Dokumentasi Rapat'">
                                        <x-input-file name="images" accept="png,jpg,jpeg,webp" :default="strpos($information->thumbnail_url, 'http') === false
                                            ? route('public', $information->thumbnail_url)
                                            : $information->thumbnail_url"
                                            x-ref="images" />
                                    </div>

                                    <div x-show="selected === 'Pengumuman' || selected === 'Dokumentasi Rapat'">
                                        <x-input-file name="files" />
                                    </div>
                                @else
                                    <div x-show="selected === 'Pengumuman' || selected === 'Dokumentasi Rapat'">
                                        <x-input-file name="files" :default="strpos($information->thumbnail_url, 'http') === false
                                            ? route('storage.announcement', $information->thumbnail_url)
                                            : $information->thumbnail_url" x-ref="files" />
                                    </div>

                                    <div x-show="selected !== 'Pengumuman' && selected !== 'Dokumentasi Rapat'">
                                        <x-input-file name="images" accept="png,jpg,jpeg,webp" />
                                    </div>
                                @endif
                            @else
                                <div x-show="selected !== 'Pengumuman' && selected !== 'Dokumentasi Rapat'">
                                    <x-input-file name="images" accept="png,jpg,jpeg,webp" />
                                </div>

                                <div x-show="selected === 'Pengumuman' || selected === 'Dokumentasi Rapat'">
                                    <x-input-file name="files" />
                                </div>
                            @endif

                        </div>
                    </div>

                    {{-- Field Isi Informasi --}}
                    <div class="mt-5">
                        <label for="text-editor"
                            class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">Isi
                            Informasi</label>
                        @error('isi_informasi')
                            <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                        @enderror
                        <textarea id="text-editor" name="isi_informasi">{{ $information->isi_informasi }}</textarea>
                    </div>

                    {{-- Button --}}
                    <div class="mt-10 flex gap-x-5">
                        <button type="submit"
                            class="bg-azure-blue text-white-snow text-sm px-4 py-2 rounded-md flex justify-center items-center gap-x-3">
                            <p>Simpan</p>
                        </button>
                        <a href="{{ route('informasi.index') }}"
                            class="border border-navy-night/50 rounded-md px-4 py-2 text-sm flex justify-center items-center gap-x-3">
                            <p>Kembali</p>
                        </a>
                    </div>
                </form>
            </section>
            {{-- End Form --}}
        </div>
    </div>

    @push('styles')
        <style>
            .ck-editor__editable_inline {
                min-height: 300px;
                padding: 3rem;
            }

            .ck-content h2 {
                display: block;
                font-size: 1.5em;
                font-weight: bold;
            }

            .ck-content h3 {
                display: block;
                font-size: 1.33em;
                font-weight: bold;
            }

            .ck-content h4 {
                display: block;
                font-size: 1.17em;
                font-weight: bold;
            }

            .ck-content ol {
                display: block;
                list-style-type: decimal;
                padding-left: 40px;
            }

            .ck-content ul {
                display: block;
                list-style-type: disc;
                padding-left: 40px;
            }

            .ck-content a {
                color: rgb(59 130 246);
                text-decoration: underline;
                background-color: transparent;
            }

            .ck-content blockquote {
                padding: 1rem;
                margin: 1rem 0;
                border-left: 4px solid rgb(209 213 219);
            }

            .ck-content table {
                table-layout: auto;
                width: 100%;
                font-size: 0.875rem;
                line-height: 1.25rem;
                text-align: left;
                color: #0B1215;
            }

            .ck-content table th {
                background-color: rgb(229 231 235);
                padding: 0.75rem;
                border: 1px solid rgb(209 213 219);
            }

            .ck-content table td {
                border: 1px solid rgb(209 213 219);
                padding: 0.75rem;
            }

            .ck-content blockquote p {
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
        <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/super-build/ckeditor.js"></script>
        <script>
            CKEDITOR.ClassicEditor.create(document.getElementById("text-editor"), {
                ckfinder: {
                    uploadUrl: "{{ route('file.upload', ['_token' => csrf_token()]) }}"
                },
                toolbar: {
                    items: [
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript',
                        'removeFormat', '|',
                        'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        'link', 'uploadImage', 'blockQuote', 'insertTable',
                        '|',
                        'specialCharacters', 'horizontalLine', '|'
                    ],
                    shouldNotGroupWhenFull: true
                },
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                placeholder: 'Tuliskan sesuatu...',
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                fontSize: {
                    options: [10, 12, 14, 'default', 18, 20, 22],
                    supportAllValues: true
                },
                removePlugins: [
                    'AIAssistant',
                    'CKBox',
                    'CKFinder',
                    'EasyImage',
                    'MultiLevelList',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    'MathType',
                    'SlashCommand',
                    'Template',
                    'DocumentOutline',
                    'FormatPainter',
                    'TableOfContents',
                    'PasteFromOfficeEnhanced',
                    'CaseChange'
                ]
            });

            const previewFile = () => {
                const fileInput = document.querySelector('#file_input');
                const oldFilePreview = document.querySelector('#old-preview-container');
                const fileType = fileInput.files[0].type;
                const imagePreview = document.querySelector('#preview-image');
                const filePreview = document.querySelector('#preview-file');

                if (fileInput.files && fileInput.files[0]) {
                    if (fileType.includes('image')) {
                        !filePreview.classList.contains('hidden') ? filePreview.classList.add('hidden') : '';
                        imagePreview.classList.remove('hidden');
                        if (oldFilePreview) {
                            oldFilePreview.parentNode.removeChild(oldFilePreview); // Remove oldFilePreview if exists
                        }
                        imagePreview.classList.add('inline-block');
                    } else {
                        !imagePreview.classList.contains('hidden') ? imagePreview.classList.add('hidden') : '';
                        filePreview.innerHTML = fileUploadPreviewContainer(fileInput.files[0].name, fileType);
                        filePreview.classList.remove('hidden');
                        if (oldFilePreview) {
                            oldFilePreview.parentNode.removeChild(oldFilePreview); // Remove oldFilePreview if exists
                        }
                    }
                }


                if (fileInput.files[0].type !== 'application/pdf') {
                    const oFReader = new FileReader();
                    oFReader.readAsDataURL(fileInput.files[0]);

                    oFReader.onload = function(oFREvent) {
                        imagePreview.src = oFREvent.target.result;
                    }
                }
            }

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

            const fileUploadPreviewContainer = (fileName, fileType) => {
                const icon = () => {
                    if (fileType.includes('.document')) {
                        return docsIcon();
                    } else if (fileType.includes('.sheet')) {
                        return sheetIcon();
                    } else if (fileType.includes('pdf')) {
                        return pdfIcon();
                    } else {
                        return '';
                    }
                }

                return `<div class="flex gap-x-2 items-center">
                                ${icon()}
                                <div class="flex flex-col" id="preview-file-container">
                                    <p class="text-blue-500 py-3 text-sm font-light">${fileName}</p>
                                </div>
                            </div>`
            }

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
        </script>
    @endpush
</x-app-layout>
