<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SIP-Salam Indah Post</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            <div class="min-h-screen flex flex-col justify-center items-center bg-slate-200 p-4 sm:p-6">
                
                <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[500px]">
                    
                    <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-cyan-400 via-blue-500 to-indigo-600 flex-col justify-center items-center p-10 text-white relative overflow-hidden">
                        <div class="absolute inset-0 opacity-15 bg-[url('path_ke_gambar_wave.png')] bg-cover"></div>
                        <div class="z-10 text-center flex flex-col items-center w-full px-4">
                            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6 mb-8">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo SIP" 
                                    class="h-16 sm:h-20 md:h-24 w-auto object-contain filter drop-shadow-[0_4px_8px_rgba(0,0,0,0.2)] transition-transform duration-300 hover:scale-105">                      
                                
                                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.2)] text-center sm:text-left leading-tight">
                                    <span class="block whitespace-nowrap">Salam Indah</span>
                                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 to-blue-300 font-extrabold mt-0.5 sm:mt-1">Post</span>
                                </h2>
                            </div>
                            
                            <p class="text-xs sm:text-sm text-blue-50 font-medium max-w-md md:max-w-xl mx-auto leading-relaxed bg-white/10 backdrop-blur-lg p-4 sm:p-5 px-6 sm:px-8 rounded-2xl border border-white/25 shadow-[0_8px_32px_0_rgba(31,38,135,0.15)]">
                                Sistem informasi pemesanan produk percetakan berbasis web 
                                <span class="block sm:inline font-bold text-white underline decoration-cyan-300 decoration-2 underline-offset-4 mt-1 sm:mt-0">
                                    CV Salam Indah Group
                                </span>
                            </p> 
                        </div>
                    </div>

                    <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-8 sm:p-12 bg-white">
                        <div class="md:hidden mb-6 text-center">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo SIP" 
                                class="h-16 md:h-20 w-auto object-contain filter drop-shadow-lg"> 
                        </div>

                        <div class="w-full max-w-sm">
                            {{ $slot }}
                        </div>
                    </div>

                </div> 
            </div>
        </div>
    </body>
</html>