<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-gray-200/50 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <svg viewBox="0 0 100 100" class="w-10 h-10" xmlns="http://www.w3.org/2000/svg">
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
                        <span class="font-heading font-extrabold text-3xl tracking-tight text-transparent bg-clip-text bg-gradient-to-br from-[#542d91] to-purple-500">SimpleShop</span>
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
                            <x-nav-link :href="route('seller.orders.index')" :active="request()->routeIs('seller.orders.*')" class="relative flex items-center">
                                {{ __('Pesanan') }}
                                @if(auth()->user()->hasActiveSellerOrders())
                                    <span class="ml-1.5 w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                                @endif
                            </x-nav-link>
                            <x-nav-link :href="route('seller.withdrawals.index')" :active="request()->routeIs('seller.withdrawals.*')">
                                {{ __('Penarikan Dana') }}
                            </x-nav-link>
                        @endif

                        @if(auth()->user()->isBuyer())
                            <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                                {{ __('Keranjang') }}
                            </x-nav-link>
                            <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')" class="relative flex items-center">
                                {{ __('Pesanan Saya') }}
                                @if(auth()->user()->hasActiveBuyerOrders())
                                    <span class="ml-1.5 w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                                @endif
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <!-- Notifications Dropdown -->
                    <div class="relative mr-3">
                        <x-dropdown align="right" width="w-80">
                            <x-slot name="trigger">
                                <button class="relative p-2 text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <span id="unread-count-badge" class="absolute top-1 right-1 flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-red-500 rounded-full">
                                            {{ auth()->user()->unreadNotifications->count() }}
                                        </span>
                                    @endif
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-3 border-b flex justify-between items-center bg-gray-50 rounded-t-md">
                                    <h3 class="text-sm font-semibold text-gray-800">Notifikasi</h3>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <form method="POST" action="{{ route('notifications.readAll') }}"
                                              @click.stop
                                              @submit.prevent="
                                                fetch($el.action, { method: 'POST', body: new FormData($el) })
                                                .then(response => {
                                                    if(response.ok) {
                                                        document.querySelectorAll('.notification-item').forEach(el => {
                                                            el.classList.add('opacity-60');
                                                            el.classList.remove('bg-indigo-50/50');
                                                            let checkBtn = el.querySelector('.read-btn-form');
                                                            if(checkBtn) checkBtn.remove();
                                                        });
                                                        let badge = document.getElementById('unread-count-badge');
                                                        if(badge) badge.remove();
                                                        $el.remove();
                                                    }
                                                })
                                              ">
                                            @csrf
                                            <button type="submit" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Tandai semua dibaca</button>
                                        </form>
                                    @endif
                                </div>
                                <div class="max-h-80 overflow-y-auto">
                                    @forelse(auth()->user()->notifications as $notification)
                                        <div class="notification-item px-4 py-3 border-b hover:bg-gray-50 transition flex gap-3 relative group {{ $notification->read_at ? 'opacity-60' : 'bg-indigo-50/50' }}">
                                            <div class="flex-1 min-w-0">
                                                <a href="{{ route('notifications.click', $notification->id) }}" class="block">
                                                    <p class="text-sm text-gray-800 mb-1 hover:text-indigo-600 transition-colors">
                                                        {{ $notification->data['message'] ?? 'Ada pemberitahuan baru' }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                                                </a>
                                            </div>
                                            <div class="flex items-start gap-1 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                                                @if(!$notification->read_at)
                                                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="read-btn-form"
                                                          @click.stop
                                                          @submit.prevent="
                                                              fetch($el.action, { method: 'POST', body: new FormData($el) })
                                                              .then(response => {
                                                                  if(response.ok) {
                                                                      let container = $el.closest('.notification-item');
                                                                      container.classList.add('opacity-60');
                                                                      container.classList.remove('bg-indigo-50/50');
                                                                      let badge = document.getElementById('unread-count-badge');
                                                                      if(badge) {
                                                                          let count = parseInt(badge.innerText) - 1;
                                                                          if(count > 0) { badge.innerText = count; }
                                                                          else { 
                                                                              badge.remove(); 
                                                                              let markAll = document.querySelector('form[action*=\'/read-all\']'); if(markAll) markAll.remove();
                                                                          }
                                                                      }
                                                                      $el.remove();
                                                                  }
                                                              })
                                                          ">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="p-1 text-indigo-600 hover:text-indigo-800" title="Tandai dibaca">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        </button>
                                                    </form>
                                                @endif
                                                <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}"
                                                      @click.stop
                                                      @submit.prevent="
                                                          fetch($el.action, { method: 'POST', body: new FormData($el) })
                                                          .then(response => {
                                                              if(response.ok) {
                                                                  let container = $el.closest('.notification-item');
                                                                  let isUnread = !container.classList.contains('opacity-60');
                                                                  container.remove();
                                                                  if(isUnread) {
                                                                      let badge = document.getElementById('unread-count-badge');
                                                                      if(badge) {
                                                                          let count = parseInt(badge.innerText) - 1;
                                                                          if(count > 0) { badge.innerText = count; }
                                                                          else {
                                                                              badge.remove();
                                                                              let markAll = document.querySelector('form[action*=\'/read-all\']'); if(markAll) markAll.remove();
                                                                          }
                                                                      }
                                                                  }
                                                              }
                                                          })
                                                      ">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1 text-red-600 hover:text-red-800" title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="px-4 py-6 text-center text-sm text-gray-500">
                                            Tidak ada notifikasi.
                                        </div>
                                    @endforelse
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center overflow-hidden shrink-0 border border-gray-200">
                                        <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="text-left">
                                        <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                                        <div class="text-xs text-primary-600 font-medium">{{ ucfirst(Auth::user()->role) }}</div>
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
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-primary-600 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-gray-900 rounded-xl hover:bg-gray-800 transition shadow-md hover:shadow-xl hover:-translate-y-0.5 duration-200">Daftar</a>
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
                    <x-responsive-nav-link :href="route('seller.withdrawals.index')" :active="request()->routeIs('seller.withdrawals.*')">
                        {{ __('Penarikan Dana') }}
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
            <div class="px-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center overflow-hidden shrink-0 border border-gray-200">
                    <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
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
