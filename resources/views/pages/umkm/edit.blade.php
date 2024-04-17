<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    {{-- Content Start --}}
    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />
        <div class="p-6 rounded-xl bg-white-snow">
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
                    <h1 class="text-2xl font-semibold">Edit UMKM</h1>
                </div>
            </section>

            <section>
                <form method="POST" action="{{ url('umkm') }}" class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="sr-only " for="pemilik"></label>
                            <p
                                class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">
                                Pemilik</p>
                            <select class="form-control w-full rounded-lg border-gray-200 p-3 text-sm" id="penduduk_id"
                                name="penduduk_id" required>
                                <option class="hidden" value="{{ old('pemilik', $umkm->penduduk->nama) }}">
                                    {{ $umkm->penduduk->nama }}</option>
                                @foreach ($penduduk as $item)
                                    <option value="{{ $item->penduduk_id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('penduduk_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        {{-- <input type="hidden" id="umkm_id" name="umkm_id">
            
            <script>
              document.addEventListener('DOMContentLoaded', function() {
                  var chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                  var randomString = '';
                  for (var i = 0; i < 36; i++) {
                      var randomIndex = Math.floor(Math.random() * chars.length);
                      randomString += chars[randomIndex];
                  }
                  document.getElementById('umkm_id').value = randomString;
              });
          </script> --}}

                        <div>
                            <label class="sr-only" for="nama_umkm"></label>
                            <p
                                class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">
                                Nama UMKM</p>
                            <input class="placeholder-gray-300 w-full rounded-lg border-gray-200 p-3 text-sm"
                                placeholder="Nama UMKM" type="text" id="nama_umkm"
                                value="{{ old('nama_umkm', $umkm->nama_umkm) }}" required />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="sr-only" for="jenis_umkm"></label>
                            <p
                                class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">
                                Jenis UMKM</p>
                            <select class="form-control w-full rounded-lg border-gray-200 p-3 text-sm" id="jenis_umkm"
                                name="jenis_umkm" required>
                                <option class="hidden" value="{{ old('jenis_umkm', $umkm->jenis_umkm) }}">
                                    {{ $umkm->jenis_umkm }}</option>
                                <option value="Makanan">Makanan</option>
                                <option value="Minuman">Minuman</option>
                                <option value="Pakaian">Pakaian</option>
                                <option value="Jasa">Jasa</option>
                                <option value="Peralatan">Peralatan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>



                        <div>
                            <label class="sr-only" for="alamat"></label>
                            <p
                                class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">
                                Alamat</p>
                            <input class="placeholder-gray-300 w-full rounded-lg border-gray-200 p-3 text-sm"
                                placeholder="Alamat" type="text" id="alamat"
                                value="{{ old('alamat', $umkm->alamat) }}" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="sr-only" for="nomor_telepon"></label>
                            <p
                                class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">
                                Nomor Telepon</p>
                            <input class="placeholder-gray-300 w-full rounded-lg border-gray-200 p-3 text-sm"
                                placeholder="Nomor Telepon" type="text" id="nomor_telepon"
                                value="{{ old('nomor_telepon', $umkm->nomor_telepon) }}" />
                        </div>

                        <div>
                            <label class="sr-only" for="lokasi_url"></label>
                            <p
                                class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">
                                Lokasi URL</p>
                            <input class="placeholder-gray-300 w-full rounded-lg border-gray-200 p-3 text-sm"
                                placeholder="Lokasi URL" type="text" id="lokasi_url"
                                value="{{ old('lokasi_url', $umkm->lokasi_url) }}" />
                        </div>
                    </div>
                    <div>
                        <label for="status"
                            class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">Status
                            UMKM</label>
                        <select id="status"
                            class="placeholder-gray-300 w-full rounded-lg border-gray-200 p-3 text-sm">
                            <option class="hidden" value="{{ old('status', $umkm->status) }}">{{ $umkm->status }}
                            </option>
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>

                    <p class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">
                        Surat Izin Usaha</p>
                    <div class="flex items-center justify-center w-full">
                        <label for="lisence_image_url"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 rounded-lg cursor-pointer bg-white-50 hover:bg-bray-100  hover:border-gray-100 hover:bg-gray-200">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-300 dark:text-gray-300" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <div id="lisence_image_url-container" class="hidden flex justify-center">
                                    <!-- Preview container for license image -->
                                </div>
                                <p class="mb-2 text-sm text-gray-300 dark:text-gray-300"><span
                                        class="font-semibold">Unggah Surat Izin Usaha</span></p>
                            </div>
                            <input id="lisence_image_url" type="file" class="hidden"
                                onchange="renderFiles(this.files, 'lisence_image_url')" />
                        </label>
                    </div>
                    <p class="py-2 after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">
                        Thumbnail</p>
                    <div class="flex items-center justify-center w-full">
                        <label for="thumbnail_url"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 rounded-lg cursor-pointer bg-white-50 dark:hover:bg-bray-100  hover:border-gray-100 hover:bg-gray-200">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-300 dark:text-gray-300" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <div id="thumbnail_url-container" class="hidden flex justify-center">
                                    <!-- Preview container for thumbnail -->
                                </div>
                                <p class="mb-2 text-sm text-gray-300 dark:text-gray-300"><span
                                        class="font-semibold">Unggah Thumbnail</span></p>
                            </div>
                            <input id="thumbnail_url" type="file" class="hidden"
                                onchange="renderFiles(this.files, 'thumbnail_url')" />
                        </label>
                    </div>

                    <div>
                        <label for="text-editor"
                            class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night">Keterangan
                        </label>
                        @error('keterangan')
                            <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                        @enderror
                        <textarea id="text-editor" name="keterangan">{{ old('keterangan') }}</textarea>
                    </div>



                    <div class="py-14">
                        <button type="submit"
                            class="inline-block w-full rounded-lg bg-blue-500 px-5 py-3 font-medium text-white sm:w-auto">
                            Simpan
                        </button>
                    </div>
                </form>
        </div>
        </section>
    </div>

    @push('scripts')
        <script>
            function allowDrop(event) {
                event.preventDefault();
            }

            function dropFile(event, containerId) {
                event.preventDefault();
                const files = event.dataTransfer.files;
                renderFiles(files, containerId);
            }

            function renderFiles(files, containerId) {
                const filePreviewContainer = document.getElementById(containerId + '-container');
                const fileInput = document.getElementById(containerId);

                // Clear previous previews
                filePreviewContainer.innerHTML = '';

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();
                    const filePreviewId = containerId + '-preview-' + i;

                    reader.onload = function(e) {
                        const filePreview = document.createElement('img');
                        filePreview.src = e.target.result;
                        filePreview.id = filePreviewId;
                        filePreview.classList.add('w-64', 'h-auto');
                        filePreviewContainer.appendChild(filePreview);
                    }

                    reader.readAsDataURL(file);
                }

                // Show the preview container
                filePreviewContainer.classList.remove('hidden');
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
