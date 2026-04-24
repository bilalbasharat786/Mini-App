<x-app-layout>

    <main class="max-w-[900px] mx-auto px-4 py-10 sm:py-16">
        
        <div class="flex flex-col items-center sm:items-start mb-10 sm:mb-14">
            <span class="text-[#C5A059] text-[10px] sm:text-xs font-bold tracking-[0.3em] uppercase mb-2">
                Order History
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-widest uppercase flex gap-3" style="font-family: 'Playfair Display', serif;">
                <span class="text-gray-400 font-light">MY</span> <span class="text-gray-900">ORDERS</span>
            </h2>
        </div>

        @if($orders->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 bg-white border border-gray-100 shadow-sm max-w-3xl mx-auto">
                <svg class="w-16 h-16 text-gray-300 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <h3 class="text-xl sm:text-3xl text-[#121212] mb-3" style="font-family: 'Playfair Display', serif;">No orders found</h3>
                <p class="text-gray-500 mb-8 text-sm">You haven't placed any premium selections yet.</p>
                <a href="{{ route('shop.home') }}" class="bg-[#121212] text-white px-8 py-4 text-xs font-bold tracking-widest uppercase hover:bg-[#C5A059] transition-colors shadow-md">
                    Start Shopping
                </a>
            </div>
        @else
            <div class="space-y-8">
                @foreach($orders as $order)
                    <div class="bg-white shadow-sm border border-gray-100 transition-all hover:shadow-md">
                        
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                            <div>
                                <span class="text-sm font-bold text-[#121212] tracking-widest uppercase">Order #{{ $order->id }}</span>
                                <span class="ml-0 sm:ml-3 block sm:inline-block text-xs text-gray-500 font-medium mt-1 sm:mt-0">{{ $order->created_at->format('d M, Y') }}</span>
                            </div>
                            
                            @php
                                // Premium Status Colors
                                $colorClass = 'bg-yellow-100 text-yellow-800 border-yellow-200'; // Pending
                                if($order->status == 'shipped') $colorClass = 'bg-blue-100 text-blue-800 border-blue-200';
                                if($order->status == 'delivered') $colorClass = 'bg-green-100 text-green-800 border-green-200';
                                if($order->status == 'cancelled') $colorClass = 'bg-red-100 text-red-800 border-red-200';
                            @endphp
                            
                            <span class="{{ $colorClass }} border text-[10px] sm:text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-widest shadow-sm w-fit">
                                {{ $order->status }}
                            </span>
                        </div>

                        <div class="p-6">
                            <ul class="divide-y divide-gray-100">
                                @foreach($order->items as $item)
                                    <li class="py-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                        <div class="flex items-center w-full">
                                            
                                            <div class="w-16 sm:w-20 aspect-[3/4] bg-gray-50 border border-gray-100 overflow-hidden shrink-0">
                                                @if(isset($item->product->image_url) && str_starts_with($item->product->image_url, 'http'))
                                                    <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover object-top" alt="Product Image">
                                                @elseif(isset($item->product->image_url))
                                                    <img src="{{ asset('storage/' . $item->product->image_url) }}" class="w-full h-full object-cover object-top" alt="Product Image">
                                                @else
                                                    <img src="https://picsum.photos/seed/{{ $item->id }}/100/133" class="w-full h-full object-cover object-top" alt="Dummy Image">
                                                @endif
                                            </div>
                                            
                                            <div class="ml-4 flex-1">
                                                <p class="font-bold text-[#121212] uppercase tracking-wide text-sm sm:text-base">{{ $item->product->name ?? 'Deleted Product' }}</p>
                                                
                                                <div class="mt-1 flex items-center gap-4">
                                                    <p class="text-xs text-gray-500 uppercase tracking-widest">Qty: <span class="font-bold text-[#121212]">{{ $item->quantity }}</span></p>
                                                    
                                                    @if(isset($item->size) && $item->size)
                                                        <p class="text-xs text-gray-500 uppercase tracking-widest">Size: <span class="font-bold text-[#121212]">{{ $item->size }}</span></p>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="text-right">
                                                <p class="font-bold text-[#121212] text-sm sm:text-base">PKR {{ number_format($item->price * $item->quantity) }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            
                            <div class="mt-6 pt-6 border-t border-gray-100 flex justify-between items-end">
                                <div>
                                    <span class="text-gray-400 text-[10px] uppercase tracking-widest block mb-1">Total Paid</span>
                                    <span class="text-[#121212] font-semibold text-sm">Including Delivery</span>
                                </div>
                                <span class="text-xl sm:text-2xl font-extrabold text-[#C5A059]">PKR {{ number_format($order->total_price) }}</span>
                            </div>
                        </div>
                        
                    </div>
                @endforeach
            </div>
        @endif
    </main>

</x-app-layout>