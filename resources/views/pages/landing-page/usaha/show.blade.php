<x-guest-layout>
    <div class="flex flex-col gap-y-10 w-full max-w-7xl mx-auto">
        <section>
            <div class="flex flex-col gap-y-10">
                <div class="flex flex-col">
                    <h6 class="text-[1rem]/[1.618rem]">Status Usaha : {{ $business->status }}</h6>
                    <h1 class="font-bold text-[2.618rem]/[3.618rem]">{{ $business->nama_umkm }}</h1>
                    <h6 class="text-[1rem]/[1.618rem]">Owner : <span
                            class="font-semibold">{{ $business->penduduk->nama }}</span></h6>
                    <h6 class="text-[1rem]/[1.618rem]">{{ $business->jenis_umkm }}</h6>
                </div>
                <div class="h-60 lg:h-[40rem]">
                    <img src="{{ strpos($business->thumbnail_url, 'https') === 0 ? $business->thumbnail_url : asset('storage/images_storage/' . $business->thumbnail_url) }}"
                        alt="" class="w-full h-full object-cover rounded-xl">
                </div>
                <div>
                    <p class="text-[1.618rem]/[2.618rem] lg:text-[2.618rem]/[3.618rem]">Dukung pertumbuhan UMKM lokal
                        dengan tindakan Anda! Mulailah
                        berbelanja sekarang dan
                        berkontribusi pada ekonomi lokal yang berkembang.</p>
                </div>
                <div class="flex flex-col gap-y-5">
                    <hr class="border-b-4 border-green-light">
                    <div class="overflow-hidden">
                        <h1 class="font-bold text-[1.618rem]/[2.618rem] underline">Detail Usaha:</h1>
                        <div class="overflow-auto no-scrollbar">
                            <table class="text-[1rem]/[1.618rem] w-max">
                                <tr>
                                    <td>Nama Usaha</td>
                                    <td class=" mx-5 p-3 inline-flex">:</td>
                                    <td>{{ $business->nama_umkm }}</td>
                                </tr>
                                <tr>
                                    <td>Pemilik Usaha</td>
                                    <td class=" mx-5 p-3 inline-flex">:</td>
                                    <td>{{ $business->penduduk->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Nomor Telepon</td>
                                    <td class=" mx-5 p-3 inline-flex">:</td>
                                    <td>{{ $business->nomor_telepon }}</td>
                                </tr>
                                <tr>
                                    <td>Pemilik Usaha</td>
                                    <td class=" mx-5 p-3 inline-flex">:</td>
                                    <td>{{ $business->penduduk->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Jenis UMKM</td>
                                    <td class=" mx-5 p-3 inline-flex">:</td>
                                    <td>{{ $business->jenis_umkm }}</td>
                                </tr>
                                <tr>
                                    <td>Status UMKM</td>
                                    <td class=" mx-5 p-3 inline-flex">:</td>
                                    <td>{{ $business->status }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td class=" mx-5 p-3 inline-flex">:</td>
                                    <td>{{ $business->alamat }}</td>
                                </tr>
                                <tr>
                                    <td>Keterangan</td>
                                    <td class=" mx-5 p-3 inline-flex">:</td>
                                    <td>{!! $business->keterangan !!}</td>
                                </tr>
                                <tr>
                                    <td>Maps</td>
                                    <td class=" mx-5 p-3 inline-flex">:</td>
                                    <td><a class="text-blue-500 hover:underline"
                                            href="{{ $business->lokasi_url }}">{{ $business->nama_umkm }}</a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-guest-layout>
