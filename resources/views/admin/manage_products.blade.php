<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Products | Admin</title>
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
                <a href="{{ route('admin.sliders') }}" class="text-sm font-semibold text-yellow-400 hover:text-yellow-300 transition">Manage Sliders</a>
                <a href="{{ route('shop.home') }}" class="text-sm font-bold text-blue-400 hover:text-blue-300 transition" target="_blank">Storefront ↗</a>
            </div>
        </div>
    </header>
    
    <main class="max-w-7xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 font-bold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm uppercase">
                        <th class="p-4">Product Details</th>
                        <th class="p-4">Category</th>
                        <th class="p-4">Price</th>
                        <th class="p-4">Stock</th>
                        <th class="p-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 flex items-center gap-4">
                                @if($product->image_url)
                                    @if(str_starts_with($product->image_url, 'http'))
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-lg shadow-sm border border-gray-200">
                                    @else
                                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-lg shadow-sm border border-gray-200">
                                    @endif
                                @else
                                    <img src="https://picsum.photos/seed/{{ $product->id }}/400/300" alt="Dummy Image" class="w-12 h-12 object-cover rounded-lg shadow-sm border border-gray-200">
                                @endif
                                
                                <span class="font-bold text-gray-900">{{ $product->name }}</span>
                            </td>
                            <td class="p-4 text-gray-600">{{ $product->category->name ?? 'N/A' }}</td>
                            <td class="p-4 font-bold text-green-600">${{ number_format($product->price, 2) }}</td>
                            <td class="p-4 text-gray-600">{{ $product->stock }}</td>
                            <td class="p-4 flex justify-center gap-3">
                                <a href="{{ route('admin.edit_product', $product->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded text-sm font-bold hover:bg-blue-600 transition">Edit</a>
                                
                                <form action="{{ route('admin.delete_product', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded text-sm font-bold hover:bg-red-600 transition">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>