<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Rekening Bank') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Perbarui informasi rekening bank untuk tujuan penarikan dana. Dibutuhkan konfirmasi password untuk mengubah data ini demi keamanan.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update-bank-account') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="bank_name" :value="__('Nama Bank Tujuan')" />
            <select id="bank_name" name="bank_name" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="" disabled {{ old('bank_name', $user->bank_name) ? '' : 'selected' }}>-- Pilih Bank --</option>
                @php
                    $banks = ['BCA', 'Bank Mandiri', 'BNI', 'BRI', 'BSI', 'CIMB Niaga', 'Permata Bank', 'Bank Danamon', 'BTN', 'Bank Jago', 'SeaBank', 'Bank Neo Commerce'];
                @endphp
                @foreach($banks as $bank)
                    <option value="{{ $bank }}" {{ old('bank_name', $user->bank_name) === $bank ? 'selected' : '' }}>{{ $bank }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->updateBankAccount->get('bank_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="bank_account_number" :value="__('Nomor Rekening')" />
            <x-text-input id="bank_account_number" name="bank_account_number" type="text" class="mt-1 block w-full" :value="old('bank_account_number', $user->bank_account_number)" required autocomplete="off" />
            <x-input-error :messages="$errors->updateBankAccount->get('bank_account_number')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="bank_account_name" :value="__('Nama Pemilik Rekening')" />
            <x-text-input id="bank_account_name" name="bank_account_name" type="text" class="mt-1 block w-full" :value="old('bank_account_name', $user->bank_account_name)" required autocomplete="off" />
            <x-input-error :messages="$errors->updateBankAccount->get('bank_account_name')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center gap-2 mb-1">
                <x-input-label for="bank_password" :value="__('Password Akun Aplikasi Anda')" class="mb-0" />
                <div class="relative flex items-center group cursor-help">
                    <svg class="w-4 h-4 text-gray-400 hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <!-- Tooltip -->
                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 p-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-10 text-center shadow-lg pointer-events-none">
                        Masukkan password login aplikasi Anda untuk verifikasi. <strong>JANGAN PERNAH</strong> memasukkan PIN ATM atau Password M-Banking Anda di kolom ini.
                        <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-900"></div>
                    </div>
                </div>
            </div>
            <x-text-input id="bank_password" name="password" type="password" class="block w-full" required autocomplete="current-password" placeholder="Masukkan password login Anda..." />
            <x-input-error :messages="$errors->updateBankAccount->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'bank-account-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
