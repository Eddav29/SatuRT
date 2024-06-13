<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    {{-- Content Start --}}
    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 mt-3 rounded-xl bg-white-snow overflow-hidden">

            {{-- Table --}}
            <section>
                <div class="bg-blue-gray p-5 max-lg:mt-5 rounded-md">
                    <h1 class="font-bold md:text-2xl text-xl">Tambahkan Pelaporan</h1>
                </div>

                <form method="POST" action="{{ route('pelaporan.store') }}" enctype="multipart/form-data" class="px-5">
                    @csrf

                    <div class="mt-5 gap-5">
                        <div>
                            <label for="keperluan"
                                class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold">Judul
                                Laporan</label>
                            @error('keperluan')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror
                            <input type="text" placeholder="Masukkan Judul Laporan" name="keperluan"
                                class="placeholder:font-normal required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full text-sm placeholder:text-xs">
                        </div>
                    </div>

                    <div class="mt-5 gap-5 flex max-lg:flex-col lg:grid lg:grid-cols-2">
                        <div>
                            <label for="nik"
                                class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold">NIK</label>
                            @error('nik')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror
                            <input type="text" placeholder="Masukkan NIK"
                                value="{{ Auth::user()->penduduk->nik ?? '' }}" disabled
                                class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full text-sm placeholder:text-xs">
                        </div>
                        <div>
                            <label for="nama"
                                class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold">Nama</label>
                            @error('nama')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror
                            <input type="text" placeholder="Masukkan Nama"
                                value="{{ Auth::user()->penduduk->nama ?? '' }}" disabled
                                class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full text-sm placeholder:text-xs">
                        </div>
                    </div>

                    <div class="mt-5 gap-5 flex max-lg:flex-col lg:grid lg:grid-cols-2">
                        <div>
                            <label for="tanggal"
                                class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold">Tanggal</label>
                            @error('tanggal')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror
                            <input type="date" name="accepted_at" id="accepted_at"
                                value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                class="font-normal placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full text-sm placeholder:text-xs">
                        </div>
                        <div>
                            <label for="jenis_laporan"
                                class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold">Jenis
                                Laporan</label>
                            @error('jenis_pelaporan')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror
                            <select id="jenis_pelaporan" name="jenis_pelaporan"
                                class="font-normal  mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                                <option value="" selected disabled>Pilih Jenis Laporan</option>
                                @foreach ($form['jenis_pelaporan'] as $jenis_pelaporan)
                                    <option value="{{ $jenis_pelaporan }}">
                                        {{ $jenis_pelaporan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Field File Upload --}}
                    <div class="font-semibold mt-5">Lampiran</div>

                    <div class="mt-5">
                        <div>
                            @error('image_url')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror
                            <x-input-file name="image_url" :accept="$extension" />
                        </div>
                    </div>

                    {{-- Keterangan --}}
                    <div class="mt-5">
                        <label for="text-editor"
                            class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">Keterangan
                        </label>
                        @error('keterangan')
                            <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                        @enderror
                        <textarea id="text-editor" name="keterangan"></textarea>
                    </div>

                    {{-- Button --}}
                    <div class="mt-10 flex gap-x-5">
                        <button type="submit"
                            class="bg-azure-blue text-white-snow text-sm px-4 py-2 rounded-md flex justify-center items-center gap-x-3">
                            <p>Laporkan</p>
                        </button>
                        <a href="{{ route('pelaporan.index') }}"
                            class="border border-navy-night/50 rounded-md px-4 py-2 text-sm flex justify-center items-center gap-x-3">
                            <p>Kembali</p>
                        </a>
                    </div>
                </form>
            </section>
        </div>
    </div>

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
            const previewImage = () => {
                const fileInput = document.querySelector('#file_input');
                const imagePreview = document.querySelector('#preview-image');
                const filePreview = document.querySelector('#preview-file');

                if (fileInput.files && fileInput.files[0]) {
                    if (fileInput.files[0].type !== 'application/pdf') {
                        !filePreview.classList.contains('hidden') ? filePreview.classList.add('hidden') : '';
                        imagePreview.classList.remove('hidden');
                        imagePreview.classList.add('inline-block', 'py-5');
                    } else {
                        !imagePreview.classList.contains('hidden') ? imagePreview.classList.add('hidden') : '';
                        filePreview.textContent = fileInput.files[0].name;
                        filePreview.classList.remove('hidden');
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
        </script>
    @endpush
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
    {{-- Content End --}}
</x-app-layout>
