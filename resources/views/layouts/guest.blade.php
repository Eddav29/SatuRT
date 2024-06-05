<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-seo />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            font-size: 13px
        }

        @media (min-width: 640px) {
            :root {
                font-size: 15px
            }
        }

        @media (min-width: 768px) {
            :root {
                font-size: 17px
            }
        }
    </style>
    @stack('styles')
</head>

<body class="font-poppins text-gray-900 antialiased bg-soft-snow">
    @include('layouts.guest-navigation')
    <div class="mx-auto max-lg:pb-20 px-7 pt-4 md:px-8 overflow-x-hidden">
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        @include('layouts.guest-footer')
    </div>

    @stack('scripts')
</body>


</html>
