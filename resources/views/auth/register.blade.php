<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" x-data="{ role: '{{ old('role', 'buyer') }}' }">
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
                    <div>
                        <div class="font-medium text-sm text-gray-700">🛒 Buyer</div>
                        <div class="text-xs text-gray-500">Belanja produk</div>
                    </div>
                </label>
                <label class="flex items-center gap-2 px-4 py-3 border rounded-lg cursor-pointer transition-all"
                       :class="role === 'seller' ? 'border-indigo-500 bg-indigo-50 ring-2 ring-indigo-200' : 'border-gray-300 hover:border-gray-400'">
                    <input type="radio" name="role" value="seller" x-model="role" class="text-indigo-600 focus:ring-indigo-500">
                    <div>
                        <div class="font-medium text-sm text-gray-700">🏪 Seller</div>
                        <div class="text-xs text-gray-500">Jual produk</div>
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
