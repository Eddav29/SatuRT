<x-guest-layout>
    @push('styles')
        <link rel="preload" href="{{ asset('assets/images/isometric-research-of-statistical-data-and-analytics.webp') }}"
            as="image">
        <link rel="preload" href="{{ asset('assets/images/3d-buddy-boy-offering-handshake.webp') }}" as="image">
        <link rel="preload" href="{{ asset('assets/images/undraw_join_re_w1lh.svg') }}" as="image">
    @endpush
    <div class="flex flex-col gap-y-14 lg:gap-y-40">
        {{-- Hero Section Start --}}
        <section class="m-auto w-full max-w-7xl">
            <div class="grid grid-rows-2 lg:grid-rows-1 lg:grid-cols-2 lg:flex lg:justify-center lg:items-center">
                <div class="place-self-center lg:order-2 max-w-xl lg:w-full md:flex md:justify-center md:items-center">
                    <img src="{{ asset('assets/images/isometric-research-of-statistical-data-and-analytics.webp') }}"
                        alt="" class="w-full">
                </div>
                <div class="flex flex-col gap-y-4 md:w-full leading-8">
                    <div
                        class="flex flex-col gap-y-2 font-bold bg-gradient-to-br from-navy-night to-[#666666] text-transparent bg-clip-text">
                        <h3 class="text-[1.618rem]/[2.618rem]">
                            RT Goes Digital: </h3>
                        <h1 class="text-[2.618rem]/[3.618rem] lg:text-[3.618rem]/[4.618rem]">
                            Mengoptimalkan Interaksi dan Manajemen Komunitas</h1>
                    </div>
                    <p class="md:text-base lg:text-md text-[1rem]/[1.618rem]">RT memasuki era baru dengan sistem
                        informasi
                        yang mempercepat proses pengambilan keputusan, memperkuat partisipasi warga, dan menciptakan
                        lingkungan yang lebih terorganisir dan berdaya.</p>
                    <a class="inline-block w-fit rounded-xl bg-green-light text-navy-night px-8 py-3 text-[1rem]/[1.618rem] font-medium transition hover:scale-105 hover:shadow-xl focus:outline-none focus:ring"
                        href="#remarks">
                        Mulai Jelajah
                    </a>
                </div>
            </div>
        </section>
        {{-- Hero Section End --}}

        {{-- Remarks by the Head of RT --}}
        <section id="remarks" class="flex flex-col lg:grid lg:grid-cols-2 w-full max-w-7xl mx-auto">
            <div class="relative md:flex md:justify-center md:items-center">
                <div
                    class="absolute w-80 h-80 max-lg:top-0 max-lg:right-0 lg:w-96 lg:h-96 md:left-20 lg:left-0 bg-green-light rounded-full blur-3xl">
                </div>
                <img src="{{ asset('assets/images/3d-buddy-boy-offering-handshake.webp') }}"
                    class="relative lg:w-[30rem] md:transform md:-scale-x-100 z-10" alt="">
            </div>
            <div>
                <div class="py-6">
                    <h1 class="font-bold text-[1.618rem]/[2.618rem] md:text-[2.618rem]/[3.618rem]">Sambutan Ketua RT
                    </h1>
                    <h4 class="font-semibold text-[1rem]/[1.618rem]">{{ $leader->nama }} - Ketua RT</h4>
                </div>
                <div>
                    <p class="indent-10 text-justify text-[1rem]/[1.618rem]">Selamat datang di laman resmi RT kita,
                        sebuah
                        komunitas yang
                        dibangun
                        atas dasar kebersamaan,
                        kekeluargaan, dan kerjasama. Di sini, kami bertekad untuk menciptakan lingkungan yang aman,
                        nyaman,
                        dan kondusif bagi setiap anggota komunitas, tempat di mana setiap suara didengar, dan setiap
                        tindakan diarahkan untuk kesejahteraan bersama. Kami percaya bahwa kekuatan komunitas kita
                        terletak
                        pada keberagaman dan solidaritas kita, membuat RT kita bukan hanya sekedar tempat tinggal, tapi
                        sebuah rumah bagi kita semua.</p>
                    <p class="indent-10 text-justify text-[1rem]/[1.618rem]">
                        Kami mengundang Anda untuk menjelajahi lebih lanjut tentang program dan kegiatan yang kami
                        selenggarakan, serta berbagai informasi penting yang kami sajikan melalui laman ini. Ini
                        merupakan
                        langkah kita bersama dalam memperkuat tali persaudaraan, meningkatkan kualitas hidup, dan
                        bersama-sama menghadapi tantangan demi mencapai cita-cita komunitas kita. Mari kita jadikan RT
                        kita
                        sebagai contoh terbaik dari apa yang bisa dicapai ketika kita bekerja bersama, dengan hati dan
                        tangan yang terbuka.
                    </p>
                </div>
            </div>
        </section>
        {{-- End of Remarks by the Head of RT --}}

        @if (count($businesses) > 0)
            {{-- MSME Start --}}
            <section class="w-full max-w-7xl mx-auto relative">
                <div class="h-80 w-80 absolute top-0 z-0 -right-60 bg-green-light rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <h1 class="text-center font-bold text-[1.618rem]/[2.618rem] lg:text-[2.618rem]/[3.618rem]">Telusuri
                        Daftar UMKM Terkini di RT Ini</h1>
                    <p class="text-center mt-2 text-[1rem]/[1.618rem]">Temukan Produk-produk Berkualitas dari Pengusaha
                        Lokal</p>
                </div>
                <!-- Slider main container -->
                <div class="swiper mt-10">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper lg:grid lg:grid-cols-3 lg:gap-x-7">
                        <!-- Slides -->
                        @foreach ($businesses as $business)
                            <div class="swiper-slide overflow-hidden">
                                <a href="{{ url('usaha/' . $business->umkm_id) }}" class="flex flex-col">
                                    <div>
                                        <img src="{{ strpos($business->thumbnail_url, 'http') === 0 ? $business->thumbnail_url : asset('storage/images_storage/' . $business->thumbnail_url) }}"
                                            loading="lazy" alt=""
                                            class="h-[15rem] w-full object-cover rounded-lg">
                                    </div>
                                    <div>
                                        <div class="flex flex-col justify-between mt-3">
                                            <h1 class="font-bold text-[1.618rem]/[2.618rem]">
                                                {{ strlen($business->nama_umkm) > 18 ? substr($business->nama_umkm, 0, 16) . '...' : $business->nama_umkm }}
                                            </h1>
                                            <div aria-label="MSMS-Type"
                                                class="px-3 py-2 bg-green-light my-2 text-navy-night rounded-md text-xs w-fit">
                                                {{ $business->jenis_umkm }}
                                            </div>
                                        </div>
                                        <p>Owner : <span class="font-semibold">{{ $business->penduduk->nama }}</span>
                                        </p>
                                    </div>
                                    <div class="py-3">
                                        <p class="font-light text-justify text-[1rem]/[1.618rem]">
                                            {!! Str::limit($business->keterangan, 100, '...') !!}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="mt-10 w-full flex justify-center">
                    <a href="{{ url('usaha') }}"
                        class="px-6 py-3 bg-soft-snow w-full text-navy-night rounded-full gap-x-5 border border-navy-night flex justify-center items-center hover:bg-green-light transition-all duration-300">Lihat
                        Semua</a>
                </div>
            </section>
            {{-- MSME End --}}
        @endif

        {{-- Feature  --}}
        <section class="w-full max-w-7xl mx-auto flex flex-col relative">
            <div class="absolute w-80 h-80 bottom-36 -right-40 bg-green-light rounded-full blur-3xl"></div>
            <div class="absolute w-80 h-80 bottom-0 -left-40 bg-green-light rounded-full blur-3xl"></div>
            <div>
                <h1 class="text-[1.618rem]/[2.618rem] font-bold text-center lg:text-[2.618rem]/[3.618rem]">Solusi
                    Inovatif untuk Manajemen RT</h1>
                <p class="text-center text-[1rem]/[1.618rem]">Solusi sederhana, manajemen yang lebih baik.</p>
            </div>
            <div x-data="{
                data: [{
                        id: 0,
                        title: 'Pengumuman',
                        desc: 'Dapatkan informasi terbaru seputar kegiatan, acara, dan pengumuman penting dari pemerintah atau RT secara langsung di aplikasi.',
                    },
                    {
                        id: 1,
                        title: 'UMKM',
                        desc: 'Temukan dan dukung Usaha Mikro, Kecil, dan Menengah (UMKM) di lingkungan Anda dengan menjelajahi berbagai produk dan layanan yang ditawarkan oleh para pelaku UMKM lokal.',
                    },
                    {
                        id: 2,
                        title: 'Pengaduan',
                        desc: 'Laporkan masalah, permasalahan lingkungan, atau hal-hal lain yang memerlukan perhatian pihak berwenang dengan mudah melalui fitur pengaduan yang disediakan.',
                    },
                    {
                        id: 3,
                        title: 'Permohonan Dokumen',
                        desc: 'Ajukan permohonan dokumen administratif seperti surat keterangan, izin usaha, atau dokumen lainnya secara online dan praktis.',
                    },
                    {
                        id: 4,
                        title: 'Pendukung Keputusan',
                        desc: 'Dapatkan akses ke data dan informasi yang relevan untuk mendukung proses pengambilan keputusan di tingkat RT dengan fitur pendukung keputusan yang disediakan.',
                    },
                    {
                        id: 5,
                        title: 'Laporan Keuangan',
                        desc: 'Pantau dan kelola keuangan RT dengan lebih efisien melalui fitur yang memungkinkan Anda untuk melihat laporan keuangan secara transparan dan terperinci.',
                    },
                    {
                        id: 6,
                        title: 'Penyimpanan Dokumentasi',
                        desc: 'Simpan dan dokumentasikan berbagai kegiatan yang dilakukan di lingkungan Anda, seperti foto-foto kegiatan, agenda acara, atau catatan rapat, sehingga memudahkan untuk melacak dan mengingat kembali berbagai aktivitas yang telah dilakukan.'
                    },
                    {
                        id: 7,
                        title: 'Inventaris',
                        desc: 'Kelola dan lacak aset serta inventaris RT secara efektif dengan fitur ini. Catat dan perbarui informasi mengenai barang-barang milik RT, termasuk status, lokasi, dan kondisi setiap aset untuk memastikan pengelolaan yang efisien dan transparan.'
                    }
                ],
                selectedId: 0,
            }"
                class="flex flex-col gap-10 mt-10 lg:grid lg:grid-cols-2 lg:bg-white/40 lg:p-5 lg:rounded-xl z-30">
                <div class="grid grid-cols-3 gap-2">
                    <button @click.stop="selectedId = 0"
                        :class="selectedId === 0 ? 'bg-green-light' : 'bg-white/70 lg:bg-white/40'"
                        class="flex flex-col justify-center gap-3 rounded-lg lg:px-6 items-center py-8 active:bg-green-light/50 hover:scale-95">
                        <div>
                            <x-heroicon-o-information-circle class="w-10 h-10" />
                        </div>
                        <div>
                            <h1>
                                Pengumuman
                            </h1>
                        </div>
                    </button>
                    <button @click.stop="selectedId = 1"
                        :class="selectedId === 1 ? 'bg-green-light' : 'bg-white/70 lg:bg-white/40'"
                        class="flex flex-col justify-center gap-3 rounded-lg lg:px-6 items-center py-8 active:bg-green-light/50 hover:scale-95"">
                        <div>
                            <x-heroicon-o-building-storefront class="w-10 h-10" />
                        </div>
                        <div>
                            <h1>
                                UMKM
                            </h1>
                        </div>
                    </button>
                    <button @click.stop="selectedId = 2"
                        :class="selectedId === 2 ? 'bg-green-light' : 'bg-white/70 lg:bg-white/40'"
                        class="flex flex-col justify-center gap-3 rounded-lg lg:px-6 items-center py-8 active:bg-green-light/50 hover:scale-95">
                        <div>
                            <x-heroicon-o-chat-bubble-bottom-center-text class="w-10 h-10" />
                        </div>
                        <div>
                            <h1>
                                Pengaduan
                            </h1>
                        </div>
                    </button>
                    <button @click.stop="selectedId = 3"
                        :class="selectedId === 3 ? 'bg-green-light' : 'bg-white/70 lg:bg-white/40'"
                        class="flex flex-col justify-center gap-3 rounded-lg lg:px-6 items-center py-8 active:bg-green-light/50 hover:scale-95">
                        <div>
                            <x-heroicon-o-document class="w-10 h-10" />
                        </div>
                        <div>
                            <h1>
                                Permohonan Dokumen
                            </h1>
                        </div>
                    </button>
                    <button @click.stop="selectedId = 4"
                        :class="selectedId === 4 ? 'bg-green-light' : 'bg-white/70 lg:bg-white/40'"
                        class="flex flex-col justify-center gap-3 rounded-lg lg:px-6 items-center py-8 active:bg-green-light/50 hover:scale-95">
                        <div>
                            <x-heroicon-o-scale class="w-10 h-10" />
                        </div>
                        <div>
                            <h1>
                                Pendukung Keputusan
                            </h1>
                        </div>
                    </button>
                    <button @click.stop="selectedId = 5"
                        :class="selectedId === 5 ? 'bg-green-light' : 'bg-white/70 lg:bg-white/40'"
                        class="flex flex-col justify-center gap-3 rounded-lg lg:px-6 items-center py-8 px-2 active:bg-green-light/50 hover:scale-95">
                        <div>
                            <x-heroicon-o-banknotes class="w-10 h-10" />
                        </div>
                        <div>
                            <h1>
                                Laporan Keuangan
                            </h1>
                        </div>
                    </button>
                    <button @click.stop="selectedId = 6"
                        :class="selectedId === 6 ? 'bg-green-light' : 'bg-white/70 lg:bg-white/40'"
                        class="flex flex-col justify-center gap-3 rounded-lg lg:px-6 items-center py-8 active:bg-green-light/50 hover:scale-95">
                        <div>
                            <x-heroicon-o-folder class="w-10 h-10" />
                        </div>
                        <div>
                            <h1>
                                Penyimpanan Dokumentasi
                            </h1>
                        </div>
                    </button>
                    <button @click.stop="selectedId = 7"
                        :class="selectedId === 7 ? 'bg-green-light' : 'bg-white/70 lg:bg-white/40'"
                        class="flex flex-col col-start-2 justify-center gap-3 rounded-lg lg:px-6 items-center py-8 active:bg-green-light/50 hover:scale-95">
                        <div>
                            <x-heroicon-o-archive-box class="w-10 h-10" />
                        </div>
                        <div>
                            <h1>
                                Inventaris
                            </h1>
                        </div>
                    </button>
                </div>
                <div class="flex flex-col rounded-3xl bg-white/40 relative ">
                    <div class="p-10 h-72">
                        <div>
                            <h1 class="text-center font-bold text-[1.618rem]/[2.618rem]"
                                x-text="data[selectedId].title"></h1>
                        </div>
                        <div class="mt-5">
                            <p x-text="data[selectedId].desc" class="text-[1rem]/[1.618rem]"></p>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <img src="{{ asset('assets/images/undraw_join_re_w1lh.svg') }}" alt=""
                            class="h-60">
                    </div>
                </div>
            </div>
        </section>
        {{-- End of Feature --}}

        @if (count($informations) > 0)
            {{-- Start of News --}}
            <section class="w-full max-w-7xl mx-auto">
                <div class="flex justify-between items-center">
                    <h1 class="text-[1.618rem]/[2.618rem] font-bold lg:text-[2.618rem]/[3.618rem]">Berita</h1>
                    <a href="/berita"
                        class="px-6 py-3 bg-soft-snow text-navy-night rounded-full gap-x-5 border border-navy-night flex justify-center items-center hover:bg-green-light transition-all duration-300">Lihat
                        Semua <span class="inline-block p-3 bg-green-light rounded-full"><x-heroicon-o-arrow-up-right
                                class="w-5 h-5" /></span></a>
                </div>
                <div
                    class="grid grid-row-4 grid-cols-1 mt-10 gap-5 lg:grid-rows-[repeat(2,minmax(0,27rem))] lg:grid-cols-3 lg:gap-y-10">
                    @foreach ($informations as $key => $information)
                        @if ($key % 2 == 0)
                            <a href="{{ url('berita/' . $information->informasi_id) }}" class="lg:row-span-2 group">
                                <div class="relative h-72 lg:h-[44.5rem]">
                                    <img src="{{ strpos($information->thumbnail_url, 'http') === 0 ? $information->thumbnail_url : asset('storage/images_storage/' . $information->thumbnail_url) }}"
                                        loading="lazy" alt="" class="rounded-xl w-full h-full object-cover">
                                    <div
                                        class="absolute bottom-3 left-3 z-10 rounded-full text-[1rem]/[1.618rem] text-soft-snow px-6 py-3 bg-navy-night/50 backdrop-blur-3xl flex gap-3">
                                        <x-heroicon-o-calendar-days class="w-6 h-6" />
                                        <p>
                                            {{ $information->created_at->format('d F Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="py-3">
                                    @php
                                        $judul = Str::limit($information->judul_informasi, 50, '...');
                                    @endphp
                                    <h1 class="font-bold text-[1.618rem]/[2.618rem] group-hover:underline">
                                        {{ $judul }}
                                    </h1>
                                    @php
                                        $excerpt = Str::limit($information->excerpt, 100, '...');
                                    @endphp
                                    <p class="text-[1rem]/[1.618rem] break-words">
                                        {{ Str::length($information->excerpt) > 100 ? $excerpt : $information->excerpt }}...
                                    </p>
                                </div>
                            </a>
                        @else
                            <a href="{{ url('berita/' . $information->informasi_id) }}"
                                class="lg:max-h-[27rem] group">
                                <div class="relative h-72 lg:h-[15rem]">
                                    <img src="{{ strpos($information->thumbnail_url, 'http') === 0 ? $information->thumbnail_url : asset('storage/images_storage/' . $information->thumbnail_url) }}"
                                        loading="lazy" alt="" class="rounded-xl w-full h-full object-cover">
                                    <div
                                        class="absolute bottom-3 left-3 z-10 rounded-full text-[1rem]/[1.618rem] text-soft-snow px-6 py-3 bg-navy-night/50 backdrop-blur-3xl flex gap-3">
                                        <x-heroicon-o-calendar-days class="w-6 h-6" />
                                        <p>
                                            {{ $information->created_at->format('d F Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="py-3">
                                    @php
                                        $judul = Str::limit($information->judul_informasi, 50, '...');
                                        $excerpt = Str::limit($information->excerpt, 100, '...');
                                    @endphp
                                    <h1 class="font-bold text-[1.618rem]/[2.618rem] group-hover:underline">
                                        {{ $judul }}
                                    </h1>
                                    <p class="text-[1rem]/[1.618rem] break-words">
                                        {{ Str::length($information->excerpt) > 100 ? $excerpt : $information->excerpt }}...
                                    </p>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </section>
            {{-- End of News --}}
        @endif
    </div>


    <x-scripts.swipper></x-scripts.swipper>
</x-guest-layout>
