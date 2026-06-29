<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SimpleShop') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-surface min-h-screen flex flex-col">
    <!-- Navbar (Glassmorphism) -->
    <header class="fixed top-0 inset-x-0 z-50 bg-white/70 backdrop-blur-md border-b border-gray-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="/" class="flex items-center gap-2 group flex-shrink-0">
                    <svg viewBox="0 0 100 100" class="w-7 h-7 sm:w-8 sm:h-8 md:w-10 md:h-10" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="navLogoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#542d91" />
                                <stop offset="100%" stop-color="#a855f7" />
                            </linearGradient>
                        </defs>
                        <path fill="url(#navLogoGradient)" d="M85,96H15c-3.3,0-6-2.7-6-6V35c0-3.3,2.7-6,6-6h70c3.3,0,6,2.7,6,6v55C91,93.3,88.3,96,85,96z"/>
                        <ellipse cx="50" cy="29" rx="35" ry="6" fill="#3b0764" class="origin-[50px_29px] scale-y-0 group-hover:scale-y-100 transition-transform duration-500 ease-in-out" />
                        <path fill="url(#navLogoGradient)" d="M68,30H32c-1.1,0-2-0.9-2-2v-4c0-11,9-20,20-20s20,9,20,20v4C70,29.1,69.1,30,68,30z M34,26h32v-2 c0-8.8-7.2-16-16-16s-16,7.2-16,16V26z"/>
                        <path fill="white" d="M50,75c-15,0-15-12-15-12h8c0,0,1,6,7,6c5,0,7-3,7-6c0-4-3-5-10-8c-10-4-15-10-15-18c0-10,9-15,18-15 c13,0,16,10,16,10h-8c0,0-2-5-8-5c-4,0-8,2-8,6c0,4,4,5,10,7c11,3,15,9,15,18C67,69,59,75,50,75z"/>
                    </svg>
                    <span class="font-heading font-extrabold text-xl sm:text-2xl md:text-3xl tracking-tight text-transparent bg-clip-text bg-gradient-to-br from-[#542d91] to-purple-500">SimpleShop</span>
                </a>
                <nav class="flex items-center gap-2 sm:gap-4 md:gap-6 shrink-0">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-700 hover:text-primary-600 transition whitespace-nowrap">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-primary-600 transition whitespace-nowrap">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register', ['role' => 'buyer']) }}" class="px-3 py-1.5 sm:px-4 sm:py-2 md:px-5 md:py-2.5 text-sm font-semibold text-white bg-gray-900 rounded-xl hover:bg-gray-800 transition shadow-md hover:shadow-xl hover:-translate-y-0.5 duration-200 whitespace-nowrap">Register</a>
                        @endif
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <main class="flex-grow pt-20">
        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-white">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-50/50 to-surface"></div>
            <!-- Decorative blobs -->
            <div class="absolute top-0 right-0 -translate-y-12 translate-x-1/3 w-96 h-96 bg-primary-200/40 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 translate-y-1/3 -translate-x-1/3 w-72 h-72 bg-secondary-200/40 rounded-full blur-3xl"></div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-32">
                <div class="text-center max-w-3xl mx-auto">
                    <span class="inline-block py-1.5 px-4 rounded-full bg-white border border-gray-200 text-sm font-semibold text-primary-600 shadow-sm mb-8">
                        ✨ Discover the new era of shopping
                    </span>
                    <h1 class="font-heading text-5xl md:text-6xl font-extrabold text-gray-900 tracking-tight leading-tight mb-8">
                        Everything you need, <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-secondary-500">delivered to you.</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 mb-10 font-sans leading-relaxed">
                        Experience the best online shopping with premium products, secure payments, and fast delivery right to your doorstep.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('products.index') }}" class="w-full sm:w-auto px-8 py-4 text-base font-semibold text-white bg-gradient-to-r from-primary-600 to-secondary-500 rounded-2xl hover:opacity-90 transition shadow-lg shadow-primary-500/25 hover:shadow-xl hover:-translate-y-1 duration-300">
                            Start Shopping
                        </a>
                        <a href="{{ route('register', ['role' => 'seller']) }}" class="w-full sm:w-auto px-8 py-4 text-base font-semibold text-gray-700 bg-white border border-gray-200 rounded-2xl hover:bg-gray-50 transition shadow-sm hover:shadow-md hover:-translate-y-1 duration-300">
                            Become a Seller
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features / Featured Category Mock -->
        <section class="py-24 bg-surface">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="font-heading text-3xl font-bold text-gray-900 mb-4">Why shop with us?</h2>
                    <p class="text-gray-600">We provide the best experience for both buyers and sellers.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl transition-shadow duration-300 group">
                        <div class="w-14 h-14 bg-primary-50 text-primary-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-primary-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <h3 class="font-heading text-xl font-bold text-gray-900 mb-3">Premium Quality</h3>
                        <p class="text-gray-600 leading-relaxed">All products are verified by our team to ensure the highest quality standards for our customers.</p>
                    </div>
                    <!-- Feature 2 -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl transition-shadow duration-300 group">
                        <div class="w-14 h-14 bg-secondary-50 text-secondary-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-secondary-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <h3 class="font-heading text-xl font-bold text-gray-900 mb-3">Secure Payments</h3>
                        <p class="text-gray-600 leading-relaxed">Your transactions are protected with industry-leading encryption and security protocols.</p>
                    </div>
                    <!-- Feature 3 -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl transition-shadow duration-300 group">
                        <div class="w-14 h-14 bg-pink-50 text-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-pink-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="font-heading text-xl font-bold text-gray-900 mb-3">Fast Delivery</h3>
                        <p class="text-gray-600 leading-relaxed">Partnered with top logistics providers to ensure your orders arrive quickly and safely.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center text-gray-500 text-sm font-medium">
                &copy; {{ date('Y') }} SimpleShop. Crafted with precision and style.
            </div>
        </div>
    </footer>
</body>
</html>
