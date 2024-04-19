<x-profile-layout>
    <header class="p-6 lg:px-14 lg:py-8 sticky top-0 z-[999] flex w-full bg-soft-snow max-lg:drop-shadow">
        <div class="mx-auto flex items-center justify-between lg:hidden w-full">
            <button @click.stop="sidebar = !sidebar" class="z-50 w-10 h-10">
                <x-heroicon-c-bars-3-center-left />
            </button>
            <div class="lg:hidden" x-data="{ profile: false }">
                <div class="h-14 w-14 rounded-full overflow-hidden" @click.stop="profile = !profile">
                    <img class="h-full w-full object-cover"
                        src="{{ asset('assets/images/milad-fakurian-PGdW_bHDbpI-unsplash.jpg') }}" alt="">
                </div>
                <div class="absolute right-11 p-2" :class="profile ? 'block' : 'hidden'">
                    <div class="flex flex-col overflow-hidden rounded-lg ">
                        <x-nav-button :class="'text-red-500'">
                            {{ __('Logout') }}
                        </x-nav-button>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <div class="p-6 rounded-xl bg-white-snow">
            {{-- Header --}}
            <section>
                <div class="bg-blue-gray p-5 max-lg:mt-5 rounded-md">
                    <h1 class="text-2xl font-semibold">Biodata</h1>
                </div>
            </section>
            {{-- End header --}}

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
                <div
                    class="p-6 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col md:grid md:grid-cols-2 gap-y-5">
                    <div>
                        <h5 class="font-semibold">NIK</h5>
                        <p>24242424242242</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Nama</h5>
                        <p>Eddo Dava</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Tempat Lahir</h5>
                        <p>Malang</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Tanggal Lahir</h5>
                        <p>19 Februari 2023</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Jenis Kelamin</h5>
                        <p>Laki-Laki</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Pekerjaan</h5>
                        <p>Wirausaha</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Status Hubungan Dalam Keluarga</h5>
                        <p>Kepala Keluarga</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Status Perkawinan</h5>
                        <p>Sudah Kawin</p>
                    </div>

                    <div>
                        <h5 class="font-semibold">Kota</h5>
                        <p>Malang</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Kecamatan</h5>
                        <p>Lowokwaru</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Desa/Kelurahan</h5>
                        <p>Jatimulyo</p>
                    </div>
                    <div class="grid grid-cols-2 grid-rows-1">
                        <div>
                            <h5 class="font-semibold">RT</h5>
                            <p>003</p>
                        </div>
                        <div>
                            <h5 class="font-semibold">RW</h5>
                            <p>001</p>
                        </div>
                    </div>
                    <div>
                        <h5 class="font-semibold">Status Keluarga</h5>
                        <p>Domisili</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Pendidikan Terakhir</h5>
                        <p>SMA</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Golongan Darah</h5>
                        <p>A</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Agama</h5>
                        <p>Islam</p>
                    </div>

                    <div class="font-semibold md:col-span-2">
                        <h5 class="font-semibold">Foto KTP</h5>
                        <label for="lisence_image_url"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 rounded-lg cursor-pointer bg-white-50 hover:bg-bray-100  hover:border-gray-100 hover:bg-gray-200">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <div id="lisence_image_url-container" class="hidden flex justify-center">
                                </div>
                                <p class="mb-2 text-sm text-gray-300 dark:text-gray-300"><span
                                        class="font-semibold">Foto
                                        KTP</span></p>
                            </div>
                        </label>
                    </div>
                </div>
            </section>

            <section style="text-align: center" class="mt-4">
                <a href="{{ route('profile.complete-data') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">
                    Lengkapi Data
                </a>
            </section>
            {{-- End Form --}}
        </div>
    </div>
</x-profile-layout>
