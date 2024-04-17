<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    {{-- Content Start --}}
    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 mt-3 rounded-xl bg-white-snow overflow-hidden">
            @if (session('success'))
                <div role="alert" class="rounded border-s-4 border-green-500 bg-white p-4">
                    <div class="flex items-start gap-4">
                        <span class="text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>

                        <div class="flex-1">
                            <strong class="block font-medium text-gray-900">Behasil</strong>

                            <p class="mt-1 text-sm text-gray-700">Data berhasil ditambahkan</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div role="alert" class="rounded border-s-4 border-red-500 bg-red-50 p-4">
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

            {{-- Table --}}
            <section>


                <div class="bg-blue-gray p-5 max-lg:mt-5 rounded-md">
                    <h1 class="text-2xl font-semibold">Tambahkan Pelaporan</h1>
                </div>

                <form method="POST" action="{{ url('umkm') }}" class="space-y-4">

                    <div class="mx-3 my-4 gap-5 flex max-lg:flex-col lg:flex-nowrap font-bold">
                        <div class="lg:w-1/2">
                            <div class="after:content-['*'] after:ml-0.5 after:text-red-500">NIK</div>
                            <input type="text" placeholder="Masukkan NIK" name="" id=""
                                class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                        </div>
                        <div class="lg:w-1/2">
                            <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Nama</div>
                            <input type="text" placeholder="Masukkan Nama" name="" id=""
                                class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                        </div>
                    </div>

                    <div class="mx-3 my-4 gap-5 flex max-lg:flex-col lg:flex-nowrap font-bold">
                        <div class="lg:w-1/2">
                            <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Tanggal</div>
                            <input type="date" name="" id=""
                                class="font-normal placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                        </div>
                        <div class="lg:w-1/2">
                            <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Jenis Laporan</div>
                            <select id="jenis_laporan" name="jenis_laporan"
                                class="font-normal  mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                                <option value="" selected disabled>Pilih Jenis Laporan</option>
                                <option value="pengaduan">Pengaduan</option>
                                <option value="kritik">Kritik</option>
                                <option value="saran">Saran</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="mx-3 my-3 font-bold">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Lampiran</div>
                        <label for="lisence_image_url" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 rounded-lg cursor-pointer bg-white-50 hover:bg-bray-100  hover:border-gray-100 hover:bg-gray-200">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-300 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <div id="lisence_image_url-container" class="hidden flex justify-center">
                                </div>
                                <p class="mb-2 text-sm text-gray-300 dark:text-gray-300"><span class="font-semibold">Unggah Foto</span></p>
                            </div>
                            <input id="lisence_image_url" type="file" class="hidden" onchange="renderFiles(this.files, 'lisence_image_url')" />
                        </label>
                    </div>

                    <div class="mx-3 my-3 font-bold ">
                        <label for="text-editor"
                            class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night ">Keterangan
                        </label>
                        @error('keterangan')
                            <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                        @enderror
                        <textarea name="description" id="text-editor"></textarea>
                    </div>

                    <div class="py-5">
                        <button type="submit"
                            class="inline-block w-full rounded-lg bg-blue-500 px-5 py-3 font-medium text-white sm:w-auto">
                            Laporkan
                        </button>
                        <a href="#" class="text-black border-2 py-3 px-5 rounded-lg mt-4">
                            Batalkan
                        </a>
                    </div>
                </form>
        </div>
        </section>
    </div>

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
        </script>
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
    {{-- Content End --}}
</x-app-layout>
