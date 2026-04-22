<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout | Jamal Collection</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <h2 class="text-2xl font-bold mb-6 text-gray-900">Shipping Information</h2>
                
                <form action="{{ route('checkout.place_order') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-black focus:border-black" required>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-black focus:border-black" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" name="city" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-black focus:border-black" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Detailed Address</label>
                        <textarea name="address" rows="3" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-black focus:border-black" required></textarea>
                    </div>

                    <div class="pt-6">
                        <h3 class="text-lg font-bold mb-4">Payment Method</h3>
                        <div class="flex items-center p-4 border border-black rounded-xl bg-gray-50">
                            <input type="radio" checked class="text-black focus:ring-black">
                            <span class="ml-3 font-semibold text-gray-900">Cash on Delivery (COD)</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-8 bg-black text-white font-bold py-4 rounded-xl hover:bg-gray-800 transition shadow-lg text-lg">
                        Confirm Order
                    </button>
                </form>
            </div>

            <div class="space-y-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold mb-6">Your Order</h2>
                    <div class="flow-root">
                        <ul class="divide-y divide-gray-100">
                            @foreach($cart as $item)
                            <li class="py-4 flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="{{ $item['image'] }}" class="w-16 h-16 object-cover rounded-lg">
                                    <div class="ml-4">
                                        <p class="font-bold text-gray-900">{{ $item['name'] }}</p>
                                        <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                    </div>
                                </div>
                                <p class="font-bold text-gray-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="mt-6 border-t pt-4 space-y-2">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-2xl font-extrabold text-gray-900 pt-2">
                            <span>Total</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>