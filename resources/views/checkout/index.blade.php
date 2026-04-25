<x-app-layout>

    <div class="bg-[#FAFAFA] min-h-screen py-10 sm:py-16">
        <div class="max-w-[1300px] mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col items-center sm:items-start mb-10 sm:mb-14">
                <span class="text-[#C5A059] text-[10px] sm:text-xs font-bold tracking-[0.3em] uppercase mb-2">
                    Secure Checkout
                </span>
                <div class="flex items-center gap-2 text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-widest uppercase" style="font-family: 'Playfair Display', serif;">
                    <span class="text-gray-400 font-light">DELIVERY</span> <span class="text-gray-900">INFORMATION</span>
                </div>
            </div>

            <form action="{{ route('checkout.place_order') }}" method="POST" class="flex flex-col lg:flex-row gap-12 lg:gap-20 items-start">
                @csrf
                
                <div class="flex-1 w-full">
                    <h3 class="text-lg font-serif text-[#121212] mb-6 border-b border-gray-200 pb-3" style="font-family: 'Playfair Display', serif;">Shipping Address</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        
                        <input required type="text" name="name" placeholder="Full Name" 
                               class="w-full bg-white border border-gray-200 px-4 py-3.5 outline-none focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059]/20 transition-all text-sm text-gray-800 placeholder-gray-400 rounded-sm shadow-sm" />
                        
                        <input required type="text" name="phone" placeholder="Phone Number" 
                               class="w-full bg-white border border-gray-200 px-4 py-3.5 outline-none focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059]/20 transition-all text-sm text-gray-800 placeholder-gray-400 rounded-sm shadow-sm" />
                        
                        <div class="sm:col-span-2">
                            <input type="email" name="email" placeholder="Email Address (Optional)" 
                                   class="w-full bg-white border border-gray-200 px-4 py-3.5 outline-none focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059]/20 transition-all text-sm text-gray-800 placeholder-gray-400 rounded-sm shadow-sm" />
                        </div>
                        
                        <div class="sm:col-span-2">
                            <input required type="text" name="address" placeholder="Detailed Street Address" 
                                   class="w-full bg-white border border-gray-200 px-4 py-3.5 outline-none focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059]/20 transition-all text-sm text-gray-800 placeholder-gray-400 rounded-sm shadow-sm" />
                        </div>
                        
                        <input required type="text" name="city" placeholder="City" 
                               class="w-full bg-white border border-gray-200 px-4 py-3.5 outline-none focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059]/20 transition-all text-sm text-gray-800 placeholder-gray-400 rounded-sm shadow-sm" />
                        
                        <input type="text" name="state" placeholder="State / Province (Optional)" 
                               class="w-full bg-white border border-gray-200 px-4 py-3.5 outline-none focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059]/20 transition-all text-sm text-gray-800 placeholder-gray-400 rounded-sm shadow-sm" />
                        
                        <input type="text" name="zipcode" placeholder="Zip / Postal Code (Optional)" 
                               class="w-full bg-white border border-gray-200 px-4 py-3.5 outline-none focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059]/20 transition-all text-sm text-gray-800 placeholder-gray-400 rounded-sm shadow-sm" />
                        
                        <input type="text" name="country" placeholder="Country" value="Pakistan" 
                               class="w-full bg-white border border-gray-200 px-4 py-3.5 outline-none focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059]/20 transition-all text-sm text-gray-800 placeholder-gray-400 rounded-sm shadow-sm" />
                        
                    </div>
                </div>

                <div class="w-full lg:w-[45%] xl:w-[40%] lg:sticky lg:top-28">
                    <div class="bg-white p-6 sm:p-8 border border-gray-100 shadow-md rounded-sm">
                        
                        <h3 class="text-sm font-bold tracking-widest text-[#121212] uppercase mb-4 border-b border-gray-200 pb-3">Order Items</h3>
                        <div class="max-h-48 overflow-y-auto mb-6 pr-2 space-y-4">
                            @foreach($cart as $item)
                                <div class="flex items-center gap-4">
                                    @if(isset($item['image']) && str_starts_with($item['image'], 'http'))
                                        <img src="{{ $item['image'] }}" class="w-12 h-16 object-cover border border-gray-100" alt="Product Image">
                                    @else
                                        <img src="{{ asset(($item['image'] ?? '')) }}" class="w-12 h-16 object-cover border border-gray-100" alt="Product Image">
                                    @endif
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-[#121212] truncate">{{ $item['name'] }}</p>
                                        <p class="text-xs text-gray-500 uppercase tracking-widest mt-1">Qty: {{ $item['quantity'] }}</p>
                                    </div>
@php
    $activePrice = (isset($item['discount_price']) && $item['discount_price'] > 0) ? $item['discount_price'] : $item['price'];
@endphp
<p class="text-sm font-bold text-[#C5A059]">PKR {{ number_format($activePrice * $item['quantity']) }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="mb-8 w-full">
                            <div class="flex items-center gap-2 text-xl mb-4" style="font-family: 'Playfair Display', serif;">
                                <span class="text-gray-400 font-light">CART</span> 
                                <span class="text-gray-900 font-medium">TOTALS</span>
                            </div>
                            <div class="flex flex-col gap-2 mt-2 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <p>Subtotal</p>
                                    <p>PKR {{ number_format($total) }}</p>
                                </div>
                                <hr class="border-gray-200 my-1" />
                                <div class="flex justify-between">
                                    <p>Shipping Fee</p>
                                    <p class="text-green-600 font-bold uppercase tracking-widest text-[10px]">Free</p>
                                </div>
                                <hr class="border-gray-200 my-1" />
                                <div class="flex justify-between text-base mt-1">
                                    <b class="text-gray-900">Total</b>
                                    <b class="text-[#121212]">PKR {{ number_format($total) }}</b>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-sm font-bold tracking-widest text-[#121212] uppercase mb-5 border-b border-gray-200 pb-3">Payment Method</h3>
                            
                            <div class="flex flex-col gap-4">
                                <div class="flex items-center gap-4 p-4 border rounded-sm cursor-default transition-all duration-300 border-[#C5A059] bg-[#C5A059]/5 shadow-sm">
                                    <div class="w-4 h-4 rounded-full border flex items-center justify-center transition-colors border-[#C5A059]">
                                        <div class="w-2 h-2 rounded-full bg-[#C5A059]"></div>
                                    </div>
                                    <p class="text-gray-700 text-sm font-bold tracking-wide uppercase">Cash on Delivery (COD)</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10">
                            <button type="submit" class="group relative w-full h-14 bg-[#121212] text-white text-xs sm:text-sm font-bold tracking-widest uppercase overflow-hidden transition-all duration-300 shadow-xl hover:shadow-[#C5A059]/20">
                                <span class="absolute inset-0 bg-[#C5A059] translate-y-full transition-transform duration-500 ease-out group-hover:translate-y-0"></span>
                                <span class="relative z-10 flex items-center justify-center gap-2 transition-colors duration-300">
                                    Place Order
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </span>
                            </button>
                        </div>

                        <div class="mt-6 flex items-center justify-center gap-2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            <span class="text-[10px] tracking-widest uppercase font-semibold">End-to-End Encrypted Checkout</span>
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>

</x-app-layout>