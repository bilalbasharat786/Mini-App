<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Orders | Jamal Collection</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    <header class="bg-white shadow-sm py-4">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <a href="{{ route('shop.home') }}" class="text-2xl font-extrabold text-gray-900 tracking-tight hover:text-gray-700 transition">Jamal Collection</a>
            <a href="{{ route('shop.home') }}" class="text-sm font-semibold text-blue-600 hover:underline">&larr; Back to Shop</a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-10">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8">My Orders</h2>

        @if($orders->isEmpty())
            <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="text-6xl mb-4">📦</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No orders found</h3>
                <p class="text-gray-500 mb-6">You haven't placed any orders yet.</p>
                <a href="{{ route('shop.home') }}" class="inline-block bg-black text-white font-bold py-3 px-8 rounded-xl hover:bg-gray-800 transition">Start Shopping</a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <div>
                                <span class="text-sm font-bold text-gray-500 uppercase">Order #{{ $order->id }}</span>
                                <span class="ml-3 text-sm text-gray-500">{{ $order->created_at->format('d M, Y') }}</span>
                            </div>
                            
                            @php
                                $color = 'bg-yellow-100 text-yellow-800'; // Pending
                                if($order->status == 'shipped') $color = 'bg-blue-100 text-blue-800';
                                if($order->status == 'delivered') $color = 'bg-green-100 text-green-800';
                                if($order->status == 'cancelled') $color = 'bg-red-100 text-red-800';
                            @endphp
                            
                            <span class="{{ $color }} text-xs font-bold px-3 py-1 rounded-full uppercase">
                                {{ $order->status }}
                            </span>
                        </div>

                        <div class="p-6">
                            <ul class="divide-y divide-gray-100">
                                @foreach($order->items as $item)
                                    <li class="py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                                        <div class="flex items-center w-full">
                                            <img src="{{ $item->product->image_url ?? 'https://picsum.photos/seed/'.$item->product->id.'/100/100' }}" class="w-16 h-16 object-cover rounded shadow-sm">
                                            <div class="ml-4 flex-1">
                                                <p class="font-bold text-gray-900">{{ $item->product->name ?? 'Deleted Product' }}</p>
                                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                            </div>
                                            <p class="font-bold text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            
                            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                                <span class="text-gray-600 font-semibold">Total Paid:</span>
                                <span class="text-xl font-extrabold text-green-600">${{ number_format($order->total_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
</body>
</html>