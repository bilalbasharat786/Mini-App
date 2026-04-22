<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin - Add Product</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 p-50">
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
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Add New Product</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif
          <form action="{{ route('admin.store_product') }}" method="POST" class="space-y-4">
            @csrf
@if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul class="list-disc pl-5 font-semibold">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                <select name="category_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-black focus:ring-black" required>
                    <option value="" disabled selected>Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Product Name</label>
                <input type="text" name="name" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-black focus:ring-black" placeholder="e.g. Black T-Shirt" required>
            </div>
<div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Product Image</label>
                <input type="file" name="image" accept="image/*" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-black focus:ring-black p-2 bg-white">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-black focus:ring-black" placeholder="Product details..."></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Price ($)</label>
                    <input type="number" step="0.01" name="price" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-black focus:ring-black" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Stock Quantity</label>
                    <input type="number" name="stock" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-black focus:ring-black" required>
                </div>
            </div>

            <button type="submit" class="w-full bg-black text-white font-bold py-3 px-4 rounded-lg hover:bg-gray-800 transition duration-300 mt-4">
                Save Product
            </button>
        </form>
    </div>

    <script>
        const categoriesData = @json($categories);
        console.log("FRONTEND LOG: Add Product Page Loaded!");
        console.log("Categories passed from controller:", categoriesData);
    </script>
</body>
</html>