<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SIP - Salam Indah Post</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    </head>

    {{-- Floating WA Button --}}
    @auth
        @if(Auth::user()->role === 'customer')
        <a href="https://wa.me/6282189346164?text=Halo%20Salam%20Indah%2C%20saya%20ingin%20bertanya%20mengenai%20produk%20percetakan"
            target="_blank"
            class="fixed bottom-6 right-6 z-50 flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold px-5 py-3.5 rounded-2xl shadow-lg hover:shadow-xl transition duration-200">
            <i class="fab fa-whatsapp text-2xl"></i>
            <div class="text-left">
                <p class="text-xs leading-tight opacity-80">Butuh bantuan?</p>
                <p class="text-sm leading-tight">Chat Kami</p>
            </div>
        </a>
        @endif
    @endauth

    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
