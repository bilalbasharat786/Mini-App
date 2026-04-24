<x-app-layout>

    <main class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
        
        <div class="flex flex-col items-center sm:items-start mb-10 sm:mb-14">
            <span class="text-[#C5A059] text-[10px] sm:text-xs font-bold tracking-[0.3em] uppercase mb-2">
                Your Shopping Bag
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-widest uppercase flex gap-3" style="font-family: 'Playfair Display', serif;">
                <span class="text-gray-400 font-light">Your</span> <span class="text-gray-900">Cart</span>
            </h2>
        </div>

        @if(session('success'))
            <div class="bg-[#C5A059]/10 border border-[#C5A059] text-[#C5A059] px-4 py-3 rounded-none mb-6 text-sm font-bold tracking-wider">
                {{ session('success') }}
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="flex flex-col lg:flex-row gap-10 lg:gap-16 items-start">
                
                <div class="w-full lg:w-[65%]">
                    
                    <div class="hidden sm:grid grid-cols-[3fr_1fr_1fr_auto] gap-4 pb-4 border-b border-gray-200 text-xs font-bold tracking-widest uppercase text-gray-400">
                        <p>Product Details</p>
                        <p class="text-center">Quantity</p>
                        <p class="text-right">Total Price</p>
                        <p class="w-10 text-center"></p>
                    </div>

                    <div class="flex flex-col gap-6 sm:gap-8 mt-6 sm:mt-8">
                        @foreach($cart as $id => $details)
                            <div class="grid grid-cols-[auto_1fr] sm:grid-cols-[3fr_1fr_1fr_auto] gap-4 sm:gap-6 items-center pb-6 border-b border-gray-100 relative group transition-all">
                                
                                <div class="flex gap-4 sm:gap-6">
                                    <div class="w-20 sm:w-24 aspect-[3/4] bg-white border border-gray-100 overflow-hidden shadow-sm">
                                        @if(isset($details['image']) && str_starts_with($details['image'], 'http'))
                                            <img src="{{ $details['image'] }}" class="w-full h-full object-cover object-top hover:scale-110 transition-transform duration-500" alt="Product Image">
                                        @else
                                            <img src="{{ asset('storage/' . ($details['image'] ?? '')) }}" class="w-full h-full object-cover object-top hover:scale-110 transition-transform duration-500" alt="Product Image">
                                        @endif
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h3 class="text-sm sm:text-base font-bold text-[#121212] uppercase tracking-wide hover:text-[#C5A059] transition-colors">
                                            {{ $details['name'] }}
                                        </h3>
                                        
                                        <div class="mt-2 space-y-1">
                                            @if(isset($details['size']) && $details['size'])
                                                <p class="text-xs text-gray-500 tracking-wider uppercase">Size: <span class="font-bold text-gray-800">{{ $details['size'] }}</span></p>
                                            @endif
                                            @if(isset($details['color']) && $details['color'])
                                                <div class="flex items-center gap-2 text-xs text-gray-500 tracking-wider uppercase">
                                                    <span>Color:</span>
                                                    <span class="w-3 h-3 rounded-full border border-gray-200 shadow-sm" style="background-color: {{ strtolower(trim($details['color'])) }}"></span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <p class="sm:hidden mt-3 text-sm font-semibold text-[#121212]">
                                            PKR {{ number_format($details['price'], 2) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="col-span-2 sm:col-span-1 flex items-center sm:justify-center mt-2 sm:mt-0">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center border border-gray-200 bg-white shadow-sm overflow-hidden w-fit">
                                        @csrf
                                        <button type="button" onclick="this.nextElementSibling.stepDown(); this.form.submit()" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-[#121212] transition-colors">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
                                        </button>
                                        
                                        <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="w-10 text-center text-xs font-bold text-[#121212] border-none p-0 focus:ring-0 pointer-events-none bg-transparent" style="-webkit-appearance: none; margin: 0;">
                                        
                                        <button type="button" onclick="this.previousElementSibling.stepUp(); this.form.submit()" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-[#121212] transition-colors">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                        </button>
                                    </form>
                                </div>

                                <div class="hidden sm:block text-right">
                                    <p class="text-sm font-bold text-[#121212]">
                                        PKR {{ number_format($details['price'] * $details['quantity'], 2) }}
                                    </p>
                                </div>

                                <div class="absolute top-0 right-0 sm:static">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors duration-300 sm:opacity-50 hover:opacity-100 group-hover:opacity-100" title="Remove item">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="w-full lg:w-[35%] lg:sticky lg:top-28">
                    <div class="bg-white p-6 sm:p-8 border border-gray-100 shadow-sm">
                        
                        <div class="flex items-center gap-2 text-2xl mb-8" style="font-family: 'Playfair Display', serif;">
                            <span class="text-gray-400 font-light">CART</span> 
                            <span class="text-gray-900 font-medium">TOTALS</span>
                            <div class="w-12 h-[2px] bg-[#C5A059] ml-2"></div>
                        </div>
                        
                        <div class="flex flex-col gap-4 text-sm text-gray-600 mb-8">
                            <div class="flex justify-between items-center">
                                <p>Subtotal</p>
                                <p>PKR {{ number_format($total, 2) }}</p>
                            </div>
                            
                            <hr class="border-gray-200" />
                            
                            <div class="flex justify-between items-center">
                                <p>Shipping Fee</p>
                                <p>PKR 0.00</p>
                            </div>
                            
                            <hr class="border-gray-200" />
                            
                            <div class="flex justify-between items-center text-base mt-2">
                                <b class="text-[#121212]">Total</b>
                                <b class="text-[#121212]">PKR {{ number_format($total, 2) }}</b>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="group relative block w-full h-14 bg-[#121212] text-white text-xs sm:text-sm font-bold tracking-widest uppercase overflow-hidden transition-all duration-300 mb-4 text-center leading-[3.5rem]">
                            <span class="absolute inset-0 bg-[#C5A059] translate-y-full transition-transform duration-500 ease-out group-hover:translate-y-0"></span>
                            <span class="relative z-10 transition-colors duration-300">
                                Proceed to Checkout
                            </span>
                        </a>

                    </div>

                    <div class="mt-6 flex justify-center">
                        <div class="flex flex-col items-center gap-1 opacity-60 grayscale">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-5-5 1.41-1.41L11 14.17l7.59-7.59L20 8l-9 9z"/></svg>
                            <span class="text-[9px] font-bold uppercase tracking-widest text-[#121212]">Secure Checkout</span>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 bg-white border border-gray-100 shadow-sm max-w-3xl mx-auto mt-8">
                <svg class="w-16 h-16 text-gray-300 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <h2 class="text-xl sm:text-3xl text-[#121212] mb-3" style="font-family: 'Playfair Display', serif;">Your bag is empty</h2>
                <p class="text-gray-500 mb-8 text-sm">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ route('shop.home') }}" class="bg-[#121212] text-white px-8 py-4 text-xs font-bold tracking-widest uppercase hover:bg-[#C5A059] transition-colors shadow-md">
                    Continue Shopping
                </a>
            </div>
        @endif
    </main>

</x-app-layout>