<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/785298cd2f.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    @stack('css')

</head>

<body class="font-sans antialiased flex flex-col min-h-screen">
    <x-banner />

    <div class="flex flex-col flex-grow bg-gradient-to-b from-[#1a1440] to-[#2c235d] ">
        @include('layouts.includes.instructor.navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-indigo-900 shadow ">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 mb-9">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        @include('layouts.includes.instructor.footer')
    </div>

    @stack('modals')

    @livewireScripts

    <script id=" MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        Livewire.on('swal', (data)=>{
                Swal.fire(data[0]);
    
            
            });
            
    </script>

    @stack('js')

</body>

</html>