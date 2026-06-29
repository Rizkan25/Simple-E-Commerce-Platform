<x-app-layout>
    @section('title', 'Produk Saya')

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">{{ __('Produk Saya') }}</h2>
            
            <a href="{{ route('seller.products.create') }}" class="inline-flex items-center px-3 py-2 sm:px-6 sm:py-2.5 bg-gradient-to-r from-primary-600 to-secondary-500 rounded-xl font-bold text-xs sm:text-sm text-white tracking-wide hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all shadow-lg shadow-primary-500/25 hover:shadow-xl hover:-translate-y-0.5 duration-300 whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-1.5 sm:mr-2 sm:-ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk
            </a>

        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($products->count() > 0)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            @php
                                $renderSortHeader = function($column, $label, $align = 'left') use ($sortBy, $sortOrder) {
                                    $isCurrent = $sortBy === $column;
                                    $newOrder = ($isCurrent && $sortOrder === 'asc') ? 'desc' : 'asc';
                                    $url = request()->fullUrlWithQuery(['sort_by' => $column, 'sort_order' => $newOrder]);
                                    
                                    $justify = 'justify-start';
                                    if ($align === 'right') $justify = 'justify-end';
                                    if ($align === 'center') $justify = 'justify-center';

                                    $html = '<th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider group">';
                                    $html .= '<a href="' . $url . '" class="flex items-center ' . $justify . ' hover:text-indigo-600 transition">';
                                    $html .= $label;
                                    
                                    if ($isCurrent) {
                                        if ($sortOrder === 'asc') {
                                            $html .= '<svg class="w-4 h-4 ml-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/></svg>';
                                        } else {
                                            $html .= '<svg class="w-4 h-4 ml-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>';
                                        }
                                    } else {
                                        $html .= '<svg class="w-4 h-4 ml-1 text-gray-300 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/></svg>';
                                    }
                                    
                                    $html .= '</a></th>';
                                    return $html;
                                };
                            @endphp
                            <tr>
                                {!! $renderSortHeader('name', 'Produk', 'left') !!}
                                {!! $renderSortHeader('category', 'Kategori', 'left') !!}
                                {!! $renderSortHeader('price', 'Harga', 'right') !!}
                                {!! $renderSortHeader('stock', 'Stok', 'center') !!}
                                {!! $renderSortHeader('created_at', 'Ditambahkan Pada', 'center') !!}
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($products as $product)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded bg-gray-100 overflow-hidden shrink-0">
                                                <img src="{{ $product->image_url }}" class="w-full h-full object-cover">
                                            </div>
                                            <span class="font-medium text-gray-800 text-sm">{{ $product->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $product->category->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 text-right font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm text-gray-500 whitespace-nowrap">
                                        {{ $product->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('seller.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition">Edit</a>
                                            <form method="POST" action="{{ route('seller.products.destroy', $product) }}"
                                                  onsubmit="return confirm('Hapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium transition">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>

                <div class="mt-6">{{ $products->links() }}</div>
            @else
                <div class="text-center py-16 bg-white rounded-xl shadow-sm">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-600">Belum ada produk</h3>
                    <p class="text-gray-500 mt-1 text-sm">Mulai jual produk pertama Anda.</p>
                    <a href="{{ route('seller.products.create') }}" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-primary-600 to-secondary-500 rounded-2xl font-bold text-base text-white tracking-wide hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all shadow-lg shadow-primary-500/25 hover:shadow-xl hover:-translate-y-0.5 duration-300 mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 mr-2 -ml-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Produk
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
