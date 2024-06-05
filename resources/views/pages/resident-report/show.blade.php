<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>


    <div class="p-6 lg:px-14 gap-y-5 mx-auto max-w-screen-2xl md:p-6 2xl:p-10 ">
        @if (Auth::user()->role->role_name === 'Penduduk')
            <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />
            <div class="mb-3"></div>
        @endif
        <div class="p-6 rounded-xl bg-white-snow overflow-hidden">
            {{-- Table --}}
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
                    @if (Auth::user()->role->role_name === 'Ketua RT')
                        <h1 class="font-bold md:text-2xl text-xl">Detail Pelaporan Warga</h1>
                    @else
                        <h1 class="font-bold md:text-2xl text-xl">Detail Pelaporan</h1>
                    @endif
                </div>
            </section>
            {{-- Forms Permhonan Surat --}}
            <section>
                <form method="POST" action="{{ route('pelaporan.update', $pelaporan->pelaporan_id) }}"
                    class="p-6 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col md:grid md:grid-cols-1 md:auto-rows-auto gap-y-5">
                    @csrf
                    @method('PUT')
                    <div class="md:grid md:grid-cols-4">
                        <h5 class="font-semibold">Judul Laporan</h5>
                        <p class="md:col-span-3">{{ $pelaporan->pengajuan->keperluan }}</p>
                    </div>
                    <div class="md:grid md:grid-cols-4">
                        <h5 class="font-semibold">Pelapor</h5>
                        <p class="md:col-span-3">{{ $pelaporan->pengajuan->penduduk->nama }}</p>
                    </div>
                    <div class="md:grid md:grid-cols-4">
                        <h5 class="font-semibold">Jenis Laporan</h5>
                        <p class="md:col-span-3">{{ $pelaporan->jenis_pelaporan }}</p>
                    </div>
                    <div class="md:grid md:grid-cols-4">
                        <h5 class="font-semibold">Tanggal</h5>
                        <p class="md:col-span-3">{{ $pelaporan->pengajuan->accepted_at->format('Y-m-d') }}</p>
                    </div>
                    <div class="md:grid md:grid-cols-4">
                        <h5 class="font-semibold">Status Laporan</h5>
                        <p class="md:col-span-3">{{ $pelaporan->pengajuan->status->nama }}</p>
                    </div>
                    <div class="lg:grid lg:grid-cols-5 lg:gap-3">
                        <div class="lg:col-span-3 overflow-y-auto">
                            <h5 class="font-semibold">Laporan</h5>
                            <div class="mt-3 p-3 max-lg:h-auto border-2 rounded-lg h-48 h-[17rem] overflow-y-auto">
                                <p>{!! $pelaporan->pengajuan->keterangan !!}</p>
                            </div>
                        </div>
                        <div class="max-lg:mt-5 lg:col-span-2">
                            <h5 class="font-semibold">Lampiran</h5>
                            @if ($pelaporan->image_url)
                                <div x-data="{ openImage: false }">
                                    <img @click="openImage = !openImage"
                                        src="{{ asset('storage/images_storage/' . $pelaporan->image_url) }}"
                                        alt=""
                                        class="mt-3 rounded-xl h-auto max-h-[17rem] w-full object-cover border-2"
                                        draggable="false">
                                    <div x-show="openImage"
                                        class="fixed z-[999999999] top-0 left-0 py-10 lg:px-32 px-10 w-full min-w-screen min-h-screen lg:w-screen lg:h-screen bg-navy-night/70 flex justify-center items-center">
                                        <img @click="openImage = false" x-show="openImage"
                                            @click.outside="openImage = false"
                                            src="{{ asset('storage/images_storage/' . $pelaporan->image_url) }}"
                                            alt="" class="rounded-xl w-max h-max lg:max-w-full lg:max-h-full"
                                            draggable="false">
                                        <div class="absolute w-8 h-8 top-10 right-10 cursor-pointer"
                                            @click="openImage = false">
                                            <x-heroicon-o-x-mark class="w-8 h-8" class="text-white-snow absolute" />
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div x-data="{ openImage: false }">
                                    <img @click="openImage = !openImage"
                                        src="https://img.freepik.com/free-vector/illustration-gallery-icon_53876-27002.jpg"
                                        alt="Default Image"
                                        class="mt-3 rounded-xl h-auto max-h-[17rem] w-full object-cover border-2"
                                        draggable="false">
                                    <div x-show="openImage"
                                        class="fixed z-[999999999] top-0 left-0 py-10 lg:px-32 px-10 min-w-screen min-h-screen lg:w-screen lg:h-screen bg-navy-night/70 flex justify-center items-center">
                                        <img @click="openImage = false" x-show="openImage"
                                            @click.outside="openImage = false"
                                            src="https://img.freepik.com/free-vector/illustration-gallery-icon_53876-27002.jpg"
                                            alt="Default Image"
                                            class="rounded-xl w-max h-max lg:max-w-full lg:max-h-full"
                                            draggable="false">
                                        <div class="absolute w-8 h-8 top-10 right-10 cursor-pointer"
                                            @click="openImage = false">
                                            <x-heroicon-o-x-mark class="w-8 h-8" class="text-white-snow absolute" />
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if (Auth::user()->role->role_name === 'Ketua RT')
                        {{-- Tombol Setujui dan Tolak --}}
                        <div class="mt-10 flex max-lg:flex-col gap-x-5">
                            <button type="submit" name="status_id" id="status_id" value="2"
                                class="bg-green-500 text-white-snow border-2 py-3 px-5 rounded-lg mt-4"
                                @if ($pelaporan->pengajuan->status_id === 2 || $pelaporan->pengajuan->status_id === 3) hidden @endif>
                                <p>Setujui</p>
                            </button>
                            <button type="submit" name="status_id" id="status_id" value="3"
                                class="bg-red-500 text-white-snow border-2 py-3 px-5 rounded-lg mt-4"
                                @if ($pelaporan->pengajuan->status_id === 2 || $pelaporan->pengajuan->status_id === 3) hidden @endif>
                                <p>Tolak</p>
                            </button>
                            <button onclick="window.history.back()"
                                class="text-black border-2 py-3 px-5 rounded-lg mt-4">
                                {{-- <p class="max-lg:hidden"><</p> --}}
                                <p">Kembali</p>
                            </button>
                        </div>
                    @else
                        {{-- Tombol Kembali --}}
                        <div class="mt-10 flex gap-x-5">
                            <button type="submit" name="status_id" id="status_id" value="4"
                                class="bg-red-500 text-white-snow border-2 py-3 px-5 rounded-lg mt-4"
                                @if (
                                    $pelaporan->pengajuan->status_id === 2 ||
                                        $pelaporan->pengajuan->status_id === 3 ||
                                        $pelaporan->pengajuan->status_id === 4) hidden @endif>
                                <p>Batalkan</p>
                            </button>
                            <button onclick="window.history.back()"
                                class="text-black border-2 py-3 px-5 rounded-lg mt-4">
                                {{-- <p class="max-lg:hidden"><</p> --}}
                                <p">Kembali</p>
                            </button>
                        </div>
                    @endif



                </form>
            </section>

            {{-- End Table --}}
        </div>
    </div>
</x-app-layout>
