<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @stack('css')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/785298cd2f.js" crossorigin="anonymous"></script>

    @stack('mp')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])



    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased flex flex-col min-h-screen">
    <x-banner />

    <div class="flex flex-col flex-grow bg-gradient-to-b from-[#1a1440] to-[#2c235d] ">
        @livewire('navigation-submenu')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <a aria-label="Chat on WhatsApp" href="https://wa.me/527293646419" target="_blank"
            class="fixed bottom-4 right-3  md:right-5 z-50 md:w-12 md:h-12 w-9 h-9 lg:w-16 lg:h-16">
            <img alt="Chat on WhatsApp" src="{{ asset('storage/whatsapp.png') }}"
                class="w-full h-full object-contain" />
        </a>

        @include('layouts.includes.app.footer')

    </div>

    @stack('modals')

    @livewireScripts

    @stack('js')
</body>

</html>