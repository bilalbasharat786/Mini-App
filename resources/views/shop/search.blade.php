<x-app-layout>

    <main class="w-full py-10 sm:py-16 bg-[#FAFAFA] min-h-screen">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col items-center text-center mb-12 sm:mb-16">
                <span class="text-[#C5A059] text-[10px] sm:text-xs font-bold tracking-[0.3em] uppercase mb-2">
                    Find What You Love
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-widest uppercase mb-8" style="font-family: 'Playfair Display', serif;">
                    <span class="text-gray-400 font-light">SEARCH</span> <span class="text-gray-900">STORE</span>
                </h2>

                <form action="{{ route('shop.search') }}" method="GET" class="w-full max-w-2xl relative flex items-center group">
                    <input type="text" name="q" value="{{ $query ?? '' }}" placeholder="Search for products, categories..." required
                           class="w-full bg-white border border-gray-200 px-6 py-4 outline-none focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059]/20 transition-all text-sm sm:text-base text-gray-800 placeholder-gray-400 shadow-sm pr-20" />
                    <button type="submit" class="absolute right-2 top-2 bottom-2 bg-[#121212] text-white px-6 text-xs font-bold tracking-widest uppercase hover:bg-[#C5A059] transition-colors shadow-md">
                        Search
                    </button>
                </form>
            </div>

            @if(isset($query) && $query != '')
                <div class="mb-6 flex items-center justify-between border-b border-gray-100 pb-4">
                    <h3 class="text-lg font-serif text-gray-800" style="font-family: 'Playfair Display', serif;">
                        Showing results for: <span class="text-[#C5A059] italic">"{{ $query }}"</span>
                    </h3>
                    <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">{{ $products->count() }} Items Found</span>
                </div>

                @if($products->isEmpty())
                    <div class="text-center py-20 bg-white border border-gray-100 shadow-sm rounded-sm">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <h3 class="text-2xl font-serif text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">No matches found</h3>
                        <p class="text-gray-500">We couldn't find anything matching "{{ $query }}". Try checking your spelling or using different keywords.</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6 lg:gap-8">
                        @foreach($products as $product)
                            @php
                                $discountPercent = 0;
                                if($product->discount_price && $product->price > 0) {
                                    $discountPercent = round((($product->price - $product->discount_price) / $product->price) * 100);
                                }
                            @endphp

                            <div class="bg-white hover:shadow-xl transition-all duration-300 group overflow-hidden relative pb-4 border border-transparent hover:border-gray-100">
                                
                                <div class="relative w-full h-[280px] sm:h-[350px] bg-white overflow-hidden p-2">
                                    @if($discountPercent > 0)
                                        <div class="absolute top-2 left-2 bg-[#121212] text-white text-[11px] font-bold px-2 py-1 z-10 tracking-widest">
                                            -{{ $discountPercent }}%
                                        </div>
                                    @endif

                                    @php $inWishlist = in_array($product->id, session('wishlist', [])); @endphp
                                    <form action="{{ $inWishlist ? route('wishlist.remove', $product->id) : route('wishlist.add', $product->id) }}" method="POST" class="absolute top-2 right-2 z-20">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center shadow-sm transition-all {{ $inWishlist ? 'text-[#C5A059]' : 'text-gray-400 hover:text-[#C5A059]' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $inWishlist ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" /></svg>
                                        </button>
                                    </form>

                                    <a href="{{ route('shop.show', $product->id) }}" class="block w-full h-full">
                                        @if($product->image_url)
                                            <img src="{{ str_starts_with($product->image_url, 'http') ? $product->image_url : asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-contain object-center transition-transform duration-700 group-hover:scale-105">
                                        @else
                                            <img src="https://picsum.photos/seed/{{ $product->id }}/400/500" alt="Dummy Image" class="w-full h-full object-contain object-center transition-transform duration-700 group-hover:scale-105">
                                        @endif
                                    </a>

                                    <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-3 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 z-10 pointer-events-none group-hover:pointer-events-auto">
                                        <a href="{{ route('shop.show', $product->id) }}" class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center text-gray-600 hover:text-white hover:bg-[#C5A059] transition-all cursor-pointer border border-gray-100 hover:border-[#C5A059]">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        </a>
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center text-gray-600 hover:text-white hover:bg-[#121212] transition-all cursor-pointer border border-gray-100 hover:border-[#121212]">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="px-4 mt-4 text-center">
                                    <a href="{{ route('shop.show', $product->id) }}" class="block">
                                        <h3 class="text-[15px] sm:text-[17px] text-[#C5A059] truncate transition" style="font-family: 'Playfair Display', serif;">{{ $product->name }}</h3>
                                    </a>
                                    
                                    <div class="mt-2 flex items-center justify-center gap-2">
                                        @if($product->discount_price)
                                            <span class="text-[14px] sm:text-[16px] font-bold text-[#C5A059]">PKR {{ number_format($product->discount_price) }}</span>
                                            <span class="text-[11px] sm:text-[13px] text-gray-400 font-medium line-through">PKR {{ number_format($product->price) }}</span>
                                        @else
                                            <span class="text-[14px] sm:text-[16px] font-bold text-[#C5A059]">PKR {{ number_format($product->price) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="text-center py-10 mt-8">
                    <p class="text-gray-400 uppercase tracking-widest text-sm">Type a keyword above to find products.</p>
                </div>
            @endif

        </div>
    </main>

</x-app-layout>