<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 rounded-xl bg-white-snow">
            {{-- Header --}}
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
                    <h1 class="font-bold md:text-2xl text-xl">Buat Informasi</h1>
                </div>
            </section>
            {{-- End Header --}}

            {{-- Alert --}}
            @if (session('error'))
                <div role="alert" class="rounded border-s-4 border-red-500 bg-red-50 p-4 my-8">
                    <div class="flex items-center gap-2 text-red-800">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd"
                                d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" />
                        </svg>

                        <strong class="block font-medium"> Terjadi Kesalahan </strong>
                    </div>

                    <p class="mt-2 text-sm text-red-700">
                        {{ session('error') }}
                    </p>
                </div>
            @endif
            {{-- End Alert --}}

            {{-- Form --}}
            <section>
                <form action="{{ route('informasi.store') }}" method="POST" enctype="multipart/form-data"
                    class="px-5">
                    @csrf
                    {{-- Field Judul Informasi --}}
                    <div class="flex flex-col mt-5">
                        <label for="judul"
                            class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night w-fit">Judul</label>
                        @error('judul_informasi')
                            <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                        @enderror
                        <input type="text" placeholder="Judul Informasi" name="judul_informasi" id="judul"
                            value="{{ old('judul_informasi') }}"
                            class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 placeholder:text-xs text-sm">
                    </div>

                    <div x-data="{ selected: '{{ old('jenis_informasi') ?? 'Pilih Jenis Informasi' }}' }">
                        {{-- Field Jenis Informasi --}}
                        <div class="flex flex-col mt-5">
                            <label for="jenis_informasi"
                                class="block font-semibold text-navy-night after:content-['*'] after:ml-0.5 after:text-red-500 w-fit">Jenis
                                Informasi</label>
                            @error('jenis_informasi')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror
                            <select id="jenis_informasi"
                                name="jenis_informasi" required
                                class="placeholder:font-light invalid:ring-1 invalid:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-navy-night text-sm">
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
                        <div class="flex flex-col mt-5">
                            <label for="image_url" class="block font-semibold text-navy-night" id="file-label">
                                <div x-show="selected !== 'Pengumuman' && selected !== 'Dokumentasi Rapat'">
                                    <p class="after:content-['*'] after:ml-0.5 after:text-red-500">Thumbnail</p>
                                </div>
                                <div x-show="selected === 'Pengumuman' || selected === 'Dokumentasi Rapat'">
                                    <p>Lampiran</p>
                                </div>
                            </label>

                            <div id="preview-file" class="text-blue-500 py-3 hidden"></div>
                            <img alt="" id="preview-image" class="hidden">

                            <div x-show="selected !== 'Pengumuman' && selected !== 'Dokumentasi Rapat'">
                                <x-input-file name="images" accept="png,jpg,jpeg,webp" />
                            </div>

                            <div x-show="selected === 'Pengumuman' || selected === 'Dokumentasi Rapat'">
                                <x-input-file name="files" />
                            </div>

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
                        <textarea id="text-editor" name="isi_informasi">{{ old('isi_informasi') }}</textarea>
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
                {{-- End Form --}}
            </section>
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
                    uploadUrl: "{{ route('file.upload', ['_token' => csrf_token()]) }}",
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

            
        </script>
    @endpush
</x-app-layout>
