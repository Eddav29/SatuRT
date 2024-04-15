<nav x-data="{ open: false, search: false }" class="bg-soft-snow px-7 border-b border-gray-100 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="py-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}">
                    <div class="w-28 md:w-38 flex">
                        <x-application-logo class="w-auto h-auto text-gray-800 " />
                    </div>
                </a>
            </div>
            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 md:flex">
                <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    {{ __('Home') }}
                </x-nav-link>
                <x-nav-link :href="route('berita')" :active="request()->routeIs('berita') || request()->routeIs('berita-detail')">
                    {{ __('Berita') }}
                </x-nav-link>
                <x-nav-link :href="route('usaha')" :active="request()->routeIs('usaha') || request()->routeIs('usaha-detail')">
                    {{ __('Usaha') }}
                </x-nav-link>
            </div>
            <div class="flex items-center gap-x-5">
                <button @click.stop="search = !search"
                    class="{{ request()->routeIs('berita') || request()->routeIs('berita-detail') ? 'block' : 'hidden' }} max-lg:hidden">
                    <x-heroicon-o-magnifying-glass class="w-8 h-8" />
                </button>
                <x-nav-button theme="dark" :class="'rounded-lg'" :href="route('login')">
                    {{ __('Login') }}
                </x-nav-button>
            </div>

            {{-- Search Dropdown --}}
            <div x-show="search" x-transition:enter.duration.500ms x-transition:leave.duration.400ms
                class=" absolute inset-0 w-full mx-auto h-screen -z-10 bg-white/10">
                <div class="absolute inset-0 w-full mx-auto h-[20rem] bg-white" id="search">
                    <form id="searchForm" action="{{ route('berita') }}"
                        class="w-full max-w-7xl mx-auto h-full flex justify-center items-center relative">
                        @if (request('jfsi'))
                            <input type="hidden" name="jfsi" value="{{ request('jfsi') }}">
                        @endif
                        <input type="text" name="search" id="search" placeholder="Cari Berita"
                            class="w-3/4 inline-block px-4 py-4 ring-0 outline-none border-0 rounded-xl bg-gray-100">
                        <button type="submit">
                            <x-heroicon-o-magnifying-glass class="w-8 h-8 absolute top-1/2 right-44 -translate-y-1/2" />
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Navigation -->
<div
    class="fixed z-[99999999] bottom-0 left-0 w-screen bg-soft-snow md:hidden select-none rounded-tl-2xl rounded-tr-2xl shadow-[2px_3px_18.8px_0px_rgba(11,18,21,0.3)]">
    <div class="grid grid-cols-3 gap-y-5">

        <div class="py-2 flex justify-center font-semibold leading-8 hover:text-azure-blue">
            <x-nav-link :active="request()->routeIs('home')" :href="route('home')" svgIcon="heroicon-o-home" iconStyle="h-8 w-8">
                {{ __('Home') }}
            </x-nav-link>
        </div>


        <div class="py-2 flex justify-center font-semibold leading-8 hover:text-azure-blue">
            <x-nav-link :active="request()->routeIs('berita') || request()->routeIs('berita-detail')" :href="route('berita')" svgIcon="heroicon-o-newspaper" iconStyle="h-8 w-8">
                {{ __('Berita') }}
            </x-nav-link>
        </div>

        <div class="py-2 flex justify-center font-semibold leading-8 hover:text-azure-blue">
            <x-nav-link :active="request()->routeIs('usaha') || request()->routeIs('usaha-detail')" :href="route('usaha')" svgIcon="heroicon-o-shopping-bag" iconStyle="h-8 w-8">
                {{ __('Usaha') }}
            </x-nav-link>
        </div>

    </div>
</div>
