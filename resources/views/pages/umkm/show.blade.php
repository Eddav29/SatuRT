<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    {{-- Content Start --}}
    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />
        <div class="p-6 rounded-xl bg-white-snow mt-5">
            {{-- Information Details --}}
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
                    <h1 class="font-bold md:text-2xl text-xl">Detail UMKM</h1>
                </div>
            </section>
            <section>
                <div
                    class="p-6 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col md:grid md:grid-cols-2 gap-y-5">
                    <div>
                        <h5 class="font-semibold">Pemilik</h5>
                        <p>{{ $umkm->penduduk->nama }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Nama UMKM</h5>
                        <p>{{ $umkm->nama_umkm }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Jenis UMKM</h5>
                        <p>{{ $umkm->jenis_umkm }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Alamat</h5>
                        <p>{{ $umkm->alamat }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Nomor Telepon</h5>
                        <p>{{ $umkm->nomor_telepon }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Lokasi URL</h5>
                        <p>{{ $umkm->lokasi_url }}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold">Status UMKM</h5>
                        <p>{{ $umkm->status }}</p>
                    </div>
                    <div class="md:col-span-2 md:h-auto">
                        <h5 class="font-semibold">Surat Izin Usaha</h5>
                        <div x-data="{ openImage: false }">
                            <img @click="openImage = !openImage"
                                src="{{ asset('storage/images_storage/business-lisence_images/'. $umkm->lisence_image_url) }}"
                                alt="" class="rounded-xl w-full object-cover" draggable="false">
                            <div x-show="openImage"
                                class="fixed top-0 left-0 py-10 lg:px-32 px-10 min-w-screen min-h-screen lg:w-screen lg:h-screen bg-navy-night/70 flex justify-center items-center z-[99999999999]">
                                <img @click="openImage = false" x-show="openImage" @click.outside="openImage = false"
                                    src="{{ asset('storage/images_storage/business-lisence_images/'.$umkm->lisence_image_url) }}"
                                    alt="" class="rounded-xl w-max h-max lg:max-w-full lg:max-h-full"
                                    draggable="false">
                                <div class="absolute w-8 h-8 top-10 right-10 cursor-pointer" @click="openImage = false">
                                    <x-heroicon-o-x-mark class="w-8 h-8" class="text-white-snow absolute" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <h5 class="font-semibold">Thumbnail</h5>
                        <div x-data="{ openImage: false }">
                            <img @click="openImage = !openImage"
                                src="{{ asset('storage/images_storage/business-thumbnail_images/'.$umkm->thumbnail_url) }}"
                                alt="" class="rounded-xl w-full object-cover" draggable="false">
                            <div x-show="openImage"
                                class="fixed top-0 left-0 py-10 lg:px-32 px-10 min-w-screen min-h-screen lg:w-screen lg:h-screen bg-navy-night/70 flex justify-center items-center z-[99999999999]">
                                <img @click="openImage = false" x-show="openImage" @click.outside="openImage = false"
                                    src="{{ asset('storage/images_storage/business-thumbnail_images/'.$umkm->thumbnail_url) }}"
                                    alt="" class="rounded-xl w-max h-max lg:max-w-full lg:max-h-full"
                                    draggable="false">
                                <div class="absolute w-8 h-8 top-10 right-10 cursor-pointer" @click="openImage = false">
                                    <x-heroicon-o-x-mark class="w-8 h-8" class="text-white-snow absolute" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <h5 class="font-semibold">Keterangan</h5>
                        {!! $umkm->keterangan !!}
                    </div>
                </div>
            </section>
            {{-- End Information Details --}}

            {{-- Back Button --}}
            <div class="mt-10 flex gap-x-5 px-5">
                <a href="{{ route('umkm.index') }}"
                    class="border border-navy-night/50 rounded-md px-4 py-2 text-sm flex justify-center items-center gap-x-3">
                    <p>Kembali</p>
                </a>
            </div>
        </div>
    </div>
    {{-- Content End --}}
</x-app-layout>
