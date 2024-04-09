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
                    <img src="https://source.unsplash.com/random/?market" alt=""
                        class="w-full h-full object-cover rounded-xl">
                </div>
                <div>
                    <p class="text-[1.618rem]/[2.618rem] lg:text-[2.618rem]/[3.618rem]">Dukung pertumbuhan UMKM lokal
                        dengan tindakan Anda! Mulailah
                        berbelanja sekarang dan
                        berkontribusi pada ekonomi lokal yang berkembang.</p>
                </div>
                <div class="flex flex-col gap-y-5">
                    <div class="border-t-2 border-navy-night py-5">
                        <h6 class="text-[1rem]/[1.618rem] underline">Detail Usaha</h6>
                    </div>
                    <div class="overflow-hidden">
                        <h1 class="font-bold text-[1.618rem]/[2.618rem] underline">Detail Usaha:</h1>
                        <div class="overflow-auto no-scrollbar">
                            <table class="text-[1rem]/[1.618rem] w-max">
                                <tr>
                                    <td>Nama Usaha</td>
                                    <td class=" mx-5 inline-flex">:</td>
                                    <td>{{ $business->nama_umkm }}</td>
                                </tr>
                                <tr>
                                    <td>Pemilik Usaha</td>
                                    <td class=" mx-5 inline-flex">:</td>
                                    <td>{{ $business->penduduk->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Nomor Telepon</td>
                                    <td class=" mx-5 inline-flex">:</td>
                                    <td>{{ $business->nomor_telepon }}</td>
                                </tr>
                                <tr>
                                    <td>Pemilik Usaha</td>
                                    <td class=" mx-5 inline-flex">:</td>
                                    <td>{{ $business->penduduk->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Jenis UMKM</td>
                                    <td class=" mx-5 inline-flex">:</td>
                                    <td>{{ $business->jenis_umkm }}</td>
                                </tr>
                                <tr>
                                    <td>Status UMKM</td>
                                    <td class=" mx-5 inline-flex">:</td>
                                    <td>{{ $business->status }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td class=" mx-5 inline-flex">:</td>
                                    <td>{{ $business->alamat }}</td>
                                </tr>
                                <tr>
                                    <td>Keterangan</td>
                                    <td class=" mx-5 inline-flex">:</td>
                                    <td>{{ $business->keterangan }}</td>
                                </tr>
                                <tr>
                                    <td>Maps</td>
                                    <td class=" mx-5 inline-flex">:</td>
                                </tr>
                            </table>
                            <div class="w-full rounded-lg overflow-hidden">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.502734311482!2d112.613545976356!3d-7.946885879169603!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78827687d272e7%3A0x789ce9a636cd3aa2!2sPoliteknik%20Negeri%20Malang!5e0!3m2!1sid!2sid!4v1712598378801!5m2!1sid!2sid"
                                    style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"
                                    class="w-full h-60 lg:h-[35rem] border border-black"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-guest-layout>
