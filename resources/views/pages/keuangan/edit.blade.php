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
                <form action="{{ route('keuangan.update', $detailKeuangan->keuangan_id) }}" method="POST"
                    enctype="multipart/form-data" class="px-5">
                    @csrf
                    @method('PUT')
                    <input type="text" hidden name="penduduk_id" value="b5784e6c-d08a-452b-b3d6-4e54eee3f428">
                    {{-- Field Judul keuangan --}}
                    <div class="flex flex-col mt-5">
                        <label for="judul"
                            class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night w-fit">Judul</label>
                        @error('judul_keuangan')
                            <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                        @enderror
                        <input type="text" placeholder="Judul keuangan" name="judul_keuangan" id="judul"
                            value="{{ $detailKeuangan->judul }}"
                            class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>

                    <div x-data="{ selected: '{{ $detailKeuangan->jenis_keuangan }}' }">
                        {{-- Field Jenis keuangan --}}
                        <div class="flex flex-col mt-5">
                            <label for="jenis_keuangan"
                                class="block font-semibold text-navy-night after:content-['*'] after:ml-0.5 after:text-red-500 w-fit">Jenis
                                keuangan</label>
                            @error('jenis_keuangan')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror
                            <select id="jenis_keuangan" name="jenis_keuangan" required
                                class="placeholder:font-light invalid:ring-1 invalid:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-300 focus:text-navy-night"
                                :class="selected === 'Pilih Jenis keuangan' ? 'text-gray-300' : 'text-navy-night'">
                                <option value="Pilih Jenis keuangan" @click="selected = 'Pilih Jenis keuangan'"
                                    x-bind:selected="selected === 'Pilih Jenis keuangan'">Pilih Jenis keuangan
                                </option>
                                <option value="Pemasukan" @click="selected = 'Pemasukan'"
                                    x-bind:selected="selected === 'Pemasukan'">Pemasukan</option>
                                <option value="Pengeluaran" @click="selected = 'Pengeluaran'"
                                    x-bind:selected="selected === 'Pengeluaran'">Pengeluaran</option>
                            </select>
                        </div>
                    </div>

                    <div x-data="{ selected: '{{ $detailKeuangan->asal_keuangan }}' }">
                        {{-- Field Asal keuangan --}}
                        <div class="flex flex-col mt-5">
                            <label for="jenis_keuangan"
                                class="block font-semibold text-navy-night after:content-['*'] after:ml-0.5 after:text-red-500 w-fit">Asal
                                keuangan</label>
                            @error('jenis_keuangan')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror
                            <select id="jenis_keuangan" name="jenis_keuangan" required
                                class="placeholder:font-light invalid:ring-1 invalid:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-300 focus:text-navy-night"
                                :class="selected === 'Pilih Jenis keuangan' ? 'text-gray-300' : 'text-navy-night'">
                                <option value="Pilih Jenis keuangan" @click="selected = 'Pilih Asal keuangan'"
                                    x-bind:selected="selected === 'Pilih Jenis keuangan'">Pilih Asal keuangan
                                </option>
                                <option value="Donasi" @click="selected = 'Donasi'"
                                    x-bind:selected="selected === 'Donasi'">Donasi</option>
                                <option value="Iuran Warga" @click="selected = 'Iuran Warga'"
                                    x-bind:selected="selected === 'Iuran Warga'">Iuran Warga</option>
                                <option value="Kas Umum" @click="selected = 'Kas Umum'"
                                    x-bind:selected="selected === 'Kas Umum'">Kas Umum</option>
                                <option value="Dana Darurat" @click="selected = 'Dana Darurat'"
                                    x-bind:selected="selected === 'Dana Darurat'">Dana Darurat</option>
                                <option value="Lainnya" @click="selected = 'Lainnya'"
                                    x-bind:selected="selected === 'Lainnya'">Lainnya</option>
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
                            class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">Keterangan
                        </label>
                        @error('isi_keuangan')
                            <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                        @enderror
                        <textarea id="text-editor" name="isi_keuangan">{{ $detailKeuangan->keterangan }}</textarea>
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
        <script src="https://cdn.ckeditor.com/ckeditor5/41.3.0/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create(document.querySelector('#text-editor'), {
                    ckfinder: {
                        uploadUrl: "{{ route('file.upload', ['_token' => csrf_token()]) }}"
                    },
                })
                .catch(error => {
                    console.error(error);
                });


            document.getElementById('jenis_keuangan').addEventListener('change', () => {
                document.getElementById('old-preview-container').remove();
            });

            const previewFile = () => {
                const fileInput = document.querySelector('#file_input');
                const filePreview = document.querySelector('#preview-file');
                const filePreviewContainer = document.querySelector('#preview-file-container');
                const imagePreview = document.querySelector('#preview-image');
                const previewContainer = document.querySelector('#preview-container');
                const oldPreviewContainer = document.querySelector('#old-preview-container');

                if (fileInput.files && fileInput.files[0]) {
                    if (oldPreviewContainer) {
                        if (imagePreview) {
                            imagePreview.classList.remove('hidden');
                            imagePreview.classList.add('inline-block', 'py-5');
                        } else if (filePreview) {
                            filePreviewContainer.innerHTML =
                                `<p class="text-blue-500 py-3 text-sm font-light">${fileInput.files[0].name}</p>`;
                        }
                    } else {
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
                }

                const oFReader = new FileReader();
                oFReader.readAsDataURL(fileInput.files[0]);

                if (fileInput.files[0].type !== 'application/pdf') {
                    oFReader.onload = function(oFREvent) {
                        imagePreview.src = oFREvent.target.result;
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
