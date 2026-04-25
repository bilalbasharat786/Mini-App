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
                <a href="{{ route('admin.sliders') }}" class="text-sm font-semibold text-gray-300 hover:text-white transition">Manage Sliders</a>
                <a href="{{ route('shop.home') }}" class="text-sm font-bold text-blue-400 hover:text-blue-300 transition" target="_blank">Storefront ↗</a>
            </div>
        </div>
    </header>

    <div class="max-w-3xl mx-auto px-4 py-10">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-2xl font-bold mb-6 text-gray-900">Edit Product: {{ $product->name }}</h2>

            <form action="{{ route('admin.update_product', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
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

                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="w-full sm:w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Price (PKR)</label>
                        <input type="number" name="price" value="{{ $product->price }}" class="w-full border-gray-300 rounded-lg p-2" required>
                    </div>
                    <div class="w-full sm:w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Discount Price (PKR)</label>
                        <input type="number" name="discount_price" value="{{ $product->discount_price }}" class="w-full border-gray-300 rounded-lg p-2">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="w-full sm:w-1/3">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Color (e.g., Red, Blue)</label>
                        <input type="text" name="color" value="{{ $product->color }}" class="w-full border-gray-300 rounded-lg p-2" placeholder="Comma separated">
                    </div>
                    <div class="w-full sm:w-1/3">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Size (e.g., S, M, L)</label>
                        <input type="text" name="size" value="{{ $product->size }}" class="w-full border-gray-300 rounded-lg p-2" placeholder="Comma separated">
                    </div>
                    <div class="w-full sm:w-1/3">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Stock Quantity</label>
                        <input type="number" name="stock" value="{{ $product->stock }}" class="w-full border-gray-300 rounded-lg p-2">
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <h3 class="text-sm font-bold text-gray-800 mb-4">Update Product Images <span class="text-gray-400 font-normal text-xs">(Leave blank to keep existing images)</span></h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">Main Image</label>
                            <input type="file" name="image" accept="image/*" class="w-full border p-2 rounded-lg bg-gray-50 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">Image 2 (Optional)</label>
                            <input type="file" name="image_2" accept="image/*" class="w-full border p-2 rounded-lg bg-gray-50 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">Image 3 (Optional)</label>
                            <input type="file" name="image_3" accept="image/*" class="w-full border p-2 rounded-lg bg-gray-50 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">Image 4 (Optional)</label>
                            <input type="file" name="image_4" accept="image/*" class="w-full border p-2 rounded-lg bg-gray-50 text-sm">
                        </div>
                    </div>
                </div>

                <div class="pt-6 flex gap-4">
                    <button type="submit" class="bg-black text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-800 transition">
                        Update Product
                    </button>
                    <a href="{{ route('admin.manage_products') }}" class="bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-bold hover:bg-gray-400 transition text-center flex items-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>