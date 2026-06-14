<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="text-lg font-bold text-gray-800">SimpleShop</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                        {{ __('Katalog') }}
                    </x-nav-link>

                    @auth
                        @if(auth()->user()->isSeller())
                            <x-nav-link :href="route('seller.dashboard')" :active="request()->routeIs('seller.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('seller.products.index')" :active="request()->routeIs('seller.products.*')">
                                {{ __('Produk Saya') }}
                            </x-nav-link>
                            <x-nav-link :href="route('seller.orders.index')" :active="request()->routeIs('seller.orders.*')">
                                {{ __('Pesanan') }}
                            </x-nav-link>
                        @endif

                        @if(auth()->user()->isBuyer())
                            <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                                {{ __('Keranjang') }}
                            </x-nav-link>
                            <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                                {{ __('Pesanan Saya') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <span class="text-indigo-600 font-semibold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                    </div>
                                    <div class="text-left">
                                        <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                                        <div class="text-xs text-gray-400">{{ ucfirst(Auth::user()->role) }}</div>
                                    </div>
                                </div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profil') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Keluar') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-indigo-700 transition">Daftar</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                {{ __('Katalog') }}
            </x-responsive-nav-link>

            @auth
                @if(auth()->user()->isSeller())
                    <x-responsive-nav-link :href="route('seller.dashboard')" :active="request()->routeIs('seller.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('seller.products.index')" :active="request()->routeIs('seller.products.*')">
                        {{ __('Produk Saya') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('seller.orders.index')" :active="request()->routeIs('seller.orders.*')">
                        {{ __('Pesanan') }}
                    </x-responsive-nav-link>
                @endif

                @if(auth()->user()->isBuyer())
                    <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                        {{ __('Keranjang') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                        {{ __('Pesanan Saya') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @else
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="space-y-1 px-4">
                <a href="{{ route('login') }}" class="block py-2 text-sm text-gray-600">Masuk</a>
                <a href="{{ route('register') }}" class="block py-2 text-sm text-indigo-600 font-medium">Daftar</a>
            </div>
        </div>
        @endauth
    </div>
</nav>
