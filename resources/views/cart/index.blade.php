<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Cart | Jamal Collection</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    <header class="bg-white shadow-sm py-4">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <a href="{{ route('shop.home') }}" class="text-2xl font-extrabold text-gray-900 tracking-tight hover:text-gray-700 transition">Jamal Collection</a>
            <a href="{{ route('shop.home') }}" class="text-sm font-semibold text-blue-600 hover:underline">&larr; Continue Shopping</a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-10">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Shopping Cart</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="w-full lg:w-2/3 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 text-sm uppercase tracking-wider">
                                <th class="p-4 font-semibold">Product</th>
                                <th class="p-4 font-semibold text-center">Quantity</th>
                                <th class="p-4 font-semibold text-right">Price</th>
                                <th class="p-4 font-semibold text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($cart as $id => $details)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 flex items-center gap-4">
                                        <img src="{{ $details['image'] }}" class="w-20 h-20 object-cover rounded-lg shadow-sm" alt="Product Image">
                                        <h3 class="font-bold text-gray-900 text-lg">{{ $details['name'] }}</h3>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="bg-gray-100 text-gray-800 font-bold px-3 py-1 rounded-full">{{ $details['quantity'] }}</span>
                                    </td>
                                    <td class="p-4 text-right font-extrabold text-gray-900 text-lg">
                                        ${{ number_format($details['price'], 2) }}
                                    </td>
                                    <td class="p-4 text-right">
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-red-500 font-bold hover:text-red-700 hover:underline">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h3>
                        
                        <div class="flex justify-between mb-4 text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-bold">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-4 text-gray-600">
                            <span>Shipping</span>
                            <span class="text-green-500 font-bold">Free</span>
                        </div>
                        
                        <hr class="my-4 border-gray-100">
                        
                        <div class="flex justify-between mb-6 text-2xl font-extrabold text-gray-900">
                            <span>Total</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>

                     <a href="{{ route('checkout.index') }}" class="block w-full text-center bg-black text-white font-bold py-4 rounded-xl hover:bg-gray-800 transition duration-300 shadow-lg text-lg">
    Proceed to Checkout
</a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="text-6xl mb-4">🛒</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-500 mb-6">Looks like you haven't added any premium fashion items yet.</p>
                <a href="{{ route('shop.home') }}" class="inline-block bg-black text-white font-bold py-3 px-8 rounded-xl hover:bg-gray-800 transition">
                    Start Shopping
                </a>
            </div>
        @endif
    </main>

    <script>
        const cartData = @json($cart);
        console.log("FRONTEND LOG: Cart Page Loaded!");
        console.log("Cart Items:", cartData);
    </script>
</body>
</html>