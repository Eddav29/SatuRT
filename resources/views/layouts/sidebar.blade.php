<aside
    class="absolute left-0 top-0 z-[9999] flex h-screen w-80 flex-col overflow-y-hidden bg-soft-snow duration-300 ease-linear lg:static lg:translate-x-0 border border-l px-8"
    :class="sidebar ? 'translate-x-0' : '-translate-x-full'" @click.outside="sidebar = false">
    <div class="flex justify-center items-center gap-x-5 w-full py-10">
        <div class="shrink-0">
            <div>
                <x-application-logo class="w-auto h-auto text-navy-night " />
            </div>
        </div>
        <div class="w-10 h-10 lg:hidden">
            <button class="w-10 h-10" @click.stop="sidebar = !sidebar">
                @svg('heroicon-c-bars-3-center-left')
            </button>
        </div>
    </div>


    @if (Auth::check())
        @if (Auth::user()->role->role_name === 'Ketua RT')
            <div class="overflow-y-auto pt-10 lg:pt-24 no-scrollbar">
                <h1 class="text-navy-night/35 ">MAIN MENU</h1>

                <div x-data="{ selected: '' }" class="py-5">
                    <nav>
                        <div>
                            <x-nav-menu :href="route('dashboard')" :active="request()->routeIs('dashboard')" svgIcon="heroicon-o-squares-2x2"
                                iconStyle="h-8 w-8">
                                Dashboard
                            </x-nav-menu>
                        </div>
                        <div>
                            <x-nav-menu svgIcon="heroicon-o-banknotes" :href="route('keuangan.index')" :active="request()->routeIs('keuangan.index') ||
                                request()->routeIs('keuangan.show') ||
                                request()->routeIs('keuangan.edit') ||
                                request()->routeIs('keuangan.create')"
                                iconStyle="h-8 w-8">
                                Keuangan
                            </x-nav-menu>
                        </div>
                        <div @click.prevent="selected = selected === 'Penduduk' ? '' : 'Penduduk'">
                            <x-nav-menu svgIcon="heroicon-o-user-group" iconStyle="h-8 w-8">
                                Data Penduduk
                                <div class="w-5 h-5 ml-10" :class="selected === 'Penduduk' ? 'rotate-180' : ''">
                                    <x-heroicon-o-chevron-down />
                                </div>
                            </x-nav-menu>
                        </div>
                        <div :class="selected === 'Penduduk' ? 'block' : 'hidden'">
                            <div class="pl-11 py-1">
                                <x-nav-menu :href="url('data-penduduk/keluarga')" :active="request()->is('data-penduduk/*')">
                                    Data Penduduk
                                </x-nav-menu>
                            </div>
                            <div class="pl-11 py-1">
                                <x-nav-menu :href="url('data-akun/penduduk')" :active="request()->is('data-akun/*')">
                                    Data Akun
                                </x-nav-menu>
                            </div>
                        </div>
                        <div>
                            <x-nav-menu :href="route('umkm.index')" :active="request()->is('umkm*')" svgIcon="heroicon-o-building-storefront"
                                iconStyle="h-8 w-8">
                                UMKM
                            </x-nav-menu>
                        </div>
                        <div>
                            <x-nav-menu :href="route('persuratan.index')" :active="request()->is('persuratan*')" svgIcon="heroicon-o-document-text"
                                iconStyle="h-8 w-8">
                                Permohonan Surat
                            </x-nav-menu>
                        </div>
                        <div>
                            <x-nav-menu svgIcon="heroicon-o-scale" iconStyle="h-8 w-8">
                                Pendukung Keputusan
                            </x-nav-menu>
                        </div>
                        <div>
                            <x-nav-menu svgIcon="heroicon-o-microphone" :href="route('informasi.index')" :active="request()->is('informasi*')"
                                iconStyle="h-8 w-8">
                                Informasi
                            </x-nav-menu>
                        </div>
                        <div>
                            <x-nav-menu svgIcon="heroicon-o-megaphone" iconStyle="h-8 w-8" :href="route('pelaporan.index')"
                                :active="request()->is('pelaporan*')">
                                Laporan Warga
                            </x-nav-menu>
                        </div>

                    </nav>
                </div>
            </div>
        @elseif(Auth::user()->role->role_name === 'Penduduk')
            <div class="overflow-y-auto pt-10 lg:pt-24 no-scrollbar">
                <h1 class="text-navy-night/35 ">MAIN MENU</h1>
                <div class="py-5">
                    <nav>
                        <div>
                            <x-nav-menu :href="route('dashboard')" :active="request()->routeIs('dashboard')" svgIcon="heroicon-o-squares-2x2"
                                iconStyle="h-8 w-8">
                                Dashboard
                            </x-nav-menu>
                        </div>
                        <div>
                            <x-nav-menu svgIcon="heroicon-o-user-group"
                                iconStyle="h-8 w-8">
                                Data Keluarga
                            </x-nav-menu>
                        </div>
                        <div>
                            <x-nav-menu :href="route('umkm.index')" :active="request()->is('umkm*')" svgIcon="heroicon-o-building-storefront"
                                iconStyle="h-8 w-8">
                                UMKM
                            </x-nav-menu>
                        </div>
                        <div>
                            <x-nav-menu svgIcon="heroicon-o-document-text" iconStyle="h-8 w-8">
                                Permohonan Surat
                            </x-nav-menu>
                        </div>
                        <div>
                            <x-nav-menu svgIcon="heroicon-o-megaphone" iconStyle="h-8 w-8" :href="route('pelaporan.index')"
                                :active="request()->is('pelaporan*')">
                                LAPOR!
                            </x-nav-menu>
                        </div>

                    </nav>
                </div>
            </div>
        @endif
    @endif
    {{-- Main Menu --}}
</aside>
