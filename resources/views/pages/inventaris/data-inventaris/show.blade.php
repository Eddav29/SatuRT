<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>


    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />
        <div class="p-6 mt-3 rounded-xl bg-white-snow overflow-hidden">
            {{-- Table --}}
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
                    <h1 class="font-bold md:text-2xl text-xl">Detail Inventaris</h1>
                </div>
            </section>
            {{-- Forms Permhonan Surat --}}
            <section>
                <form
                    class="p-6 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col md:grid md:grid-cols-1 md:auto-rows-auto gap-y-5">

                    <div class="lg:mt-5 gap-5 flex max-lg:flex-col lg:grid lg:grid-cols-2">
                        <div class="md:grid md:grid-cols-4 flex max-lg:flex-auto gap-3">
                            <h5 class="font-semibold max-lg:w-2/5">ID Inventaris</h5>
                            <p class="md:col-span-3">: {{ $inventaris->inventaris_id }}</p>
                        </div>
                        <div class="md:grid md:grid-cols-4 flex max-lg:flex-auto gap-3">
                            <h5 class="font-semibold max-lg:w-2/5">Nama</h5>
                            <p class="md:col-span-3">: {{ $inventaris->nama_inventaris }}</p>
                        </div>
                    </div>

                    <div class="lg:mt-5 gap-5 flex max-lg:flex-col lg:grid lg:grid-cols-2">
                        <div class="md:grid md:grid-cols-4 flex max-lg:flex-auto gap-3">
                            <h5 class="font-semibold max-lg:w-2/5">Merk</h5>
                            <p class="md:col-span-3">: {{ $inventaris->merk }}</p>
                        </div>
                        <div class="md:grid md:grid-cols-4 flex max-lg:flex-auto gap-3">
                            <h5 class="font-semibold max-lg:w-2/5">Warna</h5>
                            <p class="md:col-span-3">: {{ $inventaris->warna }}</p>
                        </div>
                    </div>

                    <div class="lg:mt-5 gap-5 flex max-lg:flex-col lg:grid lg:grid-cols-2">
                        <div class="md:grid md:grid-cols-4 flex max-lg:flex-auto gap-3">
                            <h5 class="font-semibold max-lg:w-2/5">Jumlah</h5>
                            <p class="md:col-span-3">: {{ $inventaris->jumlah }}</p>
                        </div>
                        <div class="md:grid md:grid-cols-4 flex max-lg:flex-auto gap-3">
                            <h5 class="font-semibold max-lg:w-2/5">Jenis</h5>
                            <p class="md:col-span-3">: {{ $inventaris->jenis }}</p>
                        </div>
                    </div>

                    <div class="lg:grid lg:grid-cols-5 lg:gap-3 mt-6">
                        <div class="lg:col-span-3">
                            <h5 class="font-semibold mb-4">Laporan</h5>
                            <div class="border-2 rounded-lg h-48">
                                <p>{!! $inventaris->keterangan !!}</p>
                            </div>
                        </div>
                        <div class="max-lg:mt-5 lg:col-span-2">
                            <h5 class="font-semibold mb-4">Lampiran</h5>
                            <div x-data="{ openImage: false }">
                                <img @click="openImage = !openImage"
                                    src="{{ asset('storage/images_storage/inventaris_images/' . $inventaris->foto_inventaris) }}"
                                    alt="" class="rounded-xl max-h-[30rem] w-full object-cover h-48"
                                    draggable="false">
                                <div x-show="openImage"
                                    class="fixed z-[999999999] top-0 left-0 py-10 lg:px-32 px-10 min-w-screen min-h-screen lg:w-screen lg:h-screen bg-navy-night/70 flex justify-center items-center">
                                    <img @click="openImage = false" x-show="openImage"
                                        @click.outside="openImage = false"
                                        src="{{ asset('storage/images_storage/inventaris_images/' . $inventaris->foto_inventaris) }}"
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


                    {{-- Tombol Kembali --}}
                    <div class="mt-5 flex gap-x-5">
                        <a type="kembali" href="{{ route('inventaris.index') }}"
                            class="bg-azure-blue text-white-snow text-sm px-4 py-2 rounded-md flex justify-center items-center gap-x-3">
                            <p>Kembali</p>
                        </a>
                    </div>
                </form>
            </section>
            {{-- End Table --}}
        </div>
    </div>
</x-app-layout>
