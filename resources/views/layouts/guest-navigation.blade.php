<nav x-data="{ open: false }" class="bg-soft-snow border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="py-4 px-4 sm:px-6 lg:px-8 max-w-screen-xl m-auto">
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
                <x-nav-link :href="route('berita')" :active="request()->routeIs('berita')">
                    {{ __('Berita') }}
                </x-nav-link>
                <x-nav-link :href="route('usaha')" :active="request()->routeIs('usaha')">
                    {{ __('Usaha') }}
                </x-nav-link>
            </div>
            <div class="flex items-center">
                <x-nav-button theme="light" :href="route('home')">
                    {{ __('Login') }}
                </x-nav-button>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Navigation -->
<div
    class="fixed z-20 bottom-0 left-0 w-screen bg-soft-snow md:hidden select-none rounded-tl-2xl rounded-tr-2xl shadow-[2px_3px_18.8px_0px_rgba(11,18,21,0.3)]">
    <div class="grid grid-cols-3 gap-y-5">

        <div class="py-2 flex justify-center font-semibold leading-8 hover:text-azure-blue">
            <x-nav-link :active="request()->routeIs('home')" :href="route('home')" svgIcon="heroicon-o-home" iconStyle="h-8 w-8">
                {{ __('Home') }}
            </x-nav-link>
        </div>


        <div class="py-2 flex justify-center font-semibold leading-8 hover:text-azure-blue">
            <x-nav-link :active="request()->routeIs('berita')" :href="route('berita')" svgIcon="heroicon-o-newspaper" iconStyle="h-8 w-8">
                {{ __('Berita') }}
            </x-nav-link>
        </div>

        <div class="py-2 flex justify-center font-semibold leading-8 hover:text-azure-blue">
            <x-nav-link :active="request()->routeIs('usaha')" :href="route('usaha')" svgIcon="heroicon-o-shopping-bag" iconStyle="h-8 w-8">
                {{ __('Usaha') }}
            </x-nav-link>
        </div>

    </div>
</div>
