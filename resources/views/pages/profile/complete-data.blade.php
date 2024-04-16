<x-profile-layout>
    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <div class="p-6 rounded-xl bg-white-snow">
            {{-- Header --}}
            <section>
                <div class="p-6 lg:px-14 lg:py-8 sticky top-0 z-[999] flex w-full bg-soft-snow max-lg:drop-shadow lg:hidden">
                    <div class="mx-auto flex items-center justify-between w-full">
                        <button @click.stop="sidebar = !sidebar" class="z-50 w-10 h-10">
                            <x-heroicon-c-bars-3-center-left />
                        </button>
                        <div class="lg:hidden" x-data="{ profile: false }">
                            <div class="h-14 w-14 rounded-full overflow-hidden" @click.stop="profile = !profile">
                                <img class="h-full w-full object-cover"
                                    src="{{ asset('assets/images/milad-fakurian-PGdW_bHDbpI-unsplash.jpg') }}"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-gray p-5 max-lg:mt-5 rounded-md">
                    <h1 class="text-2xl font-semibold">Lengkapi Biodata</h1>
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

                <div class="mx-3 my-3 gap-5 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Tempat Lahir</div>
                        <input type="text" placeholder="Masukkan Tempat Lahir" name="" id=""
                            class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                    </div>
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Tanggal Lahir</div>
                        <input type="date" name="" id=""
                            class="font-normal placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                    </div>
                </div>

                <div class="mx-3 my-3 gap-5 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Jenis Kelamin</div>
                        <select id="jenis_kelamin" name="jenis_kelamin"
                            class="font-normal  mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            <option value="" selected disabled>Pilih Jenis Kelamin</option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Pekerjaan</div>
                        <input type="text" placeholder="Masukkan Pekerjaan" name="" id=""
                            class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                    </div>
                </div>

                <div class="mx-3 my-3 gap-5 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Status Hubungan Dalam Keluarga</div>
                        <select id="status_hubungan" name="status_hubungan"
                            class="font-normal mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            <option value="" selected disabled>Pilih Status Hubungan</option>
                            <option value="Kepala Keluarga">Kepala Keluarga</option>
                            <option value="Istri">Istri</option>
                            <option value="Anak">Anak</option>
                            <option value="Cucu">Cucu</option>
                            <option value="Ayah">Ayah</option>
                            <option value="Ibu">Ibu</option>
                            <option value="Saudara">Saudara</option>
                            <option value="Mertua">Mertua</option>
                            <option value="Menantu">Menantu</option>
                            <option value="Cucu Menantu">Cucu Menantu</option>
                            <option value="Cicit">Cicit</option>
                            <option value="Keluarga Lain">Keluarga Lain</option>
                        </select>
                    </div>
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Status Perkawinan</div>
                        <select id="status_perkawinan" name="status_perkawinan"
                            class="font-normal mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            <option value="" selected disabled>Pilih Status Perkawinan</option>
                            <option value="Belum Kawin">Belum Kawin</option>
                            <option value="Kawin">Kawin</option>
                            <option value="Cerai">Cerai</option>
                        </select>
                    </div>
                </div>

                <div class="mx-3 my-3 gap-5 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Kota</div>
                        <input type="text" placeholder="Masukkan Kota" name="" id=""
                            class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                    </div>
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Kecamatan</div>
                        <input type="text" placeholder="Masukkan Kecamatan" name="" id=""
                            class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                    </div>
                </div>

                <div class="mx-3 my-3 gap-5 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Desa/Kelurahan</div>
                        <input type="text" placeholder="Masukkan Desa/Kelurahan" name="" id=""
                            class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                    </div>
                    <div class="lg:w-1/2 flex flex-nowrap gap-3">
                        <div class="lg:w-1/2">
                            <div class="after:content-['*'] after:ml-0.5 after:text-red-500">RW</div>
                            <input type="text" placeholder="Masukkan RW" name="" id=""
                                class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                        </div>
                        <div class="lg:w-1/2">
                            <div class="after:content-['*'] after:ml-0.5 after:text-red-500">RT</div>
                            <input type="text" placeholder="Masukkan RT" name="" id=""
                                class="placeholder:text-gray-300 placeholder:font-light required:ring-1 required:ring-red-500 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                        </div>
                    </div>
                </div>

                <div class="mx-3 my-3 gap-5 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Status Keluarga</div>
                        <select id="status_keluarga" name="status_keluarga"
                            class="font-normal mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            <option value="" selected disabled>Pilih Status Perkawinan</option>
                            <option value="Domisili">Domisili</option>
                            <option value="Non-Domisili">Non-Domisili</option>
                        </select>
                    </div>
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Pendidikan Terakhir</div>
                        <select id="pendidikan_terakhir" name="pendidikan_terakhir"
                            class="font-normal mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            <option value="" selected disabled>Pilih Pendidikan Terakhir</option>
                            <option value="Tidak Sekolah">Tidak Sekolah</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA">SMA</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>
                </div>

                <div class="mx-3 my-3 gap-5 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Golongan Darah</div>
                        <select id="golongan_darah" name="golongan_darah"
                            class="font-normal mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            <option value="" selected disabled>Pilih Golongan Darah</option>
                            <option value="A">A</option>
                            <option value="AB">AB</option>
                            <option value="B">B</option>
                            <option value="O">O</option>
                        </select>
                    </div>
                    <div class="lg:w-1/2">
                        <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Golongan Darah</div>
                        <select id="agama" name="agama"
                            class="font-normal mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                            <option value="" selected disabled>Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen Protestan">Kristen Protestan</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Kong Hu Cu">Kong Hu Cu</option>
                        </select>
                    </div>
                </div>


                <div class="mx-3 my-3 font-bold">
                    <div class="after:content-['*'] after:ml-0.5 after:text-red-500">Foto KTP</div>
                    <label for="lisence_image_url" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 rounded-lg cursor-pointer bg-white-50 hover:bg-bray-100  hover:border-gray-100 hover:bg-gray-200">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-300 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <div id="lisence_image_url-container" class="hidden flex justify-center">
                            </div>
                            <p class="mb-2 text-sm text-gray-300 dark:text-gray-300"><span class="font-semibold">Unggah Foto KTP</span></p>
                        </div>
                        <input id="lisence_image_url" type="file" class="hidden" onchange="renderFiles(this.files, 'lisence_image_url')" />
                    </label>
                </div>


                <div class="mx-3 my-3">
                    <a href="#" class="bg-blue-500 hover:bg-blue-800 text-white py-2 px-4 rounded mt-4 mr-2">
                        Simpan
                    </a>
                    <a href="#" class="text-black border-2 py-2 px-4 rounded mt-4">
                        Kembali
                    </a>
                </div>
            </section>
            {{-- End Form --}}
        </div>
    </div>

    @push('styles')
    @endpush

    @push('scripts')
    @endpush

</x-profile-layout>
