<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 ">
    <!-- Primary Navigation Menu -->
    <div class="py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <div class="w-28 md:w-40 flex">
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
<div class="fixed z-20 bottom-0 left-0 w-screen bg-white md:hidden select-none">
    <div class="grid grid-cols-3 gap-y-5">

        <div
            class="py-4 flex justify-center  font-semibold leading-8 hover:bg-orange-400">
            <x-nav-link :active="request()->routeIs('home')" :href="route('home')" icon="fa-solid fa-shop">
                {{ __('Home') }}
            </x-nav-link>
        </div>


        <div
            class="py-4 flex justify-center  font-semibold leading-8 hover:bg-orange-400">
            <x-nav-link :active="request()->routeIs('berita')" :href="route('berita')" icon="fa-solid fa-shop">
                {{ __('Berita') }}
            </x-nav-link>
        </div>

        <div
            class="py-4 flex justify-center  font-semibold leading-8 hover:bg-orange-400">
            <x-nav-link :active="request()->routeIs('usaha')" :href="route('usaha')" icon="fa-solid fa-shop">
                {{ __('Usaha') }}
            </x-nav-link>
        </div>

    </div>
</div>
