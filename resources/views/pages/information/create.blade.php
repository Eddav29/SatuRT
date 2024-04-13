<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <div class="p-6 rounded-xl bg-white-snow">
            {{-- Header --}}
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
                    <h1 class="text-2xl font-semibold">Buat Informasi</h1>
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
                    <input type="text" hidden name="penduduk_id" value="b5784e6c-d08a-452b-b3d6-4e54eee3f428">
                    {{-- Field Judul Informasi --}}
                    <div class="flex flex-col mt-5">
                        <label for="judul"
                            class="after:content-['*'] after:ml-0.5 after:text-red-500 font-semibold text-navy-night w-fit">Judul</label>
                        @error('judul_informasi')
                            <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                        @enderror
                        <input type="text" placeholder="Judul Informasi" name="judul_informasi" id="judul"
                            value="{{ old('judul_informasi') }}"
                            class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>

                    <div x-data="{ selected: '{{ old('jenis_informasi') == null ? 'Pilih Jenis Informasi' : old('jenis_informasi') }}' }">
                        {{-- Field Jenis Informasi --}}
                        <div class="flex flex-col mt-5">
                            <label for="jenis_informasi"
                                class="block font-semibold text-navy-night after:content-['*'] after:ml-0.5 after:text-red-500 w-fit">Jenis
                                Informasi</label>
                            @error('jenis_informasi')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror
                            <select id="jenis_informasi" name="jenis_informasi" required
                                class="placeholder:font-light invalid:ring-1 invalid:ring-red-500 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-300 focus:text-navy-night"
                                :class="selected === 'Pilih Jenis Informasi' ? 'text-gray-300' : 'text-navy-night'">
                                <option value="Pilih Jenis Informasi" @click="selected = 'Pilih Jenis Informasi'"
                                    x-bind:selected="selected === 'Pilih Jenis Informasi'">Pilih Jenis Informasi
                                </option>
                                <option value="Dokumentasi" @click="selected = 'Dokumentasi'"
                                    x-bind:selected="selected === 'Dokumentasi'">Dokumentasi</option>
                                <option value="Pengumuman" @click="selected = 'Pengumuman'"
                                    x-bind:selected="selected === 'Pengumuman'">Pengumuman</option>
                                <option value="Berita" @click="selected = 'Berita'"
                                    x-bind:selected="selected === 'Berita'">Berita</option>
                                <option value="Artikel" @click="selected = 'Artikel'"
                                    x-bind:selected="selected === 'Artikel'">Artikel</option>
                            </select>
                        </div>

                        {{-- Field File Upload --}}
                        <div>
                            <img alt="" id="preview-image" class="hidden">
                        </div>
                        <div class="flex flex-col mt-5" :class="selected === 'Pilih Jenis Informasi' ? 'hidden' : ''">
                            <label for="image_url" class="block font-semibold text-navy-night"
                                x-html="selected != 'Pengumuman' ? '<p>Thumbnail <span class=\'text-xs font-medium\'>(jpg, jpeg, png, svg, gif)</span></p>' : '<p>Lampiran</p>'"></label>
                            @error('thumbnail_url')
                                <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                            @enderror

                            <p id="preview-file" class="text-blue-500 py-3 hidden"></p>
                            <img alt="" id="preview-image" class="hidden">

                            <input
                                class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-secondary-500 bg-transparent bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-surface transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:me-3 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-e file:border-solid file:border-inherit file:bg-transparent file:px-3  file:py-[0.32rem] file:text-surface focus:border-primary focus:text-gray-700 focus:shadow-inset focus:outline-none"
                                type="file" id="file_input" name="thumbnail_url" onchange="previewImage()"
                                x-bind:accept="selected === 'Pengumuman' ? '' :
                                    'image/*'" />
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
                    <div class="mt-5 flex gap-x-5">
                        <button type="submit"
                            class="bg-azure-blue text-white-snow font-medium px-4 py-2 rounded-md flex justify-center items-center gap-x-3">
                            <x-heroicon-o-folder-arrow-down class="w-5 h-5" />
                            <p>Simpan</p>
                        </button>
                        <a href="{{ route('informasi.index') }}"
                            class="border border-navy-night/50 rounded-md px-4 py-2 flex justify-center items-center gap-x-3"><x-heroicon-o-arrow-uturn-left
                                class="w-5 h-5" />
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
</x-app-layout>
