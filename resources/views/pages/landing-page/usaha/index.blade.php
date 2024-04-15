<x-guest-layout>
    <div class="flex flex-col gap-y-10 w-full max-w-7xl mx-auto">
        {{-- Start Hero Section --}}
        <section>
            <div class="flex flex-col gap-y-12 lg:gap-y-20 lg:pt-10">
                <div class="flex flex-col gap-y-3">
                    <h1 class="text-center font-semibold text-[1rem]/[1.618rem]">
                        Keberagaman Usaha Mikro di RT Ini
                    </h1>
                    <h1 class="font-bold text-[1.618rem]/[2.618rem] text-center lg:text-[2.618rem]/[3.618rem]">
                        Jelajahi UMKM di Lingkungan Anda: Bersama, Kita Tingkatkan Ekonomi Lokal
                    </h1>
                    <div class="flex justify-center items-center">
                        <a href="#" class="bg-green-light px-7 py-4 rounded-xl">
                            Mulai Jelajah
                        </a>
                    </div>
                </div>
                <div>
                    <img src="{{ asset('assets/images/OBJECTS.svg') }}" alt="" class="lg:w-full">
                </div>
            </div>
        </section>
        {{-- End Hero Section --}}

        {{-- Start Intro Section --}}
        <section>
            <div class="flex flex-col gap-y-10">
                <div class="flex flex-col gap-y-5">
                    <div class="border-b-4 border-green-light">
                        <h1 class="font-bold text-[1.618rem]/[2.618rem]">UMKM</h1>
                    </div>
                    <div class="lg:grid lg:grid-cols-2">
                        <p class="text-[1rem]/[1.618rem]">Selamat datang di pusat keberagaman UMKM yang dinamis, tempat
                            berkumpulnya usaha kecil dan
                            menengah yang penuh inovasi dan siap untuk memperkaya lingkungan kita. Bersiaplah untuk
                            mengeksplorasi dan mendukung berbagai usaha lokal yang menawarkan produk dan jasa unik,
                            dibuat dengan dedikasi dan kecintaan.</p>
                        <div class="grid grid-rows-1 grid-cols-2 gap-x-5 max-lg:hidden">
                            <img src="https://source.unsplash.com/random/?market" alt=""
                                class="rounded-xl max-h-60 w-full object-cover">
                            <img src="https://source.unsplash.com/random/?market" alt=""
                                class="rounded-xl max-h-60 w-full object-cover">
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-3">
                        <div class="grid grid-rows-1 grid-cols-2 gap-x-3 lg:hidden">
                            <img src="https://source.unsplash.com/random/?market" alt=""
                                class="rounded-xl max-h-60 w-full object-cover">
                            <img src="https://source.unsplash.com/random/?market" alt=""
                                class="rounded-xl max-h-60 w-full object-cover">
                        </div>
                        <div>
                            <img src="https://source.unsplash.com/random/?market" alt=""
                                class="rounded-xl w-full object-cover max-h-60 lg:max-h-80 ">
                        </div>
                    </div>
                </div>
                <div></div>
            </div>
        </section>
        {{-- End Intro Section --}}

        {{-- Start Group Section --}}
        <section>
            <div class="overflow-hidden">
                <form action="{{ route('usaha') }}" class="w-full overflow-x-auto no-scrollbar">
                    <ul class="flex flex-nowrap w-max gap-4">
                        <li>
                            <button type="submit" name="jenis_umkm" value="Semua"
                                class="inline-block cursor-pointer font-medium border border-green-light text-navy-night px-6 py-4 rounded-full {{ request('jenis_umkm') == 'Semua' || !request('jenis_umkm') ? 'bg-green-light' : '' }}">Semua</button>
                        </li>
                        @foreach ($types as $key => $type)
                            <li>
                                <button type="submit" name="jenis_umkm" value="{{ $type }}"
                                    class="inline-block cursor-pointer font-medium border border-green-light text-navy-night px-6 py-4 rounded-full {{ request('jenis_umkm') == $type ? 'bg-green-light' : '' }}">{{ $type }}</button>
                            </li>
                        @endforeach
                        @foreach ($statuses as $key => $status)
                            <li>
                                <button type="submit" name="status" value="{{ $status }}"
                                    class="inline-block cursor-pointer font-medium border border-green-light text-navy-night px-6 py-4 rounded-full {{ request('status') == $status ? 'bg-green-light' : '' }}">{{ $status }}</button>
                            </li>
                        @endforeach
                    </ul>
                </form>
            </div>
        </section>
        {{-- End Group Section --}}

        {{-- Start Listing Section --}}
        <section>
            <div class="grid auto-rows-fr grid-cols-1">
                <ul class="grid grid-cols-1 gap-y-10 auto-rows-fr md:grid-cols-2 lg:gap-5">
                    @foreach ($businesses as $business)
                        <li>
                            <a href="{{ route('usaha-detail', $business->umkm_id) }}"
                                class="grid grid-cols-3 gap-x-3 group">
                                <div>
                                    <img src="https://source.unsplash.com/random/?market" alt=""
                                        class="max-h-52 w-full object-cover rounded-xl aspect-[2/3]">
                                </div>
                                <div class="flex col-span-2 flex-col gap-y-3 justify-between">
                                    <div>
                                        <h1 class="font-bold text-[1.618rem]/[2.618rem] group-hover:underline">
                                            {{ $business->nama_umkm }}</h1>
                                    </div>
                                    <div>
                                        <h1 class="font-semibold text-[1rem]/[1.618rem]">Deskripsi:</h1>
                                        <p class="text-[1rem]/[1.618rem]">{{ $business->keterangan }}</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
        {{-- End Listing Section --}}

        {{-- Start Other Section --}}
        <section>
            {{-- <div class="mt-10 w-full">
                <button href="/berita"
                    class="px-6 py-3 w-full bg-soft-snow text-navy-night rounded-full gap-x-5 border border-navy-night flex justify-center items-center hover:bg-green-light transition-all duration-300">Lihat
                    Semua
                </button>
            </div> --}}
            {{ $businesses->links() }}
        </section>
        {{-- End Other Section --}}
    </div>
</x-guest-layout>
