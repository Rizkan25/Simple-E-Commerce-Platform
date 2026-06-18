<x-app-layout>
    @section('title', 'Edit Produk')

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Produk') }}</h2>
            <a href="{{ route('seller.products.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 transition">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <form method="POST" action="{{ route('seller.products.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">
                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Nama Produk')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div>
                            <x-input-label for="category_id" :value="__('Kategori')" />
                            <select id="category_id" name="category_id" required
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="4"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">{{ old('description', $product->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Price & Stock -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="price" :value="__('Harga (Rp)')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', $product->price)" min="0" step="100" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="stock" :value="__('Stok')" />
                                <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="old('stock', $product->stock)" min="0" required />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>
                        </div>

                        <!-- COD Enable -->
                        <div class="pt-2">
                            <label for="is_cod_enabled" class="inline-flex items-center">
                                <input id="is_cod_enabled" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_cod_enabled" value="1" {{ old('is_cod_enabled', $product->is_cod_enabled) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600 font-medium">{{ __('Aktifkan Pembayaran COD (Cash On Delivery) untuk produk ini') }}</span>
                            </label>
                        </div>

                        <!-- Discount -->
                        <div x-data="{ discountType: '{{ old('discount_type', $product->discount_type ?? '') }}' }" class="p-4 border rounded-lg bg-gray-50">
                            <h4 class="text-sm font-medium text-gray-900 mb-4">Pengaturan Diskon (Opsional)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="discount_type" :value="__('Jenis Diskon')" />
                                    <select id="discount_type" name="discount_type" x-model="discountType"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                        <option value="">Tidak ada diskon</option>
                                        <option value="percentage">Persentase (%)</option>
                                        <option value="fixed">Harga Diskon Tetap (Rp)</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('discount_type')" class="mt-2" />
                                </div>
                                <div x-show="discountType !== ''" x-cloak>
                                    <x-input-label for="discount_amount" :value="__('Nominal/Persentase')" />
                                    <x-text-input id="discount_amount" class="block mt-1 w-full" type="number" name="discount_amount" :value="old('discount_amount', (float)$product->discount_amount)" min="0" step="0.01" />
                                    <p class="text-xs text-gray-500 mt-1" x-text="discountType === 'percentage' ? 'Contoh: Isi 10 untuk diskon 10%' : 'Contoh: Isi 80000 jika harga setelah diskon jadi Rp 80.000'"></p>
                                    <x-input-error :messages="$errors->get('discount_amount')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Current Image -->
                        @if($product->image)
                            <div>
                                <x-input-label :value="__('Gambar Saat Ini')" />
                                <div class="mt-1 w-32 h-32 rounded-lg overflow-hidden bg-gray-100">
                                    <img src="{{ $product->image_url }}" class="w-full h-full object-cover">
                                </div>
                            </div>
                        @endif

                        <!-- New Image -->
                        <div>
                            <x-input-label for="image" :value="__('Ganti Gambar (opsional)')" />
                            <input type="file" id="image" name="image" accept="image/jpeg,image/png"
                                class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB.</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 pt-4 border-t">
                        <x-primary-button>
                            {{ __('Update Produk') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
