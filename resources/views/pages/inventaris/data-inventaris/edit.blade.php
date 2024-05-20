<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    {{-- Content Start --}}
    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />
        <div class="p-6 mt-3 rounded-xl bg-white-snow overflow-hidden">

            {{-- Form --}}
            <form method="POST" action="{{ route('inventaris.data-inventaris.update', $inventaris->inventaris_id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="bg-blue-gray p-5 max-lg:mt-5 rounded-md">
                    <h1 class="font-bold md:text-2xl text-xl">Edit inventaris</h1>
                </div>

                <section class="space-y-4">
                    <div class="mt-5 gap-5">
                        <div>
                            <label for="nama"
                                class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold">Nama
                                Inventaris</label>
                            <input type="text" placeholder="Masukkan Nama" name="nama_inventaris"
                                value="{{ $inventaris->nama_inventaris }}"
                                class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full text-sm placeholder:text-xs">
                        </div>
                    </div>

                    <div class="mt-5 gap-5 flex max-lg:flex-col lg:grid lg:grid-cols-2">
                        <div>
                            <label for="merk" class="font-semibold">Merk</label>
                            <input type="text" placeholder="Masukkan Merk" name="merk"
                                value="{{ $inventaris->merk }}"
                                class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full text-sm placeholder:text-xs">
                        </div>
                        <div>
                            <label for="warna" class="font-semibold">Warna</label>
                            <input type="text" placeholder="Masukkan Warna" name="warna"
                                value="{{ $inventaris->warna }}"
                                class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full text-sm placeholder:text-xs">
                        </div>
                    </div>

                    <div class="mt-5 gap-5 flex max-lg:flex-col lg:grid lg:grid-cols-2">
                        <div>
                            <label for="jumlah"
                                class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold">Jumlah</label>
                            <input type="text" placeholder="Masukkan Jumlah" name="jumlah"
                                value="{{ $inventaris->jumlah }}"
                                class="font-normal placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full text-sm placeholder:text-xs">
                        </div>
                        <div>
                            <label for="jenis"
                                class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold">Jenis</label>
                            <select name="jenis"
                                class="font-normal  mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                                <option value="" disabled>Pilih Jenis Inventaris</option>
                                <option value="ATK" {{ $inventaris->jenis === 'ATK' ? 'selected' : '' }}>ATK (Alat
                                    Tulis Kantor)</option>
                                <option value="Elektronik" {{ $inventaris->jenis === 'Elektronik' ? 'selected' : '' }}>
                                    Elektronik</option>
                                <option value="Furnitur" {{ $inventaris->jenis === 'Furnitur' ? 'selected' : '' }}>
                                    Furnitur</option>
                                <option value="Kendaraan" {{ $inventaris->jenis === 'Kendaraan' ? 'selected' : '' }}>
                                    Kendaraan</option>
                                <option value="Perlengkapan"
                                    {{ $inventaris->jenis === 'Perlengkapan' ? 'selected' : '' }}>Perlengkapan</option>
                                <option value="Lainnya" {{ $inventaris->jenis === 'Lainnya' ? 'selected' : '' }}>
                                    Lainnya</option>

                            </select>
                        </div>
                    </div>

                    <div class="mt-5 gap-5 flex max-lg:flex-col lg:grid">
                        <div>
                            <label for="sumber"
                                class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold">Sumber</label>
                            <select name="sumber"
                                class="font-normal  mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                                <option value="" disabled>Pilih Sumber Inventaris</option>
                                <option value="Bantuan" {{ $inventaris->sumber === 'Bantuan' ? 'selected' : '' }}>
                                    Bantuan</option>
                                <option value="Beli" {{ $inventaris->sumber === 'Beli' ? 'selected' : '' }}>Beli
                                </option>
                                <option value="Donasi" {{ $inventaris->sumber === 'Donasi' ? 'selected' : '' }}>Donasi
                                </option>
                                <option value="Hibah" {{ $inventaris->sumber === 'Hibah' ? 'selected' : '' }}>Hibah
                                </option>
                                <option value="Pinjaman" {{ $inventaris->sumber === 'Pinjaman' ? 'selected' : '' }}>
                                    Pinjaman</option>
                            </select>
                        </div>
                    </div>

                    {{-- Lampiran --}}
                    <div class="mx-3 my-3 font-bold">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Lampiran</div>
                        @if ($inventaris->foto_inventaris)
                            <label for="lisence_image_url" class="relative cursor-pointer">
                                <div class="w-full h-64 border-2 border-gray-300 rounded-lg cursor-pointer bg-white-50 hover:bg-bray-100 hover:border-gray-100 hover:bg-gray-200"
                                    ondrop="dropFile(event, 'lisence_image_url')" ondragover="allowDrop(event)">
                                    <img src="{{ asset('storage/images_storage/inventaris_images/' . $inventaris->foto_inventaris) }}"
                                        for="lisence_image_url"
                                        class="w-full h-full object-cover border-2 border-gray-300 rounded-lg cursor-pointer bg-white-50 hover:bg-bray-100 hover:border-gray-100 hover:bg-gray-200">
                                    <div id="lisence_image_url-container" class="w-full h-full overflow-hidden hidden">
                                    </div>
                                </div>
                            </label>
                        @endif


                        <div class="flex flex-col mt-5" :class="selected === 'Pilih Jenis Informasi' ? 'hidden' : ''">
                            @error('foto_inventaris')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror

                            <p id="preview-file" class="text-blue-500 py-3 hidden"></p>
                            <img alt="" id="preview-image" class="hidden">

                            <input
                                class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-secondary-500 bg-transparent bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-surface transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:me-3 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-e file:border-solid file:border-inherit file:bg-transparent file:px-3  file:py-[0.32rem] file:text-surface focus:border-primary focus:text-gray-700 focus:shadow-inset focus:outline-none"
                                type="file" id="file_input" name="foto_inventaris" onchange="previewImage()"
                                x-bind:accept="selected === 'Pengumuman' ? '' :
                                    'image/*'" />
                        </div>
                        <div>
                            <img alt="" id="preview-image" class="hidden">
                        </div>
                    </div>


                    {{-- Keterangan --}}
                    <div class="mx-3 my-3">
                        <label for="text-editor"
                            class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">Keterangan
                        </label>
                        @error('keterangan')
                            <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                        @enderror
                        <textarea id="text-editor" name="keterangan">{{ $inventaris->keterangan }}</textarea>
                    </div>

                    {{-- Button --}}
                    <div class="mx-3 my-3">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-800 text-white py-2 px-4 rounded mt-4 mr-2">
                            Simpan
                        </button>
                        <a href="#" onclick="window.history.back()"
                            class="text-black border-2 py-3 px-5 rounded-lg mt-4">
                            Batalkan
                        </a>

                    </div>
                </section>
        </div>
        </form>
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
