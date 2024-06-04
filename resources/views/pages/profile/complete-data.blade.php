<x-profile-layout>
    <header class="p-6 lg:px-14 lg:py-8 sticky top-0 z-[999] flex w-full bg-soft-snow max-lg:drop-shadow">
        <div class="mx-auto flex items-center justify-between lg:hidden w-full">
            <button @click.stop="sidebar = !sidebar" class="z-50 w-10 h-10">
                <x-heroicon-c-bars-3-center-left />
            </button>
            <div class="lg:hidden" x-data="{ profile: false }">
                <div class="h-14 w-14 rounded-full overflow-hidden" @click.stop="profile = !profile">
                    @if (Auth::user()->penduduk->user->profile)
                        <img src="{{ asset('storage/images_storage/account_images/' . Auth::user()->penduduk->user->profile) }}"
                            class="h-full w-full object-cover">
                    @else
                        <img src="{{ asset('assets/images/default.png') }}" class="h-full w-full object-cover">
                    @endif
                </div>
                <div class="absolute right-11 p-2" :class="profile ? 'block' : 'hidden'">
                    <div class="flex flex-col overflow-hidden rounded-lg ">
                        <x-nav-button :class="'text-red-500'" :href="route('logout')">
                            {{ __('Logout') }}
                        </x-nav-button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <div class="p-6 rounded-xl bg-white-snow">
            <section>
                <div class="bg-blue-gray p-5 max-lg:mt-5 rounded-md">
                    <h1 class="text-2xl font-semibold">Ubah Biodata</h1>
                </div>
            </section>

            {{-- Form --}}
            <form action="{{ route('profile.complete-data.post', $penduduk->penduduk_id) }}"
                enctype="multipart/form-data" method="POST">
                @csrf

                <div class="mx-3 my-4 gap-5 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">NIK</div>
                        <input disabled type="text" value="{{ $penduduk->nik }}" placeholder="Masukkan NIK"
                            name="nik" id="nik"
                            class="font-normal placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                        <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Nama</div>
                        <input type="text" value="{{ $penduduk->nama }}" placeholder="Masukkan Nama" name="nama"
                            id="nama"
                            class="font-normal placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>
                </div>

                <div class="mx-3 my-3 gap-5 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Tempat Lahir</div>
                        <input type="text" value="{{ $penduduk->tempat_lahir }}" placeholder="Masukkan Tempat Lahir"
                            name="tempat_lahir" id="tempat_lahir"
                            class="font-normal placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                        <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Tanggal Lahir</div>
                        <input type="date"
                            value="{{ $penduduk->tanggal_lahir ? \Carbon\Carbon::parse($penduduk->tanggal_lahir)->format('Y-m-d') : '' }}"
                            name="tanggal_lahir" id="tanggal_lahir"
                            class="font-normal placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                        <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                    </div>
                </div>

                <div class="mx-3 my-3 gap-5 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Jenis Kelamin</div>
                        <select id="jenis_kelamin" name="jenis_kelamin"
                            class="font-normal  mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            <option value="Pilih Jenis Kelamin" disabled> Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ $penduduk->jenis_kelamin === 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="Perempuan" {{ $penduduk->jenis_kelamin === 'Perempuan' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                        <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Pekerjaan</div>
                        <input type="text" value="{{ $penduduk->pekerjaan }}" placeholder="Masukkan Pekerjaan"
                            name="pekerjaan" id="pekerjaan"
                            class="font-normal placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                        <x-input-error :messages="$errors->get('pekerjaan')" class="mt-2" />
                    </div>
                </div>

                <div class="mx-3 my-3 gap-5 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Status Hubungan Dalam
                            Keluarga</div>
                        <select id="status_hubungan_dalam_keluarga" name="status_hubungan_dalam_keluarga"
                            class="font-normal mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            <option
                                {{ $penduduk->status_hubungan_dalam_keluarga === 'Pilih Status Hubungan' ? 'selected' : '' }}
                                disabled>Pilih Status Hubungan</option>
                            <option value="Kepala Keluarga"
                                {{ $penduduk->status_hubungan_dalam_keluarga === 'Kepala Keluarga' ? 'selected' : '' }}>
                                Kepala
                                Keluarga</option>
                            <option value="Istri"
                                {{ $penduduk->status_hubungan_dalam_keluarga === 'Istri' ? 'selected' : '' }}>Istri
                            </option>
                            <option value="Anak"
                                {{ $penduduk->status_hubungan_dalam_keluarga === 'Anak' ? 'selected' : '' }}>Anak
                            </option>
                            <option value="Cucu"
                                {{ $penduduk->status_hubungan_dalam_keluarga === 'Cucu' ? 'selected' : '' }}>Cucu
                            </option>
                            <option value="Ayah"
                                {{ $penduduk->status_hubungan_dalam_keluarga === 'Ayah' ? 'selected' : '' }}>Ayah
                            </option>
                            <option value="Ibu"
                                {{ $penduduk->status_hubungan_dalam_keluarga === 'Ibu' ? 'selected' : '' }}>Ibu
                            </option>
                            <option value="Saudara"
                                {{ $penduduk->status_hubungan_dalam_keluarga === 'Saudara' ? 'selected' : '' }}>
                                Saudara</option>
                            <option value="Mertua"
                                {{ $penduduk->status_hubungan_dalam_keluarga === 'Mertua' ? 'selected' : '' }}>
                                Mertua</option>
                            <option value="Menantu"
                                {{ $penduduk->status_hubungan_dalam_keluarga === 'Menantu' ? 'selected' : '' }}>
                                Menantu</option>
                            <option value="Cucu Menantu"
                                {{ $penduduk->status_hubungan_dalam_keluarga === 'Cucu Menantu' ? 'selected' : '' }}>
                                Cucu Menantu
                            </option>
                            <option value="Cicit"
                                {{ $penduduk->status_hubungan_dalam_keluarga === 'Cicit' ? 'selected' : '' }}>Cicit
                            </option>
                            <option value="Keluarga Lain"
                                {{ $penduduk->status_hubungan_dalam_keluarga === 'Keluarga Lain' ? 'selected' : '' }}>
                                Keluarga Lain
                            </option>
                        </select>
                        <x-input-error :messages="$errors->get('status_hubungan_dalam_keluarga')" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Status Perkawinan</div>
                        <select id="status_perkawinan" name="status_perkawinan"
                            class="font-normal mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            <option {{ $penduduk->status_perkawinan === null ? 'selected' : '' }} disabled>Pilih Status
                                Perkawinan</option>
                            <option value="Belum Kawin"
                                {{ $penduduk->status_perkawinan === 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin
                            </option>
                            <option value="Kawin" {{ $penduduk->status_perkawinan === 'Kawin' ? 'selected' : '' }}>
                                Kawin</option>
                            <option value="Cerai" {{ $penduduk->status_perkawinan === 'Cerai' ? 'selected' : '' }}>
                                Cerai</option>
                        </select>
                        <x-input-error :messages="$errors->get('status_perkawinan')" class="mt-2" />
                    </div>
                </div>

                <div class="mx-3 my-3 gap-5 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Kota</div>
                        <input type="text" value="{{ $penduduk->kota }}" placeholder="Masukkan Kota"
                            name="kota" id="kota"
                            class="font-normal placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                        <x-input-error :messages="$errors->get('kota')" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Kecamatan</div>
                        <input type="text" value="{{ $penduduk->kecamatan }}" placeholder="Masukkan Kecamatan"
                            name="kecamatan" id="kecamatan"
                            class="font-normal placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                        <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
                    </div>
                </div>

                <div class="mx-3 my-3 gap-5 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Desa/Kelurahan</div>
                        <input type="text" value="{{ $penduduk->desa }}" placeholder="Masukkan Desa/Kelurahan"
                            name="desa" id="desa"
                            class="font-normal placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                        <x-input-error :messages="$errors->get('desa')" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2 flex flex-nowrap gap-3">
                        <div class="lg:w-1/2">
                            <div class="after:content-['*'] after:ml-0.5 after:text-red-500">RW</div>
                            <input type="text" value="{{ $penduduk->nomor_rw }}" placeholder="Masukkan RW"
                                name="nomor_rw" id="nomor_rw"
                                class="font-normal placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            <x-input-error :messages="$errors->get('nomor_rw')" class="mt-2" />
                        </div>
                        <div class="lg:w-1/2">
                            <div class="after:content-['*'] after:ml-0.5 after:text-red-500">RT</div>
                            <input type="text" value="{{ $penduduk->nomor_rt }}" placeholder="Masukkan RT"
                                name="nomor_rt" id="nomor_rt"
                                class="font-normal placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            <x-input-error :messages="$errors->get('nomor_rt')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="mx-3 my-3 gap-5 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Status Penduduk</div>
                        <select id="status_penduduk" name="status_penduduk"
                            class="font-normal mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            <option value="{{ $penduduk->status_penduduk }}" selected disabled>
                                Pilih Status Penduduk</option>
                            <option value="Domisili"
                                {{ $penduduk->status_penduduk === 'Domisili' ? 'selected' : '' }}>Domisili</option>
                            <option
                                value="Non Domisili"{{ $penduduk->status_penduduk === 'Non Domisili' ? 'selected' : '' }}>
                                Non-Domisili</option>
                        </select>
                        <x-input-error :messages="$errors->get('status_penduduk')" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Pendidikan Terakhir</div>
                        <select id="pendidikan_terakhir" name="pendidikan_terakhir"
                            class="font-normal mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            <option {{ $penduduk->pendidikan_terakhir === null ? 'selected' : '' }} disabled>Pilih
                                Pendidikan Terakhir</option>
                            <option value="Tidak Sekolah"
                                {{ $penduduk->pendidikan_terakhir === 'Tidak Sekolah' ? 'selected' : '' }}>Tidak
                                Sekolah</option>
                            <option value="SD" {{ $penduduk->pendidikan_terakhir === 'SD' ? 'selected' : '' }}>SD
                            </option>
                            <option value="SMP" {{ $penduduk->pendidikan_terakhir === 'SMP' ? 'selected' : '' }}>
                                SMP</option>
                            <option value="SMA" {{ $penduduk->pendidikan_terakhir === 'SMA' ? 'selected' : '' }}>
                                SMA</option>
                            <option value="D3" {{ $penduduk->pendidikan_terakhir === 'D3' ? 'selected' : '' }}>D3
                            </option>
                            <option value="S1" {{ $penduduk->pendidikan_terakhir === 'S1' ? 'selected' : '' }}>S1
                            </option>
                            <option value="S2" {{ $penduduk->pendidikan_terakhir === 'S2' ? 'selected' : '' }}>S2
                            </option>
                            <option value="S3" {{ $penduduk->pendidikan_terakhir === 'S3' ? 'selected' : '' }}>S3
                            </option>
                        </select>
                        <x-input-error :messages="$errors->get('pendidikan_terakhir')" class="mt-2" />
                    </div>
                </div>

                <div class="mx-3 my-3 gap-5 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Golongan Darah</div>
                        <select id="golongan_darah" name="golongan_darah"
                            class="font-normal mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            <option {{ $penduduk->golongan_darah === null ? 'selected' : '' }} disabled>Pilih Golongan
                                Darah</option>
                            <option value="A" {{ $penduduk->golongan_darah === 'A' ? 'selected' : '' }}>A
                            </option>
                            <option value="AB" {{ $penduduk->golongan_darah === 'AB' ? 'selected' : '' }}>AB
                            </option>
                            <option value="B" {{ $penduduk->golongan_darah === 'B' ? 'selected' : '' }}>B
                            </option>
                            <option value="O" {{ $penduduk->golongan_darah === 'O' ? 'selected' : '' }}>O
                            </option>
                        </select>
                        <x-input-error :messages="$errors->get('golongan_darah')" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Agama</div>
                        <select id="agama" name="agama"
                            class="font-normal mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            <option {{ $penduduk->agama === null ? 'selected' : '' }} disabled>Pilih Agama</option>
                            <option value="Islam" {{ $penduduk->agama === 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ $penduduk->agama === 'Kristen' ? 'selected' : '' }}>Kristen
                            </option>
                            <option value="Katolik" {{ $penduduk->agama === 'Katolik' ? 'selected' : '' }}>Katolik
                            </option>
                            <option value="Hindu" {{ $penduduk->agama === 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ $penduduk->agama === 'Buddha' ? 'selected' : '' }}>Buddha
                            </option>
                            <option value="Konghucu"{{ $penduduk->agama === 'Konghucu' ? 'selected' : '' }}>Konghucu
                            </option>
                        </select>
                        <x-input-error :messages="$errors->get('agama')" class="mt-2" />
                    </div>
                </div>

                {{-- Foto KTP --}}
                <div class="mx-3 my-3 font-bold">
                    <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Foto KTP</div>
                    <div>
                        @isset($penduduk->foto_ktp)
                            <x-input-file name="images" :accept="$extension" :default="route('storage.ktp', $penduduk->foto_ktp)" />
                        @else
                            <x-input-file name="images" :accept="$extension" />
                        @endisset
                    </div>
                </div>


                {{-- Button --}}
                <div class="mt-3 ml-3 flex gap-x-5">
                    <button type="submit"
                        class="bg-azure-blue text-white-snow text-sm px-4 py-2 rounded-md flex justify-center items-center gap-x-3">
                        Simpan
                    </button>
                    <a href="{{ route('profile') }}"
                        class="border border-navy-night/50 rounded-md px-4 py-2 text-sm flex justify-center items-center gap-x-3">
                        Kembali
                    </a>
                </div>

            </form>
            {{-- End Form --}}
        </div>
    </div>

    @push('styles')
    @endpush

    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/super-build/ckeditor.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var fileInput = document.getElementById('file_input');
                var pendudukFotoKtp = <?php echo json_encode(route('storage.ktp', $penduduk->foto_ktp)); ?>;

                if (value === null) {
                    fileInput.value = pendudukFotoKtp;
                }
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

</x-profile-layout>
