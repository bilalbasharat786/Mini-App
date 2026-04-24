<x-app-layout>

    @php
        // Image Logic
        function getImageUrl($url, $id) {
            if (!$url) return null;
            return str_starts_with($url, 'http') ? $url : asset('storage/' . $url);
        }
        
        $img1 = getImageUrl($product->image_url, $product->id) ?? "https://picsum.photos/seed/{$product->id}/800/800";
        $img2 = getImageUrl($product->image_url_2, $product->id);
        $img3 = getImageUrl($product->image_url_3, $product->id);
        $img4 = getImageUrl($product->image_url_4, $product->id);
        $gallery = array_filter([$img1, $img2, $img3, $img4]);

        // Discount Percentage Calculator
        $discountPercent = 0;
        if($product->discount_price && $product->price > 0 && $product->discount_price < $product->price) {
            $discountPercent = round((($product->price - $product->discount_price) / $product->price) * 100);
        }

        // RELATED PRODUCTS LOGIC
        // Is category ke baqi products nikalo, aur is wali product ko list se nikal do
        $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
                            ->where('id', '!=', $product->id)
                            ->take(5) // Sirf top 5 dikhani hain
                            ->get();
    @endphp

    <main class="max-w-7xl mx-auto px-4 py-12">
        <div class="bg-white rounded-none shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row">
            
            <div class="md:w-1/2 p-4 sm:p-8 bg-[#FAFAFA] flex flex-col items-center">
                
                <div class="relative w-full h-[400px] sm:h-[500px] bg-white overflow-hidden shadow-sm border border-gray-200 mb-4 group">
                    @if($discountPercent > 0)
                        <div class="absolute top-4 left-4 z-20 bg-[#121212] text-white text-[11px] sm:text-xs font-bold px-3 py-1.5 tracking-widest uppercase shadow-sm">
                            -{{ $discountPercent }}%
                        </div>
                    @endif
                    <img id="main-image" src="{{ $img1 }}" class="w-full h-full object-contain object-top transition-transform duration-700 ease-in-out group-hover:scale-105">
                </div>
                
                @if(count($gallery) > 1)
                <div class="flex gap-3 justify-center w-full mt-2">
                    @foreach($gallery as $img)
                        <div class="w-20 h-24 bg-white overflow-hidden border-2 border-transparent hover:border-[#C5A059] cursor-pointer transition-all duration-300 shadow-sm opacity-70 hover:opacity-100" onclick="changeImage('{{ $img }}')">
                            <img src="{{ $img }}" class="w-full h-full object-cover object-top">
                        </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="md:w-1/2 p-8 lg:p-14 flex flex-col">
                
                <span class="text-[10px] sm:text-xs font-bold text-[#C5A059] uppercase tracking-widest mb-3">
                    {{ $product->category->name ?? 'Uncategorized' }}
                </span>
                
                <h1 class="text-3xl sm:text-4xl text-gray-900 mb-4" style="font-family: 'Playfair Display', serif;">
                    {{ $product->name }}
                </h1>
                
                <div class="mb-6 flex items-center gap-3">
                    @if($product->discount_price && $product->discount_price < $product->price)
                        <span class="text-2xl sm:text-3xl font-extrabold text-[#C5A059]">PKR {{ number_format($product->discount_price) }}</span>
                        <span class="text-base sm:text-lg text-gray-400 font-medium line-through">PKR {{ number_format($product->price) }}</span>
                    @else
                        <span class="text-2xl sm:text-3xl font-extrabold text-black">PKR {{ number_format($product->price) }}</span>
                    @endif
                </div>
                
                <div class="w-16 h-[2px] bg-[#C5A059] mb-6"></div>

                <p class="text-gray-500 text-sm leading-relaxed mb-8">
                    {{ $product->description }}
                </p>

                <div class="flex flex-col gap-6 mb-8">
                    @if($product->color)
                    <div>
                        <span class="block text-xs font-bold text-gray-900 mb-3 tracking-widest uppercase">Select Color</span>
                        <div class="flex flex-wrap gap-3" id="color-options">
                            @foreach(explode(',', $product->color) as $index => $color)
                                @php $cleanColor = trim($color); @endphp
                                <div onclick="selectColor(this, '{{ $cleanColor }}')" 
                                     class="color-btn w-8 h-8 rounded-full border-2 cursor-pointer transition-all duration-300 shadow-sm {{ $index == 0 ? 'ring-2 ring-offset-2 ring-[#C5A059] border-white' : 'border-gray-200 hover:scale-110' }}" 
                                     style="background-color: {{ strtolower($cleanColor) }};" 
                                     title="{{ $cleanColor }}"
                                     data-color="{{ $cleanColor }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($product->size)
                    <div>
                        <span class="block text-xs font-bold text-gray-900 mb-3 tracking-widest uppercase">Select Size</span>
                        <div class="flex flex-wrap gap-3" id="size-options">
                            @foreach(explode(',', $product->size) as $index => $size)
                                @php $cleanSize = trim($size); @endphp
                                <span onclick="selectSize(this, '{{ $cleanSize }}')" 
                                      class="size-btn border text-sm font-medium px-4 py-2 transition-colors cursor-pointer {{ $index == 0 ? 'border-[#C5A059] bg-[#C5A059] text-white' : 'border-gray-300 text-gray-600 hover:border-[#C5A059] hover:text-[#C5A059] bg-transparent' }}"
                                      data-size="{{ $cleanSize }}">
                                    {{ $cleanSize }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="flex items-center gap-4 mb-8">
                    <span class="text-xs font-bold tracking-wider uppercase {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $product->stock > 0 ? '✓ In Stock ('.$product->stock.')' : '✕ Out of Stock' }}
                    </span>
                </div>

                <div class="mt-auto w-full flex gap-4">
                    
                    @php $inWishlist = in_array($product->id, session('wishlist', [])); @endphp
                    <form action="{{ $inWishlist ? route('wishlist.remove', $product->id) : route('wishlist.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-14 h-14 flex items-center justify-center border {{ $inWishlist ? 'border-[#C5A059] bg-[#C5A059] text-white' : 'border-gray-300 bg-white text-gray-800' }} hover:border-[#C5A059] hover:text-[#C5A059] hover:bg-white transition-all duration-300 shadow-sm group" title="Add to Wishlist">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $inWishlist ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 group-hover:scale-110 transition-transform">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        </button>
                    </form>

                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="color" id="selected_color" value="">
                        <input type="hidden" name="size" id="selected_size" value="">

                        <button type="submit" @if($product->stock <= 0) disabled @endif class="group relative w-full h-14 bg-[#121212] overflow-hidden text-sm font-semibold tracking-widest uppercase text-white transition-colors duration-300 shadow-lg disabled:bg-gray-300 disabled:cursor-not-allowed">
                            <span class="absolute inset-0 bg-[#C5A059] translate-y-full transition-transform duration-500 ease-out group-hover:translate-y-0"></span>
                            <span class="relative z-10 flex justify-center items-center gap-2 transition-colors duration-300 group-hover:text-white">
                                @if($product->stock > 0)
                                    Add to Cart
                                @else
                                    🚫 Out of Stock
                                @endif
                            </span>
                        </button>
                    </form>
                </div>
                
            </div>
        </div>
    </main>

    @if($relatedProducts->count() > 0)
    <section class="w-full py-16 sm:py-24 bg-white overflow-hidden border-t border-gray-100">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col items-center text-center mb-12 sm:mb-16">
                <span class="text-[#C5A059] text-[10px] sm:text-xs font-bold tracking-[0.3em] uppercase mb-2">
                    Complete Your Look
                </span>
                <div class="flex items-center justify-center gap-2 text-2xl sm:text-3xl md:text-4xl text-gray-900 tracking-widest uppercase" style="font-family: 'Playfair Display', serif;">
                    <span class="text-gray-400 font-light">RELATED</span> <span class="font-medium">PRODUCTS</span>
                </div>
                <div class="w-16 sm:w-24 h-[2px] bg-[#C5A059] my-4 sm:my-6 rounded-full"></div>
                <p class="max-w-2xl text-xs sm:text-sm md:text-base text-gray-500 tracking-widest uppercase leading-relaxed mx-auto">
                    Discover similar styles meticulously crafted to elevate your premium wardrobe.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6 lg:gap-8">
                @foreach($relatedProducts as $related)
                    @php
                        $relDiscountPercent = 0;
                        if($related->discount_price && $related->price > 0) {
                            $relDiscountPercent = round((($related->price - $related->discount_price) / $related->price) * 100);
                        }
                    @endphp

                    <div class="bg-white hover:shadow-xl transition-all duration-300 group overflow-hidden relative pb-4 border border-transparent hover:border-gray-100">
                        
                        <div class="relative w-full h-[280px] sm:h-[350px] bg-white overflow-hidden p-2">
                            
                            @if($relDiscountPercent > 0)
                                <div class="absolute top-2 left-2 bg-[#111] text-white text-[11px] font-bold px-2 py-1 z-10 tracking-widest">
                                    -{{ $relDiscountPercent }}%
                                </div>
                            @endif

                            @php $relInWishlist = in_array($related->id, session('wishlist', [])); @endphp
                            <form action="{{ $relInWishlist ? route('wishlist.remove', $related->id) : route('wishlist.add', $related->id) }}" method="POST" class="absolute top-2 right-2 z-20">
                                @csrf
                                <button type="submit" class="w-8 h-8 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center shadow-sm transition-all {{ $relInWishlist ? 'text-[#C5A059]' : 'text-gray-400 hover:text-[#C5A059]' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $relInWishlist ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" /></svg>
                                </button>
                            </form>

                            <a href="{{ route('shop.show', $related->id) }}" class="block w-full h-full">
                                @if($related->image_url)
                                    <img src="{{ str_starts_with($related->image_url, 'http') ? $related->image_url : asset('storage/' . $related->image_url) }}" 
                                         alt="{{ $related->name }}" class="w-full h-full object-contain object-center transition-transform duration-700 group-hover:scale-105">
                                @else
                                    <img src="https://picsum.photos/seed/{{ $related->id }}/400/500" alt="Dummy Image" class="w-full h-full object-contain object-center transition-transform duration-700 group-hover:scale-105">
                                @endif
                            </a>

                            <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-3 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 z-10 pointer-events-none group-hover:pointer-events-auto">
                                <a href="{{ route('shop.show', $related->id) }}" class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center text-gray-600 hover:text-white hover:bg-[#C5A059] transition-all cursor-pointer border border-gray-100 hover:border-[#C5A059]">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </a>
                                <form action="{{ route('cart.add', $related->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center text-gray-600 hover:text-white hover:bg-[#121212] transition-all cursor-pointer border border-gray-100 hover:border-[#121212]">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="px-4 mt-4 text-center">
                            <a href="{{ route('shop.show', $related->id) }}" class="block">
                                <h3 class="text-[15px] sm:text-[17px] text-[#C5A059] truncate transition" style="font-family: 'Playfair Display', serif;">
                                    {{ $related->name }}
                                </h3>
                            </a>
                            
                            <div class="mt-2 flex items-center justify-center gap-2">
                                @if($related->discount_price)
                                    <span class="text-[14px] sm:text-[16px] font-bold text-[#C5A059]">PKR {{ number_format($related->discount_price) }}</span>
                                    <span class="text-[11px] sm:text-[13px] text-gray-400 font-medium line-through">PKR {{ number_format($related->price) }}</span>
                                @else
                                    <span class="text-[14px] sm:text-[16px] font-bold text-[#C5A059]">PKR {{ number_format($related->price) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <script>
        // Smooth Gallery Image Change
        function changeImage(src) {
            const mainImg = document.getElementById('main-image');
            mainImg.style.opacity = 0; 
            setTimeout(() => {
                mainImg.src = src;
                mainImg.style.opacity = 1; 
            }, 300); 
        }

        // Color Select Logic
        function selectColor(element, colorName) {
            document.querySelectorAll('.color-btn').forEach(btn => {
                btn.classList.remove('ring-2', 'ring-offset-2', 'ring-[#C5A059]', 'border-white');
                btn.classList.add('border-gray-200', 'hover:scale-110');
            });
            element.classList.remove('border-gray-200', 'hover:scale-110');
            element.classList.add('ring-2', 'ring-offset-2', 'ring-[#C5A059]', 'border-white');
            document.getElementById('selected_color').value = colorName;
        }

        // Size Select Logic
        function selectSize(element, sizeName) {
            document.querySelectorAll('.size-btn').forEach(btn => {
                btn.classList.remove('border-[#C5A059]', 'bg-[#C5A059]', 'text-white');
                btn.classList.add('border-gray-300', 'text-gray-600', 'bg-transparent', 'hover:border-[#C5A059]', 'hover:text-[#C5A059]');
            });
            element.classList.remove('border-gray-300', 'text-gray-600', 'bg-transparent', 'hover:border-[#C5A059]', 'hover:text-[#C5A059]');
            element.classList.add('border-[#C5A059]', 'bg-[#C5A059]', 'text-white');
            document.getElementById('selected_size').value = sizeName;
        }

        // Initialize First Color & Size on Page Load
        document.addEventListener("DOMContentLoaded", function() {
            let firstColor = document.querySelector('.color-btn');
            if(firstColor) {
                document.getElementById('selected_color').value = firstColor.getAttribute('data-color');
            }

            let firstSize = document.querySelector('.size-btn');
            if(firstSize) {
                document.getElementById('selected_size').value = firstSize.getAttribute('data-size');
            }
        });
    </script>

</x-app-layout>