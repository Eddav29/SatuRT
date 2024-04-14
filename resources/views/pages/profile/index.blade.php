<x-profile-layout>
    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <div class="p-6 rounded-xl bg-white-snow">
            {{-- Header --}}
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
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

                <div class="mx-3 my-4 flex flex-nowrap font-bold">
                    <div class="w-1/2" >
                        <div>NIK</div>
                        <div class="font-normal my-2">24242424242242</div>
                    </div>
                    <div class="w-1/2" >
                        <div>Nama</div>
                        <div class="font-normal my-2">Eddo Dava</div>
                    </div>
                </div>

                <div class="mx-3 my-6 flex flex-nowrap font-bold">
                    <div class="w-1/2" >
                        <div>Tempat Lahir</div>
                        <div class="font-normal my-2">Malang</div>
                    </div>
                    <div class="w-1/2" >
                        <div>Tanggal Lahir</div>
                        <div class="font-normal my-2">19 Februari 2023</div>
                    </div>
                </div>

                <div class="mx-3 my-6 flex flex-nowrap font-bold">
                    <div class="w-1/2" >
                        <div>Jenis Kelamin</div>
                        <div class="font-normal my-2">Laki-Laki</div>
                    </div>
                    <div class="w-1/2" >
                        <div>Pekerjaan</div>
                        <div class="font-normal my-2">Wirausaha</div>
                    </div>
                </div>

                <div class="mx-3 my-6 flex flex-nowrap font-bold">
                    <div class="w-1/2" >
                        <div>Status Hubungan Dalam Keluarga</div>
                        <div class="font-normal my-2">Kepala Keluarga</div>
                    </div>
                    <div class="w-1/2" >
                        <div>Status Perkawinan</div>
                        <div class="font-normal my-2">Sudah Kawin</div>
                    </div>
                </div>

                <div class="mx-3 my-6 flex flex-nowrap font-bold">
                    <div class="w-1/2" >
                        <div>Kota</div>
                        <div class="font-normal my-2">Malang</div>
                    </div>
                    <div class="w-1/2" >
                        <div>Kecamatan</div>
                        <div class="font-normal my-2">Lowokwaru</div>
                    </div>
                </div>

                <div class="mx-3 my-6 flex flex-nowrap font-bold">
                    <div class="w-1/2" >
                        <div>Desa/Kelurahan</div>
                        <div class="font-normal my-2">Jatimulyo</div>
                    </div>
                    <div class="w-1/2 flex flex-nowrap" >
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

                <div class="mx-3 my-6 flex flex-nowrap font-bold">
                    <div class="w-1/2" >
                        <div>Pendidikan Terakhir</div>
                        <div class="font-normal my-2">Sekolah Menengah Kejuruan</div>
                    </div>
                    <div class="w-1/2" >
                        <div>Golongan Darah</div>
                        <div class="font-normal my-2">C</div>
                    </div>
                </div>

                <div class="mx-3 my-6 flex flex-nowrap font-bold">
                    <div class="w-1/2" >
                        <div>Agama</div>
                        <div class="font-normal my-2">Islam</div>
                    </div>
                    <div class="w-1/2" >
                        <div>Status Penduduk</div>
                        <div class="font-normal my-2">Domisili</div>
                    </div>
                </div>

                <div class="mx-3 my-6 font-bold">
                    <div>Foto KTP</div>
                    <img src="" alt="Foto KTP">
                </div>
            </section>

            <section style="text-align: center">
                <a href="{{ route('profile.complete-data') }}" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded mt-4">
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
