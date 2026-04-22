<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Orders | Jamal Collection</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
<header class="bg-black shadow-sm py-4">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Admin Dashboard</h1>
            <div class="flex flex-wrap justify-center gap-4 items-center">
                <a href="{{ route('admin.add_product') }}" class="text-sm font-semibold text-gray-300 hover:text-white transition">Add Product</a>
                <a href="{{ route('admin.manage_products') }}" class="text-sm font-semibold text-gray-300 hover:text-white transition">Manage Products</a>
                <a href="{{ route('admin.orders') }}" class="text-sm font-semibold text-gray-300 hover:text-white transition">View Orders</a>
                <a href="{{ route('shop.home') }}" class="text-sm font-bold text-blue-400 hover:text-blue-300 transition" target="_blank">Storefront ↗</a>
            </div>
        </div>
    </header>
    <main class="max-w-7xl mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-900">Recent Orders</h2>

        @if($orders->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-10 text-center">
                <p class="text-gray-500 text-lg">Abhi tak koi order nahi aaya. Store ki marketing karein! 🚀</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        
                        <div class="bg-gray-100 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <div>
                                <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">Order ID: #{{ $order->id }}</span>
                                <span class="ml-4 text-sm text-gray-600">{{ $order->created_at->format('d M, Y - h:i A') }}</span>
                            </div>
                            <div>
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full uppercase">
                                    {{ $order->status }}
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row divide-y md:divide-y-0 md:divide-x divide-gray-100">
                            
                            <div class="w-full md:w-2/3 p-6">
                                <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Products Ordered</h3>
                                <ul class="space-y-4">
                                    @foreach($order->items as $item)
                                        <li class="flex items-center justify-between">
                                            <div class="flex items-center gap-4">
                                                <img src="{{ $item->product->image_url ?? 'https://picsum.photos/seed/'.$item->product->id.'/100/100' }}" 
                                                     class="w-16 h-16 object-cover rounded shadow-sm">
                                                
                                                <div>
                                                    <p class="font-bold text-gray-900">{{ $item->product->name ?? 'Deleted Product' }}</p>
                                                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} x ${{ number_format($item->price, 2) }}</p>
                                                </div>
                                            </div>
                                            <div class="font-bold text-gray-900">
                                                ${{ number_format($item->quantity * $item->price, 2) }}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="w-full md:w-1/3 p-6 bg-gray-50">
                                <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Customer Details</h3>
                                
                                <div class="text-sm text-gray-700 space-y-2">
                                    <p><span class="font-semibold text-gray-900">Total Amount:</span> <span class="text-lg font-extrabold text-green-600">${{ number_format($order->total_price, 2) }}</span></p>
                                    <p class="mt-4"><span class="font-semibold text-gray-900">Shipping Info:</span></p>
                                    <p class="bg-white p-3 rounded border text-gray-600 leading-relaxed">
                                        {{ $order->shipping_address }}
                                    </p>
                                </div>

                                <div class="mt-6 border-t pt-4">
                                    <form action="{{ route('admin.order.status', $order->id) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        <select name="status" class="w-full border-gray-300 rounded shadow-sm focus:ring-black text-sm">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition text-sm font-bold">
                                            Update
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

</body>
</html>