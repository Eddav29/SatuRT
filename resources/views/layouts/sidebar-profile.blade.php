<aside
    class="absolute left-0 top-0 z-[9999] flex h-screen w-80 flex-col overflow-y-hidden bg-soft-snow duration-300 ease-linear lg:static lg:translate-x-0 border border-l px-8"
    :class="sidebar ? 'translate-x-0' : '-translate-x-full'" @click.outside="sidebar = false">

    {{-- Main Menu --}}
    <div class="py-10 lg:pt-24 no-scrollbar h-full">
        <h1 class="text-navy-night/35">PROFILE</h1>
        <div x-data="{ selected: '' }" class="py-5 h-full">
            <nav class="h-full flex flex-col justify-between">
                <div class="flex flex-col gap-y-3">
                    <div x-data="{ profile: false }" class="cursor-pointer flex items-center my-3">
                        <div @click.stop="profile = !profile" class="h-14 w-14 rounded-full overflow-hidden">
                            @if (Auth::user()->penduduk->user->profile)
                                <img src="{{ route('public', Auth::user()->penduduk->user->profile) }}"
                                    class="h-full w-full object-cover">
                            @else
                                <img src="{{ asset('assets/images/default.png') }}"
                                    class="h-full w-full object-cover">
                            @endif
                        </div>
                        <div class="px-4 flex flex-col justify-center h-full">
                            <div>
                                <div class="text-sm">Hallo</div>
                            </div>
                            <div>
                                <div class="text-sm font-semibold">{{ Auth::user()->penduduk->nama ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <x-nav-menu svgIcon="heroicon-o-identification" iconStyle="h-8 w-8" :href="route('profile')"
                            :active="request()->routeIs('profile') || request()->routeIs('profile.complete-data')">
                            Biodata
                        </x-nav-menu>
                    </div>
                    <div>
                        <x-nav-menu svgIcon="heroicon-o-user" iconStyle="h-8 w-8" :href="route('profile.account', Auth::user()->penduduk->penduduk_id ?? '')" :active="request()->routeIs('profile.account') || request()->routeIs('profile.account.get')">
                            Akun
                        </x-nav-menu>
                    </div>
                    <div>
                        <x-nav-menu svgIcon="heroicon-o-key" iconStyle="h-8 w-8" :href="route('profile.change-password', Auth::user()->penduduk->penduduk_id ?? '')" :active="request()->routeIs('profile.change-password')">
                            Ubah Kata Sandi
                        </x-nav-menu>
                    </div>

                </div>
                <div>
                    <x-nav-menu svgIcon="heroicon-o-arrow-uturn-left" iconStyle="h-8 w-8" :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')">
                        Kembali
                    </x-nav-menu>
                </div>
            </nav>
        </div>
    </div>
</aside>
