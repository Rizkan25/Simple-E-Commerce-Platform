<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 items-start">
        <div class="space-y-6">
            <form wire:submit="saveCommission">
                <x-filament::section>
                    <x-slot name="heading">
                        Keuntungan & Komisi
                    </x-slot>
                    <x-slot name="description">
                        Atur komisi otomatis yang akan dipotong dari penjual pada setiap transaksi yang berhasil.
                    </x-slot>

                    {{ $this->commissionForm }}

                    <div class="mt-6 flex justify-end">
                        <x-filament::button type="submit">
                            Simpan Komisi
                        </x-filament::button>
                    </div>
                </x-filament::section>
            </form>
        </div>

        <div class="space-y-6">
            <form wire:submit="saveBank">
                <x-filament::section>
                    <x-slot name="heading">
                        Rekening Pembayaran Platform
                    </x-slot>
                    <x-slot name="description">
                        Nomor rekening ini akan ditampilkan ke pembeli sebagai tujuan pembayaran pesanan.
                    </x-slot>

                    {{ $this->bankForm }}

                    <div class="mt-6 flex justify-end">
                        <x-filament::button type="submit">
                            Simpan Rekening
                        </x-filament::button>
                    </div>
                </form>
            </x-filament::section>
        </div>
    </div>
</x-filament-panels::page>
