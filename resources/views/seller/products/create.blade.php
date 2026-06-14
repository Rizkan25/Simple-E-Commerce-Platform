<x-app-layout>
    @section('title', 'Tambah Produk')

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Tambah Produk') }}</h2>
            <a href="{{ route('seller.products.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 transition">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-5">
                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Nama Produk')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div>
                            <x-input-label for="category_id" :value="__('Kategori')" />
                            <select id="category_id" name="category_id" required
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Price & Stock -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="price" :value="__('Harga (Rp)')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" min="0" step="100" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="stock" :value="__('Stok')" />
                                <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="old('stock', 0)" min="0" required />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Image -->
                        <div>
                            <x-input-label for="image" :value="__('Gambar Produk')" />
                            <input type="file" id="image" name="image" accept="image/jpeg,image/png"
                                class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB.</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 pt-4 border-t">
                        <x-primary-button>
                            {{ __('Simpan Produk') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
