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
                            @foreach ($form['jenisKelamin'] as $jenis)
                                <option value="{{ $jenis }}"
                                    {{ $penduduk->jenis_kelamin === $jenis ? 'selected' : '' }}>
                                    {{ $jenis }}</option>
                            @endforeach
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
                            @foreach ($form['statusHubunganDalamKeluarga'] as $status)
                                <option value="{{ $status }}"
                                    {{ $penduduk->status_hubungan_dalam_keluarga === $status ? 'selected' : '' }}>
                                    {{ $status }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('status_hubungan_dalam_keluarga')" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Status Perkawinan</div>
                        <select id="status_perkawinan" name="status_perkawinan"
                            class="font-normal mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            @foreach ($form['statusPerkawinan'] as $status)
                                <option value="{{ $status }}"
                                    {{ $penduduk->status_perkawinan === $status ? 'selected' : '' }}>
                                    {{ $status }}</option>
                            @endforeach
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
                            @foreach ($form['statusPenduduk'] as $status)
                                <option value="{{ $status }}"
                                    {{ $penduduk->status_penduduk === $status ? 'selected' : '' }}>
                                    {{ $status }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('status_penduduk')" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Pendidikan Terakhir</div>
                        <select id="pendidikan_terakhir" name="pendidikan_terakhir"
                            class="font-normal mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            @foreach ($form['pendidikanTerakhir'] as $pendidikan)
                                <option value="{{ $pendidikan }}"
                                    {{ $penduduk->pendidikan_terakhir === $pendidikan ? 'selected' : '' }}>
                                    {{ $pendidikan }}</option>
                            @endforeach

                        </select>
                        <x-input-error :messages="$errors->get('pendidikan_terakhir')" class="mt-2" />
                    </div>
                </div>

                <div class="mx-3 my-3 gap-5 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Golongan Darah</div>
                        <select id="golongan_darah" name="golongan_darah"
                            class="font-normal mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            @foreach ($form['golonganDarah'] as $golongan)
                                <option value="{{ $golongan }}"
                                    {{ $penduduk->golongan_darah === $golongan ? 'selected' : '' }}>
                                    {{ $golongan }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('golongan_darah')" class="mt-2" />
                    </div>
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Agama</div>
                        <select id="agama" name="agama"
                            class="font-normal mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            @foreach ($form['agama'] as $agama)
                                <option value="{{ $agama }}"
                                    {{ $penduduk->agama === $agama ? 'selected' : '' }}>
                                    {{ $agama }}</option>
                            @endforeach
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
                        <x-input-error :messages="$errors->get('images')" class="mt-2" />
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
