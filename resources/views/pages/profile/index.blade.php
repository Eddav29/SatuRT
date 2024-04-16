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
                    <h1 class="text-2xl font-semibold">Biodata</h1>
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

                <div class="mx-3 my-4 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div>NIK</div>
                        <div class="font-normal my-2">24242424242242</div>
                    </div>
                    <div class="lg:w-1/2">
                        <div>Nama</div>
                        <div class="font-normal my-2">Eddo Dava</div>
                    </div>
                </div>

                <div class="mx-3 my-3 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div>Tempat Lahir</div>
                        <div class="font-normal my-2">Malang</div>
                    </div>
                    <div class="lg:w-1/2">
                        <div>Tanggal Lahir</div>
                        <div class="font-normal my-2">19 Februari 2023</div>
                    </div>
                </div>

                <div class="mx-3 my-3 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div>Jenis Kelamin</div>
                        <div class="font-normal my-2">Laki-Laki</div>
                    </div>
                    <div class="lg:w-1/2">
                        <div>Pekerjaan</div>
                        <div class="font-normal my-2">Wirausaha</div>
                    </div>
                </div>

                <div class="mx-3 my-3 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div>Status Hubungan Dalam Keluarga</div>
                        <div class="font-normal my-2">Kepala Keluarga</div>
                    </div>
                    <div class="lg:w-1/2">
                        <div>Status Perkawinan</div>
                        <div class="font-normal my-2">Sudah Kawin</div>
                    </div>
                </div>

                <div class="mx-3 my-3 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div>Kota</div>
                        <div class="font-normal my-2">Malang</div>
                    </div>
                    <div class="lg:w-1/2">
                        <div>Kecamatan</div>
                        <div class="font-normal my-2">Lowokwaru</div>
                    </div>
                </div>

                <div class="mx-3 my-3 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div>Desa/Kelurahan</div>
                        <div class="font-normal my-2">Jatimulyo</div>
                    </div>
                    <div class="lg:w-1/2 flex flex-nowrap" >
                        <div class="w-1/2" >
                            <div>RT</div>
                            <div class="font-normal my-2">003</div>
                        </div>
                        <div class="w-1/2" >
                            <div>RW</div>
                            <div class="font-normal my-2">001</div>
                        </div>
                    </div>
                </div>

                <div class="mx-3 my-3 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div>Status Keluarga</div>
                        <div class="font-normal my-2">Domisili</div>
                    </div>
                    <div class="lg:w-1/2">
                        <div>Pendidikan Terakhir</div>
                        <div class="font-normal my-2">SMA</div>
                    </div>
                </div>

                <div class="mx-3 my-3 flex max-lg:flex-col lg:flex-nowrap font-bold">
                    <div class="lg:w-1/2">
                        <div>Golongan Darah</div>
                        <div class="font-normal my-2">A</div>
                    </div>
                    <div class="lg:w-1/2">
                        <div>Agama</div>
                        <div class="font-normal my-2">Islam</div>
                    </div>
                </div>

                <div class="mx-3 my-3 font-bold">
                    <div>Foto KTP</div>
                    <label for="lisence_image_url" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 rounded-lg cursor-pointer bg-white-50 hover:bg-bray-100  hover:border-gray-100 hover:bg-gray-200">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <div id="lisence_image_url-container" class="hidden flex justify-center">
                            </div>
                            <p class="mb-2 text-sm text-gray-300 dark:text-gray-300"><span class="font-semibold">Foto KTP</span></p>
                        </div>
                    </label>
                </div>
            </section>

            <section style="text-align: center" class="mt-4">
                <a href="{{ route('profile.complete-data') }}" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">
                    Lengkapi Data
                </a>
            </section>
            {{-- End Form --}}
        </div>
    </div>

    @push('styles')
    @endpush

    @push('scripts')
    @endpush

</x-profile-layout>
