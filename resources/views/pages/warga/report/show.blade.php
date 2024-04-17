<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>


    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />
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
                    <h1 class="text-2xl font-semibold">Detail Laporan Warga</h1>
                </div>

                <div class="mx-3 my-10 flex">
                    <div class="lg:w-2/12 font-semibold">Pelapor</div>
                    <div>: Eddo</div>
                </div>

                <div class="mx-3 my-10 flex">
                    <div class="lg:w-2/12 font-semibold">NIK</div>
                    <div>: 121353516267</div>
                </div>

                <div class="mx-3 my-10 flex">
                    <div class="lg:w-2/12 font-semibold">Jenis Laporan</div>
                    <div>: Kritik</div>
                </div>

                <div class="mx-3 my-10 flex">
                    <div class="lg:w-2/12 font-semibold">Tanggal</div>
                    <div>: 01-01-1999</div>
                </div>

                <div class="mx-3 my-10">
                    <div class="font-semibold max-lg:hidden">Isi dan Lampiran</div>

                    <div class="flex max-lg:flex-col lg:justify-between gap-3">
                        {{-- Isi Laporan --}}
                        <div class="font-semibold lg:hidden">Isi Laporan</div>
                        <textarea for="lisence_image_url" class="flex flex-col max-lg:max-w-full lg:w-4/6 h-64 border-2 border-gray-300 rounded-lg bg-white"
                            disabled>
                            {{-- ISI Pelaporan nanti ndek sini --}}
                        </textarea>

                        {{-- Gambar --}}
                        <div class="font-semibold lg:hidden">Lampiran</div>
                        <label class="max-lg:max-w-full lg:w-2/6 h-64 border-2 border-gray-300 rounded-lg bg-white flex flex-col items-center justify-center">
                            <img class="mt-2" src="" alt="Laporan Warga">
                        </label>
                    </div>
                </div>

                <div class="mx-3 my-10 text-left">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-md">Kembali</button>
                </div>
            </section>
            {{-- End Table --}}
        </div>
    </div>
</x-app-layout>
