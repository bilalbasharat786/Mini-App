<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Sliders | Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <header class="bg-black shadow-sm py-4">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Admin Dashboard</h1>
            <div class="flex gap-4 items-center">
                <a href="{{ route('admin.add_product') }}" class="text-sm font-semibold text-gray-300 hover:text-white transition">Add Product</a>
                                <a href="{{ route('admin.manage_products') }}" class="text-sm font-semibold text-gray-300 hover:text-white transition">Manage Products</a>
                <a href="{{ route('admin.orders') }}" class="text-sm font-semibold text-gray-300 hover:text-white transition">View Orders</a>  
                <a href="{{ route('admin.sliders') }}" class="text-sm font-semibold text-blue-400 hover:text-blue-300 transition">Manage Sliders</a>
                <a href="{{ route('shop.home') }}" class="text-sm font-bold text-blue-400 hover:text-blue-300 transition" target="_blank">Storefront ↗</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-8">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Upload New Slider Image</h2>
            @if(session('success')) <p class="text-green-600 font-bold mb-2">{{ session('success') }}</p> @endif
            <form action="{{ route('admin.store_slider') }}" method="POST" enctype="multipart/form-data" class="flex gap-4 items-end">
                @csrf
                <div class="flex-1">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Select Image (Resolution: 1920x600 recommended)</label>
                    <input type="file" name="image" required accept="image/*" class="w-full border p-2 rounded-lg bg-gray-50">
                </div>
                <button type="submit" class="bg-black text-white font-bold py-2 px-6 rounded-lg hover:bg-gray-800">Upload</button>
            </form>
        </div>

        <h2 class="text-xl font-bold mb-4 text-gray-800">Active Sliders</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($sliders as $slider)
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 relative">
                <img src="{{ asset('storage/' . $slider->image_url) }}" class="w-full h-40 object-cover rounded-lg mb-4">
                <form action="{{ route('admin.delete_slider', $slider->id) }}" method="POST" onsubmit="return confirm('Delete this slider?');">
                    @csrf @method('DELETE')
                    <button class="w-full bg-red-500 text-white font-bold py-2 rounded-lg hover:bg-red-600">Delete Slider</button>
                </form>
            </div>
            @endforeach
        </div>
    </main>
</body>
</html>