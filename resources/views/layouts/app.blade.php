<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @stack('links')
    @stack('styles')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Styles --}}
    @stack('styles')
</head>

<body class="font-poppins antialiased bg-soft-snow">
    <div x-data="{ sidebar: false }" class="h-screen flex overflow-hidden" x-cloak>
        <x-notification />
        @if (Auth::user()->password_changed_at == null)
            @include('layouts.change-password')
        @endif
        {{-- <x-change-password /> --}}
        @include('layouts.sidebar')

        <!-- Page Content -->
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
            <!-- Page Heading -->
            @if (isset($breadcrumb))
                <header class="p-6 lg:px-14 lg:py-8 sticky top-0 z-[999] flex w-full bg-soft-snow max-lg:drop-shadow">
                    <div class="mx-auto flex items-center justify-between lg:hidden w-full">
                        <button @click.stop="sidebar = !sidebar" class="z-50 w-10 h-10">
                            <x-heroicon-o-bars-3-bottom-left />
                        </button>
                        <div class="lg:hidden" x-data="{ profile: false }">
                            <div class="h-14 w-14 rounded-full overflow-hidden" @click.stop="profile = !profile">
                                @if (Auth::user()->penduduk->user->profile)
                                    <img src="{{ route('public', Auth::user()->penduduk->user->profile) }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <img src="{{ asset('assets/images/default.png') }}"
                                        class="h-full w-full object-cover">
                                @endif
                            </div>
                            <div class="absolute right-11 p-2" :class="profile ? 'block' : 'hidden'">
                                <div class="flex flex-col overflow-hidden rounded-lg ">
                                    <x-nav-button :href="route('profile')">
                                        {{ __('Profil') }}
                                    </x-nav-button>
                                    <x-nav-button :class="'text-red-500'" :href="route('logout')">
                                        {{ __('Logout') }}
                                    </x-nav-button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="max-lg:hidden flex justify-between items-center w-full">
                        <div>
                            <h1 class="text-5xl">Hallo {{ Auth::user()->penduduk->nama ?? '' }}</h1>
                            {{ $breadcrumb }}
                        </div>
                        <div x-data="{ profile: false }" class="cursor-pointer">
                            <div @click.stop="profile = !profile" class="h-14 w-14 rounded-full overflow-hidden">
                                @if (Auth::user()->penduduk->user->profile)
                                    <img src="{{ route('public', Auth::user()->penduduk->user->profile) }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <img src="{{ asset('assets/images/default.png') }}"
                                        class="h-full w-full object-cover">
                                @endif
                            </div>
                            <div class="absolute right-14 p-2" :class="profile ? 'block' : 'hidden'">
                                <div class="flex flex-col overflow-hidden rounded-lg ">
                                    <x-nav-button :href="route('profile')">
                                        {{ __('Profil') }}
                                    </x-nav-button>
                                    <x-nav-button :class="'text-red-500'" :href="route('logout')">
                                        {{ __('Logout') }}
                                    </x-nav-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            @endif

            @if (Auth::user()->email_verified_at == null)
                <div class="w-full bg-yellow-50 px-14 py-4 flex items-center space-x-5">
                    <x-heroicon-o-information-circle class="w-6 h-6 text-yellow-500" />
                    <p class="text-yellow-500">{{ __('Alamat email Anda belum terverifikasi.') }}</p>
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit"
                            class="text-white bg-yellow-500 px-4 py-2 rounded-md hover:bg-yellow-600">{{ __('Kirim ulang email verifikasi') }}</button>
                    </form>
                </div>
            @endif

            {{-- Content --}}
            <main>
                {{ $slot }}
            </main>

            {{-- Footer --}}
            @include('layouts.footer')
        </div>
    </div>

    {{-- Loading --}}
    <div id="loading"
        class="hidden fixed top-0 left-0 z-[9999999] h-screen w-screen items-center justify-center bg-soft-snow/30 backdrop-blur-sm">
        <div class="flex justify-center items-center gap-x-3 bg-blue-gray py-3 px-7 rounded-lg">
            <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-e-transparent align-[-0.125em] text-surface motion-reduce:animate-[spin_1.5s_linear_infinite]"
                role="status">
            </div>
            <h1>Loading...</h1>
        </div>
    </div>
    {{-- End Loading --}}

    @stack('scripts')
</body>

</html>
