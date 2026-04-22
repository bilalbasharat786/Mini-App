<!DOCTYPE html>
<html lang="en">
<head>
    <title>Jamal Collection | Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    <header class="bg-white shadow-sm py-4">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Jamal Collection</h1>
            
            <div class="flex items-center gap-5">
                <a href="{{ route('cart.index') }}" class="relative group">
                    <span class="text-gray-600 group-hover:text-black font-bold flex items-center gap-1">
                        🛒 Cart
                        @if(session('cart'))
                            <span class="bg-black text-white text-[10px] px-2 py-0.5 rounded-full">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </span>
                </a>
                
                <a href="{{ route('user.orders') }}" class="text-sm font-bold text-blue-600 hover:underline">My Orders</a>
                
                <a href="{{ url('/welcome') }}" class="text-sm font-semibold text-gray-600 hover:text-black">Account</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Latest Arrivals</h2>

        @if($products->isEmpty())
            <div class="text-center py-10 text-gray-500">
                <p>No products available right now. Check back later!</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition duration-300">
                        
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
                        @else
                            <img src="https://picsum.photos/seed/{{ $product->id }}/400/300" alt="Dummy Image" class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
                        @endif
                        
                        <div class="p-5">
                            <span class="text-xs font-semibold text-blue-500 uppercase tracking-wider">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </span>
                            <h3 class="text-lg font-bold text-gray-900 mt-1">{{ $product->name }}</h3>
                            <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $product->description }}</p>
                            
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-xl font-extrabold text-black">${{ number_format($product->price, 2) }}</span>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-black text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-800 transition shadow-md active:scale-95">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <script>
        const productsData = @json($products);
        console.log("FRONTEND LOG: Store Page Loaded!");
        console.log("Total Products Loaded:", productsData.length);
        console.log("Product Details:", productsData);
    </script>
</body>
</html>