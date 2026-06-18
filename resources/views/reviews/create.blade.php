<x-app-layout>
    @section('title', 'Beri Penilaian')

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Penilaian Pesanan #{{ $order->order_number }}</h2>
            <a href="{{ route('orders.show', $order) }}" class="text-sm text-indigo-600 hover:text-indigo-800 transition">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8">
                <p class="text-gray-600 mb-6 text-sm">Bagaimana kualitas produk yang Anda terima? Penilaian Anda sangat membantu penjual dan pembeli lainnya.</p>

                <form method="POST" action="{{ route('reviews.store', $order) }}">
                    @csrf
                    <div class="space-y-8 divide-y">
                        @foreach($itemsToReview as $index => $item)
                            <div class="pt-6 {{ $loop->first ? 'pt-0 border-0' : '' }}" x-data="{ rating: 5, hoverRating: 0 }">
                                <input type="hidden" name="reviews[{{ $index }}][product_id]" value="{{ $item->product_id }}">
                                <input type="hidden" name="reviews[{{ $index }}][rating]" x-model="rating">

                                <div class="flex gap-4">
                                    <div class="w-20 h-20 rounded bg-gray-100 overflow-hidden shrink-0">
                                        <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-900">{{ $item->product->name }}</h3>
                                        <p class="text-xs text-gray-500 mb-3">Toko: {{ $item->seller->store_name ?? $item->seller->name }}</p>

                                        <!-- Star Rating -->
                                        <div class="flex items-center gap-1 mb-4">
                                            <template x-for="i in 5">
                                                <button type="button" 
                                                    @mouseover="hoverRating = i" 
                                                    @mouseleave="hoverRating = 0"
                                                    @click="rating = i"
                                                    class="focus:outline-none transition-transform hover:scale-110">
                                                    <svg class="w-8 h-8" :class="(hoverRating >= i || (!hoverRating && rating >= i)) ? 'text-yellow-400' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                </button>
                                            </template>
                                            <span class="ml-2 text-sm font-medium text-gray-600" x-text="['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Baik', 'Sangat Baik'][rating]"></span>
                                        </div>

                                        <!-- Comment -->
                                        <div>
                                            <textarea name="reviews[{{ $index }}][comment]" rows="3" 
                                                class="w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm p-3 placeholder-gray-400"
                                                placeholder="Bagikan pendapat Anda tentang kualitas produk ini... (opsional)"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="py-3 px-8 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition shadow-sm">
                            Kirim Penilaian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
