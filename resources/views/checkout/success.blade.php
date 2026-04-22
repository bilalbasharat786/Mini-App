<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Success | Jamal Collection</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="text-center bg-white p-12 rounded-3xl shadow-xl border border-gray-100 max-w-md w-full">
        <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">
            ✓
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Order Confirmed!</h2>
        <p class="text-gray-500 mb-8 text-lg">Thank you for shopping. Your order ID is <span class="font-bold text-black">#{{ $order_id }}</span>.</p>
        
        <a href="{{ route('shop.home') }}" class="block w-full bg-black text-white font-bold py-4 rounded-xl hover:bg-gray-800 transition">
            Continue Shopping
        </a>
    </div>
</body>
</html>