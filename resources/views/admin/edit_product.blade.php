<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Product | Admin</title>
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
    <div class="max-w-3xl mx-auto px-4 py-10">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-2xl font-bold mb-6 text-gray-900">Edit Product: {{ $product->name }}</h2>

            <form action="{{ route('admin.update_product', $product->id) }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                    <select name="category_id" class="w-full border-gray-300 rounded-lg p-2 bg-white" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Product Name</label>
                    <input type="text" name="name" value="{{ $product->name }}" class="w-full border-gray-300 rounded-lg p-2" required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" rows="4" class="w-full border-gray-300 rounded-lg p-2">{{ $product->description }}</textarea>
                </div>

                <div class="flex gap-4">
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Price ($)</label>
                        <input type="number" name="price" value="{{ $product->price }}" class="w-full border-gray-300 rounded-lg p-2" required>
                    </div>
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Stock Quantity</label>
                        <input type="number" name="stock" value="{{ $product->stock }}" class="w-full border-gray-300 rounded-lg p-2">
                    </div>
                </div>

                <div class="pt-4 flex gap-4">
                    <button type="submit" class="bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800 transition">
                        Update Product
                    </button>
                    <a href="{{ route('admin.manage_products') }}" class="bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-bold hover:bg-gray-400 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>