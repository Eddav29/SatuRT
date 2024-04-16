<aside
    class="absolute left-0 top-0 z-[9999] flex h-screen w-80 flex-col overflow-y-hidden bg-soft-snow duration-300 ease-linear lg:static lg:translate-x-0 border border-l px-8"
    :class="sidebar ? 'translate-x-0' : '-translate-x-full'" @click.outside="sidebar = false">

    {{-- Main Menu --}}
    <div class="overflow-y-auto pt-10 lg:pt-24 no-scrollbar">
        <h1 class="text-navy-night/35 ">Profile</h1>


        <div x-data="{ selected: '' }" class="py-5">
            <nav>

                <div x-data="{ profile: false }" class="cursor-pointer flex items-center my-3">
                    <div @click.stop="profile = !profile" class="h-14 w-14 rounded-full overflow-hidden">
                        <img class="h-full w-full object-cover" src="{{ asset('assets/images/milad-fakurian-PGdW_bHDbpI-unsplash.jpg') }}" alt="">
                    </div>
                    <div class="ml-4 flex flex-col justify-between h-full">
                        <div class="flex-grow">
                            <div class="text-sm">Hallo</div>
                        </div>
                        <div>
                            <div class="text-sm font-bold">{{ Auth::user()->name ?? '' }}</div>
                        </div>
                    </div>
                </div>


                <div>
                    <x-nav-menu svgIcon="heroicon-o-identification" iconStyle="h-8 w-8" :href="route('profile')" :active="request()->routeIs('profile') ||
                        request()->routeIs('profile.complete-data')">
                        Biodata
                    </x-nav-menu>
                </div>

                <div>
                    <x-nav-menu svgIcon="heroicon-o-key" iconStyle="h-8 w-8" :href="route('profile.change-password')" :active="request()->routeIs('profile.change-password')">
                        Ubah Kata Sandi
                    </x-nav-menu>
                </div>

            </nav>
        </div>
    </div>
</aside>
