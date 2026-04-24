<x-app-layout>

    @if(isset($sliders) && $sliders->count() > 0)
    <div class="w-full relative z-0 pb-8 bg-[#FAFAFA]">
        <div class="relative group slider-wrapper" id="premium-slider">
            <div class="relative w-full aspect-[16/9] sm:aspect-[21/9] md:aspect-[24/9] max-h-[85vh] overflow-hidden">
                <div id="slider-container" class="flex transition-transform duration-700 ease-in-out h-full w-full" style="transform: translateX(0%);">
                    @foreach($sliders as $slider)
                        <div class="min-w-full h-full relative outline-none">
                            <img src="{{ asset('storage/' . $slider->image_url) }}" class="w-full h-full object-cover transform transition-transform duration-[10000ms] hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none"></div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button onclick="prevSlide()" class="absolute left-4 sm:left-8 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-full bg-black/20 backdrop-blur-sm border border-white/50 cursor-pointer z-10 transition-all duration-300 shadow-lg group/arrow opacity-0 group-hover:opacity-100 hover:scale-110 hover:bg-[#C5A059] hover:border-[#C5A059] active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-5 h-5 sm:w-6 sm:h-6 transition-transform group-hover/arrow:-translate-x-1"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
            </button>

            <button onclick="nextSlide()" class="absolute right-4 sm:right-8 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-full bg-black/20 backdrop-blur-sm border border-white/50 cursor-pointer z-10 transition-all duration-300 shadow-lg group/arrow opacity-0 group-hover:opacity-100 hover:scale-110 hover:bg-[#C5A059] hover:border-[#C5A059] active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-5 h-5 sm:w-6 sm:h-6 transition-transform group-hover/arrow:translate-x-1"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
            </button>

            <div class="absolute bottom-[20px] left-0 right-0 z-10 flex justify-center items-center gap-2">
                @foreach($sliders as $index => $slider)
                    <button onclick="goToSlide({{ $index }})" class="slider-dot h-[3px] rounded-[4px] transition-all duration-400 ease-in-out {{ $index == 0 ? 'bg-[#C5A059] w-[50px]' : 'bg-white/50 w-[30px]' }}"></button>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        let currentSlide = 0;
        const totalSlides = {{ $sliders->count() }};
        const sliderContainer = document.getElementById('slider-container');
        const dots = document.querySelectorAll('.slider-dot');
        let slideInterval;

        function updateSlider() {
            sliderContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
            dots.forEach((dot, index) => {
                if(index === currentSlide) {
                    dot.classList.add('bg-[#C5A059]', 'w-[50px]'); dot.classList.remove('bg-white/50', 'w-[30px]');
                } else {
                    dot.classList.add('bg-white/50', 'w-[30px]'); dot.classList.remove('bg-[#C5A059]', 'w-[50px]');
                }
            });
        }
        function nextSlide() { currentSlide = (currentSlide + 1) % totalSlides; updateSlider(); }
        function prevSlide() { currentSlide = (currentSlide - 1 + totalSlides) % totalSlides; updateSlider(); }
        function goToSlide(index) { currentSlide = index; updateSlider(); resetInterval(); }
        function startInterval() { slideInterval = setInterval(nextSlide, 3500); }
        function resetInterval() { clearInterval(slideInterval); startInterval(); }

        const wrapper = document.getElementById('premium-slider');
        wrapper.addEventListener('mouseenter', () => clearInterval(slideInterval));
        wrapper.addEventListener('mouseleave', startInterval);
        startInterval();
    </script>
    @endif

    <main class="w-full py-16 sm:py-24 bg-[#FAFAFA] overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col items-center text-center mb-12 sm:mb-16">
                <div class="flex items-center justify-center gap-2 text-2xl sm:text-3xl md:text-4xl text-gray-500 font-light">
                    <span>LATEST</span> <span class="text-gray-900 font-medium">COLLECTION</span>
                </div>
                <div class="w-16 sm:w-24 h-[2px] bg-[#C5A059] my-4 sm:my-6 rounded-full"></div>
                <p class="max-w-2xl text-xs sm:text-sm md:text-base text-gray-500 tracking-widest uppercase leading-relaxed mx-auto">
                    Handpicked premium selections tailored for your distinguished taste
                </p>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-10 text-gray-500">
                    <p>No products available right now. Check back later!</p>
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

                        <div class="bg-white hover:shadow-xl transition-all duration-300 group overflow-hidden relative pb-4">
                            
                            <div class="relative w-full h-[280px] sm:h-[350px] bg-white overflow-hidden p-2">
                                
                                @if($discountPercent > 0)
                                    <div class="absolute top-2 left-2 bg-[#111] text-white text-[11px] font-bold px-2 py-1 z-10">
                                        -{{ $discountPercent }}%
                                    </div>
                                @endif

                                <a href="{{ route('shop.show', $product->id) }}" class="block w-full h-full">
                                    @if($product->image_url)
                                        <img src="{{ str_starts_with($product->image_url, 'http') ? $product->image_url : asset('storage/' . $product->image_url) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-full object-contain object-center transition-transform duration-700 group-hover:scale-105">
                                    @else
                                        <img src="https://picsum.photos/seed/{{ $product->id }}/400/500" 
                                             alt="Dummy Image" 
                                             class="w-full h-full object-contain object-center transition-transform duration-700 group-hover:scale-105">
                                    @endif
                                </a>

                                <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-3 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 z-10 pointer-events-none group-hover:pointer-events-auto">
                                    <button class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center text-gray-600 hover:text-[#C5A059] transition-colors cursor-pointer border border-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" /></svg>
                                    </button>
                                    <a href="{{ route('shop.show', $product->id) }}" class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center text-gray-600 hover:text-[#C5A059] transition-colors cursor-pointer border border-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    </a>
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

            <div class="mt-16 sm:mt-20 flex justify-center">
                <button class="group relative px-8 py-3 bg-transparent overflow-hidden text-xs sm:text-sm font-semibold tracking-widest uppercase border border-[#C5A059] text-gray-900 transition-colors duration-300">
                    <span class="absolute inset-0 bg-[#C5A059] translate-y-full transition-transform duration-500 ease-out group-hover:translate-y-0"></span>
                    <span class="relative z-10 transition-colors duration-300 group-hover:text-white">Discover More</span>
                </button>
            </div>

        </div>
    </main>

</x-app-layout>