<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    {{-- Content Start --}}
    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" /> 
        <div class="rounded-lg bg-white px-6 py-0 overflow-hidden mt-5">
            {{-- Information Details --}}
            <section>
                <div class="py-6">
                    <p
                        class="text-[20px] uppercase tracking-wide  py-4 px-4 bg-blue-100 text-left rounded-xl font-semibold text-navy-night">
                        DETAIL DATA UMKM</p>

                </div>
                <form method="POST" action="{{ url('umkm') }}" class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="sr-only " for="pemilik"></label>
                            <p class="py-2 font-semibold text-navy-night">Pemilik</p>
                            <p>{{ $umkm->penduduk->nama }}</p>
                            @error('penduduk_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror

                        </div>


                        <input type="hidden" id="umkm_id" name="umkm_id">

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
                        </script>

                        <div>
                            <label class="sr-only" for="nama_umkm"></label>
                            <p class="py-2 font-semibold text-navy-night">Nama UMKM</p>
                            <p>{{ $umkm->nama_umkm }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="sr-only" for="jenis_umkm"></label>
                            <p class="py-2 font-semibold text-navy-night">Jenis UMKM</p>
                            <p>{{ $umkm->jenis_umkm }}</p>
                        </div>



                        <div>
                            <label class="sr-only" for="alamat"></label>
                            <p class="py-2 font-semibold text-navy-night">Alamat</p>
                            <p>{{ $umkm->alamat }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="sr-only" for="nomor_telepon"></label>
                            <p class="py-2 font-semibold text-navy-night">Nomor Telepon</p>
                            <p>{{ $umkm->nomor_telepon }}</p>
                        </div>

                        <div>
                            <label class="sr-only" for="lokasi_url"></label>
                            <p class="py-2 font-semibold text-navy-night">Lokasi URL</p>
                            <p>{{ $umkm->lokasi_url }}</p>
                        </div>
                    </div>
                    <div>
                        <label for="status" class="py-2 font-semibold text-navy-night">Status UMKM</label>
                        <p>{{ $umkm->status }}</p>
                    </div>

                    <p class="py-2 font-semibold text-navy-night">Surat Izin Usaha</p>
                    <div class="flex items-center justify-center w-full">
                        <label for="lisence_image_url"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 rounded-lg cursor-not-allowed bg-white">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <div id="lisence_image_url-container" class="hidden flex justify-center">
                                    <!-- Preview license_image_url -->
                                </div>

                            </div>
                        </label>
                    </div>
                    <p class="py-2 font-semibold text-navy-night">Thumbnail</p>
                    <div class="flex items-center justify-center w-full">
                        <label for="thumbnail_url"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 rounded-lg cursor-not-allowed bg-white">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <div id="thumbnail_url-container" class="hidden flex justify-center">
                                    <!-- Preview thumbnail-->
                                </div>
                            </div>
                        </label>
                    </div>


                    <div class="flex flex-col">
                        <label for="text-editor" class=" font-semibold text-navy-night">Keterangan
                        </label>
                        @error('keterangan')
                            <small class="text-red-500 text-xs py-3">{{ $message }}</small>
                        @enderror
                        <p>{{ $umkm->keterangan }}</p>
                    </div>



                    <div class="py-14">
                        <button type="submit"
                            class="inline-block w-full rounded-lg bg-blue-500 px-5 py-3 font-medium text-white sm:w-auto">
                            Simpan
                        </button>
                    </div>
                </form>
                <script>
                    function renderFiles(files, containerId) {
                        const container = document.getElementById(containerId + "-container");
                        const file = files[0]; // Ambil file pertama (hanya menangani satu file per input)

                        // Membuat objek URL untuk file yang dipilih
                        const imageUrl = URL.createObjectURL(file);

                        // Membuat elemen img untuk menampilkan gambar
                        const imgElement = document.createElement("img");
                        imgElement.src = imageUrl;
                        imgElement.alt = "Preview";

                        // Membersihkan kontainer sebelum menambahkan gambar baru
                        container.innerHTML = "";

                        // Menambahkan elemen img ke dalam kontainer
                        container.appendChild(imgElement);
                    }
                </script>

            </section>
            {{-- End Information Details --}}
        </div>
    </div>
    {{-- Content End --}}
</x-app-layout>
