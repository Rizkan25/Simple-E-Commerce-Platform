<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Penarikan Dana (Withdrawal)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm">
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Wallet Balance Card -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-center items-center">
                    <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-2">Saldo Wallet Aktif</h3>
                    <p class="text-4xl font-bold text-gray-900">Rp {{ number_format($user->balance, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-2 text-center">Dana otomatis masuk ke saldo saat pesanan pelanggan selesai.</p>
                </div>

                <!-- Withdrawal Form Card -->
                <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Buat Permintaan Penarikan Baru</h3>
                    
                    <form action="{{ route('seller.withdrawals.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <x-input-label for="amount" :value="__('Jumlah Penarikan (Rp)')" />
                            <x-text-input id="amount" name="amount" type="number" class="mt-1 block w-full" 
                                          :value="old('amount')" required autofocus min="10000" max="{{ $user->balance }}" />
                            <p class="text-xs text-gray-500 mt-1">Minimal penarikan Rp 10.000.</p>
                        </div>

                        <div>
                            <x-input-label for="bank_account" :value="__('Rekening Bank Tujuan')" />
                            <x-text-input id="bank_account" name="bank_account" type="text" class="mt-1 block w-full" 
                                          :value="old('bank_account')" required placeholder="Contoh: BCA - 123456789 - Budi Santoso" />
                        </div>

                        <div class="flex items-center gap-4 pt-2">
                            <x-primary-button :disabled="$user->balance < 10000" class="{{ $user->balance < 10000 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                {{ __('Ajukan Penarikan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Withdrawal History Table -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Penarikan Anda</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rekening Tujuan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($withdrawals as $withdrawal)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $withdrawal->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $withdrawal->bank_account }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($withdrawal->status === 'PENDING')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                        @elseif($withdrawal->status === 'APPROVED')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Disetujui</span>
                                        @elseif($withdrawal->status === 'COMPLETED')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center italic">
                                        Belum ada riwayat penarikan dana.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $withdrawals->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
