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
                <div class="bg-blue-gray p-5 rounded-md">
                    <h1 class="font-bold md:text-2xl text-xl">Detail Permohonan Surat</h1>
                </div>
            </section>
            {{-- Forms Permhonan Surat --}}
            <section>
                <form
                    class="p-6 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col md:grid md:grid-cols-1 md:auto-rows-auto gap-y-5">
                    <div class="md:grid md:grid-cols-4">
                        <h5 class="font-semibold">Pelapor</h5>
                        <p class="md:col-span-3">Eddo</p>
                    </div>
                    <div class="md:grid md:grid-cols-4">
                        <h5 class="font-semibold">Jenis Laporan</h5>
                        <p class="md:col-span-3">Kritik</p>
                    </div>
                    <div class="md:grid md:grid-cols-4">
                        <h5 class="font-semibold">Tanggal</h5>
                        <p class="md:col-span-3">12-12-2022</p>
                    </div>
                    <div class="lg:grid lg:grid-cols-5 lg:gap-3">
                        <div class="lg:col-span-3">
                            <h5 class="font-semibold">Laporan</h5>
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Unde obcaecati rem eligendi
                                rerum ad sunt vel nesciunt error ut, voluptatem et esse debitis dolorum perspiciatis.
                                Aliquid tempore assumenda fuga facilis ullam quisquam vero, nihil at magnam corrupti,
                                neque a consequuntur, laudantium tenetur quo voluptatum earum nostrum numquam? Atque
                                quidem reprehenderit ad? Doloremque repudiandae quis asperiores sapiente aut minus
                                nostrum quo hic quibusdam optio? Sed laborum amet beatae itaque tempora quibusdam
                                voluptatum. Sint a qui, officiis facilis vitae quibusdam ipsa rerum? Ea illo dicta quas
                                accusantium amet ad! Laudantium debitis necessitatibus nihil laborum praesentium libero
                                quam laboriosam accusantium dicta ipsum! Aut.</p>
                        </div>
                        <div class="max-lg:mt-5 lg:col-span-2">
                            <h5 class="font-semibold">Lampiran</h5>
                            <div x-data="{ openImage: false }">
                                <img @click="openImage = !openImage"
                                    src="{{ asset('assets/images/milad-fakurian-PGdW_bHDbpI-unsplash.jpg') }}"
                                    alt="" class="rounded-xl max-h-[30rem] w-full object-cover"
                                    draggable="false">
                                <div x-show="openImage"
                                    class="fixed z-[999999999] top-0 left-0 py-10 lg:px-32 px-10 min-w-screen min-h-screen lg:w-screen lg:h-screen bg-navy-night/70 flex justify-center items-center">
                                    <img @click="openImage = false" x-show="openImage"
                                        @click.outside="openImage = false"
                                        src="{{ asset('assets/images/milad-fakurian-PGdW_bHDbpI-unsplash.jpg') }}"
                                        alt="" class="rounded-xl w-max h-max lg:max-w-full lg:max-h-full"
                                        draggable="false">
                                    <div class="absolute w-8 h-8 top-10 right-10 cursor-pointer"
                                        @click="openImage = false">
                                        <x-heroicon-o-x-mark class="w-8 h-8" class="text-white-snow absolute" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- Tombol Setujui dan Tolak --}}
                    <div class="mt-10 flex gap-x-5">
                        <button type="submit"
                            class="bg-green-500 text-white-snow text-sm px-4 py-2 rounded-md flex justify-center items-center gap-x-3">
                            <p>Simpan</p>
                        </button>
                        <button type="submit"
                            class="bg-red-500 text-white-snow text-sm px-4 py-2 rounded-md flex justify-center items-center gap-x-3">
                            <p>Simpan</p>
                        </button>
                    </div>
                </form>
            </section>
            {{-- End Table --}}
        </div>
    </div>
</x-app-layout>
