<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb :list="$breadcrumb['list']" :url="$breadcrumb['url']" />
    </x-slot>

    <div class="p-6 lg:px-12 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col gap-y-5">
        {{-- Toolbar --}}
        <x-toolbar :toolbar_id="$toolbar_id" :active="$active" :toolbar_route="$toolbar_route" />
        <div class="p-6 rounded-xl bg-white-snow mt-5">
            {{-- Detail Peminjaman --}}
            <section>
                <div class="bg-blue-gray p-5 rounded-md">
                    <h1 class="font-bold md:text-2xl text-xl">Detail Peminjaman</h1>
                </div>
            </section>

            {{-- Forms Peminjaman --}}
            <section>
                <div class="p-6 mx-auto max-w-screen-2xl md:p-6 2xl:p-6 flex flex-col md:grid md:grid-cols-2 gap-5">
                    @if ($peminjaman)
                        <div>
                            <h5 class="font-semibold">Nama Barang</h5>
                            <p>{{ $peminjaman->inventaris->nama_inventaris ?? 'Tidak Ada Data' }}</p>
                        </div>
                        <div>
                            <h5 class="font-semibold">Nama Penduduk</h5>
                            <p>{{ $peminjaman->penduduk->nama ?? 'Tidak Ada Data' }}</p>
                        </div>
                        <div>
                            <h5 class="font-semibold">Jumlah</h5>
                            <p>{{ $peminjaman->jumlah ?? 'Tidak Ada Data' }}</p>
                        </div>
                        <div>
                            <h5 class="font-semibold">Kondisi</h5>
                            <p>{{ $peminjaman->kondisi ?? 'Tidak Ada Data' }}</p>
                        </div>
                        <div>
                            <h5 class="font-semibold">Tanggal Pinjam</h5>
                            <p>{{ $peminjaman->tanggal_pinjam ?? 'Tidak Ada Data' }}</p>
                        </div>
                        <div>
                            <h5 class="font-semibold">Tanggal Kembali</h5>
                            <p>{{ $peminjaman->tanggal_kembali ?? 'Belum Dikembalikan' }}</p>
                        </div>
                        <div>
                            <h5 class="font-semibold">Dibuat Pada</h5>
                            <p>{{ $peminjaman->created_at ?? 'Tidak Ada Data' }}</p>
                        </div>
                        <div>
                            <h5 class="font-semibold">Terakhir Diubah</h5>
                            <p>{{ $peminjaman->updated_at ?? 'Tidak Ada Data' }}</p>
                        </div>
                    @else
                        <div>
                            <p>Tidak ada data yang ditemukan.</p>
                        </div>
                    @endif
                </div>

                {{-- Back Button --}}
                <div class="flex gap-x-5 px-5">
                    <button onclick="window.history.back()" class="text-black border-2 py-3 px-5 rounded-lg mt-4">
                        {{-- <p class="max-lg:hidden"><</p> --}}
                        <p">Kembali</p>
                    </button>
                </div>
            </section>

        </div>
    </div>
</x-app-layout>
