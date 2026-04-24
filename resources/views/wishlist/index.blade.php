<x-app-layout>

    <main class="w-full py-16 sm:py-24 bg-[#FAFAFA] min-h-screen">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col items-center text-center mb-12 sm:mb-16">
                <span class="text-[#C5A059] text-[10px] sm:text-xs font-bold tracking-[0.3em] uppercase mb-2">
                    Saved Items
                </span>
                <div class="flex items-center justify-center gap-2 text-3xl sm:text-4xl md:text-5xl text-gray-900 uppercase tracking-widest" style="font-family: 'Playfair Display', serif;">
                    <span class="font-extrabold">MY</span> <span class="font-light text-gray-400">WISHLIST</span>
                </div>
                <div class="w-16 sm:w-24 h-[2px] bg-[#C5A059] my-4 sm:my-6 rounded-full"></div>
            </div>

            @if(session('success'))
                <div class="bg-[#C5A059]/10 border border-[#C5A059] text-[#C5A059] px-4 py-3 text-center mb-8 text-sm font-bold tracking-wider max-w-3xl mx-auto">
                    {{ session('success') }}
                </div>
            @endif

            @if($products->isEmpty())
                <div class="text-center py-20 bg-white border border-gray-100 shadow-sm rounded-sm max-w-3xl mx-auto">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <h3 class="text-2xl font-serif text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">Your wishlist is empty</h3>
                    <p class="text-gray-500 mb-6 text-sm">Save your favorite items to view them later.</p>
                    <a href="{{ route('shop.home') }}" class="bg-[#121212] text-white px-8 py-3 text-xs font-bold tracking-widest uppercase hover:bg-[#C5A059] transition-colors shadow-md">
                        Discover Fashion
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6 lg:gap-8">
                    @foreach($products as $product)
                        <div class="bg-white hover:shadow-xl transition-all duration-300 group overflow-hidden relative pb-4 border border-transparent hover:border-gray-100">
                            
                            <div class="relative w-full h-[280px] sm:h-[350px] bg-white overflow-hidden p-2">
                                
                                <form action="{{ route('wishlist.remove', $product->id) }}" method="POST" class="absolute top-2 right-2 z-20">
                                    @csrf
                                    <button type="submit" class="w-8 h-8 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-500 hover:text-red-500 hover:bg-white shadow-sm transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </form>

                                <a href="{{ route('shop.show', $product->id) }}" class="block w-full h-full">
                                    @if($product->image_url)
                                        <img src="{{ str_starts_with($product->image_url, 'http') ? $product->image_url : asset('storage/' . $product->image_url) }}" class="w-full h-full object-contain object-center transition-transform duration-700 group-hover:scale-105">
                                    @else
                                        <img src="https://picsum.photos/seed/{{ $product->id }}/400/500" class="w-full h-full object-contain object-center transition-transform duration-700 group-hover:scale-105">
                                    @endif
                                </a>
                            </div>

                            <div class="px-4 mt-4 text-center">
                                <a href="{{ route('shop.show', $product->id) }}" class="block">
                                    <h3 class="text-[15px] sm:text-[17px] text-[#C5A059] truncate transition" style="font-family: 'Playfair Display', serif;">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                <div class="mt-2">
                                    <span class="text-[14px] sm:text-[16px] font-bold text-[#121212]">PKR {{ number_format($product->price) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </main>

</x-app-layout>