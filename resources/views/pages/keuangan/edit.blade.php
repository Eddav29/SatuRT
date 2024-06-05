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
                    <h1 class="font-bold md:text-2xl text-xl">Edit keuangan</h1>
                </div>
            </section>
            {{-- End Header --}}

            {{-- Form --}}
            <section>
                <form action="{{ route('keuangan.update', $detailKeuangan->detail_keuangan_id) }}" method="POST"
                    enctype="multipart/form-data" class="px-5">
                    @csrf
                    @method('PUT')
                    {{-- Field Judul keuangan --}}
                    <div class="flex flex-col mt-5">
                        <label for="judul"
                            class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night w-fit">Judul</label>
                        @error('judul_keuangan')
                            <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                        @enderror
                        <input type="text" placeholder="Judul keuangan" name="judul" id="judul"
                            value="{{ $detailKeuangan->judul }}"
                            class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>

                    {{-- Field keuangan_id --}}
                    <div class="flex flex-col mt-5">
                        <label for="keuangan_id"
                            class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night w-fit">Keuangan ID</label>
                        @error('keuangan_id')
                            <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                        @enderror
                        <input type="hidden" placeholder="Keuangan id" name="keuangan_id" id="keuangan_id"
                            value="{{ $detailKeuangan->keuangan_id }}"
                            class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>

                    <div x-data="{ selected: '{{ $detailKeuangan->jenis_keuangan }}' }">
                        {{-- Field Jenis keuangan --}}
                        <div class="flex flex-col mt-5">
                            <label for="jenis_keuangan"
                                class="block font-semibold text-navy-night after:content-['*'] after:ml-0.5 after:text-red-500 w-fit">Jenis keuangan</label>
                            @error('jenis_keuangan')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror
                            <select id="jenis_keuangan" name="jenis_keuangan" required
                                class="placeholder:font-light invalid:ring-1 invalid:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-300 focus:text-navy-night"
                                x-model="selected">
                                <option value="Pilih Jenis keuangan">Pilih Jenis keuangan</option>
                                <option value="Pemasukan">Pemasukan</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                    </div>

                    <div x-data="{ selectedAsal: '{{ $detailKeuangan->asal_keuangan }}' }">
                        {{-- Field Asal keuangan --}}
                        <div class="flex flex-col mt-5">
                            <label for="asal_keuangan"
                                class="block font-semibold text-navy-night after:content-['*'] after:ml-0.5 after:text-red-500 w-fit">Asal keuangan</label>
                            @error('asal_keuangan')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror
                            <select id="asal_keuangan" name="asal_keuangan" required
                                class="placeholder:font-light invalid:ring-1 invalid:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-300 focus:text-navy-night"
                                x-model="selectedAsal">
                                <option value="Pilih Asal keuangan">Pilih Asal keuangan</option>
                                <option value="Donasi">Donasi</option>
                                <option value="Iuran Warga">Iuran Warga</option>
                                <option value="Kas Umum">Kas Umum</option>
                                <option value="Dana Darurat">Dana Darurat</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    {{-- Field Nominal keuangan --}}
                    <div class="flex flex-col mt-5">
                        <label for="nominal"
                            class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night w-fit">Nominal</label>
                        @error('nominal')
                            <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                        @enderror
                        <input type="text" placeholder="Nominal" name="nominal" id="nominal"
                            value="{{ $detailKeuangan->nominal }}"
                            class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>

                    {{-- Field Keterangan keuangan --}}
                    <div class="mt-5">
                        <label for="text-editor"
                            class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">Keterangan</label>
                        @error('isi_keuangan')
                            <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                        @enderror
                        <textarea id="text-editor" name="keterangan">{{ $detailKeuangan->keterangan }}</textarea>
                    </div>

                    {{-- Button --}}
                    <div class="mt-10 flex gap-x-5">
                        <button type="submit"
                            class="bg-azure-blue text-white-snow px-4 py-2 text-sm rounded-md flex justify-center items-center gap-x-3">
                            <p>Simpan</p>
                        </button>
                        <a href="{{ route('keuangan.index') }}"
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

</x-app-layout>
