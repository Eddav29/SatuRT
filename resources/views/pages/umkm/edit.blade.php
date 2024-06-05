<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    {{-- Content Start --}}
    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />
        <div class="p-6 rounded-xl bg-white-snow mt-5">
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
                    <h1 class="font-bold md:text-2xl text-xl">Edit UMKM</h1>
                </div>
            </section>

            <section>
                <form method="POST" action="{{ route('umkm.update', $umkm->umkm_id) }}" class="px-5"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="mt-5">
                            <label for="nik"
                                class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">NIK Pemilik Usaha</label>
                            <input
                                class="placeholder-gray-300 w-full rounded-md placeholder:text-xs border-gray-200 p-3 text-sm"
                                placeholder="35************" type="text" id="nik" name="nik" value="{{ $umkm->penduduk->nik }}" />
                            @error('nik')
                                <small class="form-text text-red-500">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mt-5">
                            <label for="nama_umkm"
                                class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">
                                Nama UMKM</label>
                            <input
                                class="placeholder-gray-300 w-full rounded-md border-gray-200 placeholder:text-xs p-3 text-sm "
                                placeholder="Nama UMKM" type="text" id="nama_umkm" name="nama_umkm"
                                value="{{ $umkm->nama_umkm }}" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-5">
                        <div>
                            <label for="jenis_umkm"
                                class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">
                                Jenis UMKM</label>
                            <select
                                class="form-control w-full rounded-md border-gray-200 placeholder:text-xs p-3 text-sm"
                                id="jenis_umkm" name="jenis_umkm" required>
                                <option class="hidden" value="{{ $umkm->jenis_umkm }}">
                                    {{ $umkm->jenis_umkm }}</option>
                                <option value="Makanan dan Minuman">Makanan & Minuman</option>
                                <option value="Pakaian">Pakaian</option>
                                <option value="Jasa">Jasa</option>
                                <option value="Peralatan">Peralatan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label for="alamat"
                                class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">
                                Alamat</label>
                            <input
                                class="placeholder-gray-300 w-full rounded-md border-gray-200 placeholder:text-xs p-3 text-sm"
                                placeholder="Alamat" type="text" id="alamat" name="alamat"
                                value="{{ $umkm->alamat }}" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-5">
                        <div>
                            <label for="nomor_telepon"
                                class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">
                                Nomor Telepon</label>
                            <input
                                class="placeholder-gray-300 w-full rounded-md border-gray-200 placeholder:text-xs p-3 text-sm"
                                placeholder="Nomor Telepon" type="text" id="nomor_telepon" name="nomor_telepon"
                                value="{{ $umkm->nomor_telepon }}" />
                        </div>
                        <div>
                            <label for="lokasi_url"
                                class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">
                                Lokasi URL</label>
                            <input
                                class="placeholder-gray-300 w-full rounded-md border-gray-200 placeholder:text-xs p-3 text-sm"
                                placeholder="Lokasi URL" type="text" id="lokasi_url" name="lokasi_url"
                                value="{{ $umkm->lokasi_url }}" />
                        </div>
                    </div>

                    <div class="mt-5">
                        <label for="status"
                            class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">Status
                            UMKM</label>
                        <select id="status" name="status"
                            class="placeholder-gray-300 w-full rounded-md border-gray-200 placeholder:text-xs p-3 text-sm">
                            <option class="hidden" value="{{ $umkm->status }}">{{ $umkm->status }}
                            </option>
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>

                    <div class="mt-5">
                        <div>
                            <x-input-label for="lisence_image_url" :value="__('Foto Surat Izin Usaha')" />
                            @isset($umkm->lisence_image_url)
                                <x-input-file name="lisence_image_url" :accept="$extension" :default="strpos($umkm->lisence_image_url, 'http') === false
                                    ? route('storage.lisence', $umkm->lisence_image_url)
                                    : $umkm->lisence_image_url" />
                            @else
                                <x-input-file name="lisence_image_url" :accept="$extension" />
                            @endisset
                        </div>
                    </div>

                    <div class="mt-5">
                        <div>
                            <x-input-label for="thumbnail_url" :value="__('Thumbnail')" />
                            @isset($umkm->thumbnail_url)
                                <x-input-file name="thumbnail_url" :accept="$extension" :default="strpos($umkm->thumbnail_url, 'http') === false
                                    ? route('public', $umkm->thumbnail_url)
                                    : $umkm->thumbnail_url" />
                            @else
                                <x-input-file name="thumbnail_url" :accept="$extension" />
                            @endisset
                        </div>
                    </div>

                    <div class="mt-5">
                        <label for="text-editor"
                            class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">Keterangan
                        </label>
                        @error('keterangan')
                            <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                        @enderror
                        <textarea id="text-editor" name="keterangan">{{ $umkm->keterangan }}</textarea>
                    </div>

                    <div class="mt-10 flex gap-x-5">
                        <button type="submit"
                            class="bg-azure-blue text-white-snow text-sm px-4 py-2 rounded-md flex justify-center items-center gap-x-3">
                            <p>Simpan</p>
                        </button>
                        <a href="{{ route('umkm.index') }}"
                            class="border border-navy-night/50 rounded-md px-4 py-2 text-sm flex justify-center items-center gap-x-3">
                            <p>Kembali</p>
                        </a>
                    </div>
                </form>
        </div>
        </section>
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
    {{-- Content End --}}
</x-app-layout>
