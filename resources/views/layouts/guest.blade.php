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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased relative min-h-screen overflow-hidden bg-slate-50">
        <!-- Background Decorative Blobs -->
        <div class="absolute top-[-10%] left-[-10%] w-[40rem] h-[40rem] bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
        <div class="absolute top-[10%] right-[-5%] w-[35rem] h-[35rem] bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob [animation-delay:4000ms]"></div>
        <div class="absolute bottom-[-10%] left-[15%] w-[45rem] h-[45rem] bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob [animation-delay:8000ms]"></div>

        <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 relative z-10 px-4">
            <div class="mb-10 text-center">
                <a href="/" class="inline-flex flex-col items-center gap-4 group">
                    <div class="p-4 bg-white/60 backdrop-blur-md rounded-3xl shadow-sm border border-white/50 group-hover:shadow-md group-hover:scale-105 transition-all duration-300">
                        <x-application-logo class="w-16 h-16" />
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <span class="font-heading font-extrabold text-3xl tracking-tight text-transparent bg-clip-text bg-gradient-to-br from-[#542d91] to-purple-500">
                            SimpleShop
                        </span>
                        <span class="text-sm font-medium text-gray-500 tracking-wide">Solusi Belanja Kebutuhan Anda</span>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-white/70 backdrop-blur-xl shadow-2xl overflow-hidden sm:rounded-[2rem] border border-white/60">
                {{ $slot }}
            </div>
            
            <div class="mt-12 text-center text-sm font-medium text-gray-500">
                &copy; {{ date('Y') }} SimpleShop. Crafted with precision.
            </div>
        </div>
        @livewireScripts
    </body>
</html>
