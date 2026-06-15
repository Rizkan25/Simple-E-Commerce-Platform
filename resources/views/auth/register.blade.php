<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" x-data="{ role: '{{ old('role', request()->query('role') === 'seller' ? 'seller' : 'buyer') }}' }">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="mt-4">
            <x-input-label :value="__('Daftar Sebagai')" />
            <div class="mt-2 flex gap-4">
                <label class="flex items-center gap-2 px-4 py-3 border rounded-lg cursor-pointer transition-all"
                       :class="role === 'buyer' ? 'border-indigo-500 bg-indigo-50 ring-2 ring-indigo-200' : 'border-gray-300 hover:border-gray-400'">
                    <input type="radio" name="role" value="buyer" x-model="role" class="text-indigo-600 focus:ring-indigo-500">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 transition-colors" :class="role === 'buyer' ? 'text-indigo-600' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        <div>
                            <div class="font-medium text-sm transition-colors" :class="role === 'buyer' ? 'text-indigo-900' : 'text-gray-700'">Buyer</div>
                            <div class="text-xs transition-colors" :class="role === 'buyer' ? 'text-indigo-600' : 'text-gray-500'">Belanja produk</div>
                        </div>
                    </div>
                </label>
                <label class="flex items-center gap-2 px-4 py-3 border rounded-lg cursor-pointer transition-all"
                       :class="role === 'seller' ? 'border-indigo-500 bg-indigo-50 ring-2 ring-indigo-200' : 'border-gray-300 hover:border-gray-400'">
                    <input type="radio" name="role" value="seller" x-model="role" class="text-indigo-600 focus:ring-indigo-500">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 transition-colors" :class="role === 'seller' ? 'text-indigo-600' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75v-3.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.5c0 .414.336.75.75.75Z" />
                        </svg>
                        <div>
                            <div class="font-medium text-sm transition-colors" :class="role === 'seller' ? 'text-indigo-900' : 'text-gray-700'">Seller</div>
                            <div class="text-xs transition-colors" :class="role === 'seller' ? 'text-indigo-600' : 'text-gray-500'">Jual produk</div>
                        </div>
                    </div>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Store Name (Seller Only) -->
        <div class="mt-4" x-show="role === 'seller'" x-transition>
            <x-input-label for="store_name" :value="__('Nama Toko')" />
            <x-text-input id="store_name" class="block mt-1 w-full" type="text" name="store_name" :value="old('store_name')" />
            <x-input-error :messages="$errors->get('store_name')" class="mt-2" />
        </div>

        <!-- Store Description (Seller Only) -->
        <div class="mt-4" x-show="role === 'seller'" x-transition>
            <x-input-label for="store_description" :value="__('Deskripsi Toko (opsional)')" />
            <textarea id="store_description" name="store_description" rows="3"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">{{ old('store_description') }}</textarea>
            <x-input-error :messages="$errors->get('store_description')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
