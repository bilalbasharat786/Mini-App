<x-app-layout>

    <main class="w-full py-16 sm:py-24 bg-[#FAFAFA] min-h-screen">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col items-center text-center mb-12 sm:mb-16">
                <span class="text-[#C5A059] text-[10px] sm:text-xs font-bold tracking-[0.3em] uppercase mb-2">
                    Exclusive Collection
                </span>
                <div class="flex items-center justify-center gap-2 text-3xl sm:text-4xl md:text-5xl text-gray-900 uppercase tracking-widest" style="font-family: 'Playfair Display', serif;">
                    <span class="font-extrabold">{{ $category->name }}'S</span> <span class="font-light text-gray-400">FASHION</span>
                </div>
                <div class="w-16 sm:w-24 h-[2px] bg-[#C5A059] my-4 sm:my-6 rounded-full"></div>
                <p class="max-w-2xl text-xs sm:text-sm md:text-base text-gray-500 tracking-widest uppercase leading-relaxed mx-auto">
                    Explore the finest selection of {{ $category->name }}'s apparel tailored for your distinguished taste.
                </p>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-20 bg-white border border-gray-100 shadow-sm rounded-sm">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <h3 class="text-2xl font-serif text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">Coming Soon</h3>
                    <p class="text-gray-500">We are currently updating our {{ $category->name }}'s collection.</p>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6 lg:gap-8">
                    @foreach($products as $product)
                        @php
                            // Discount Percentage Calculator
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

                                <a href="{{ route('shop.show', $product->id) }}" class="block w-full h-full">
                                    @if($product->image_url)
                                        <img src="{{ str_starts_with($product->image_url, 'http') ? $product->image_url : asset($product->image_url) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-full object-contain object-center transition-transform duration-700 group-hover:scale-105">
                                    @else
                                        <img src="https://picsum.photos/seed/{{ $product->id }}/400/500" 
                                             alt="Dummy Image" 
                                             class="w-full h-full object-contain object-center transition-transform duration-700 group-hover:scale-105">
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
                                    <h3 class="text-[15px] sm:text-[17px] text-[#C5A059] truncate transition" style="font-family: 'Playfair Display', serif;">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                
                                <div class="mt-2 flex items-center justify-center gap-2">
                                    @if($product->discount_price)
                                        <span class="text-[14px] sm:text-[16px] font-bold text-[#C5A059]">PKR {{ number_format($product->discount_price) }}</span>
                                        <span class="text-[11px] sm:text-[13px] text-gray-400 font-medium line-through">PKR {{ number_format($product->price) }}</span>
                                    @else
                                        <span class="text-[14px] sm:text-[16px] font-bold text-[#C5A059]">PKR {{ number_format($product->price) }}</span>
                                    @endif
                                </div>

                                <div class="mt-3 flex justify-center items-center gap-1.5 h-[12px]">
                                    @if($product->color)
                                        @php $colors = explode(',', $product->color); @endphp
                                        @foreach(array_slice($colors, 0, 3) as $c)
                                            <span class="w-[10px] h-[10px] rounded-full border border-gray-300 shadow-sm" style="background-color: {{ strtolower(trim($c)) }};"></span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </main>

</x-app-layout>