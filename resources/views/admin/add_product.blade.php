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
                <a href="{{ route('admin.sliders') }}" class="text-sm font-semibold text-yellow-400 hover:text-yellow-300 transition">Manage Sliders</a>
                <a href="{{ route('shop.home') }}" class="text-sm font-bold text-blue-400 hover:text-blue-300 transition" target="_blank">Storefront ↗</a>
            </div>
        </div>
    </header>
    
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md mt-10 mb-10">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Add New Product (With Gallery & Details)</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 font-bold">
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
        
        <form action="{{ route('admin.store_product') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
            </div>

            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Product Images (Up to 4)</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-gray-700 text-xs font-bold mb-1">Main Image *</label>
                        <input type="file" id="img-1" name="image" accept="image/*" class="w-full text-sm border-gray-300 rounded-lg bg-white mb-2 cursor-pointer" required>
                        <div id="preview-box-1" class=" border rounded-lg overflow-hidden w-full h-32 bg-white flex items-center justify-center">
                            <img id="preview-1" src="" class="object-cover w-full h-full">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-xs font-bold mb-1">Image 2</label>
                        <input type="file" id="img-2" name="image_2" accept="image/*" class="w-full text-sm border-gray-300 rounded-lg bg-white mb-2 cursor-pointer">
                        <div id="preview-box-2" class="hidden border rounded-lg overflow-hidden w-full h-32 bg-white items-center justify-center">
                            <img id="preview-2" src="" class="object-cover w-full h-full">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-xs font-bold mb-1">Image 3</label>
                        <input type="file" id="img-3" name="image_3" accept="image/*" class="w-full text-sm border-gray-300 rounded-lg bg-white mb-2 cursor-pointer">
                        <div id="preview-box-3" class="hidden border rounded-lg overflow-hidden w-full h-32 bg-white  items-center justify-center">
                            <img id="preview-3" src="" class="object-cover w-full h-full">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-xs font-bold mb-1">Image 4</label>
                        <input type="file" id="img-4" name="image_4" accept="image/*" class="w-full text-sm border-gray-300 rounded-lg bg-white mb-2 cursor-pointer">
                        <div id="preview-box-4" class="hidden border rounded-lg overflow-hidden w-full h-32 bg-white items-center justify-center">
                            <img id="preview-4" src="" class="object-cover w-full h-full">
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-black focus:ring-black" placeholder="Product details..."></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-gray-50 p-6 rounded-xl border border-gray-200">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Original Price ($) *</label>
                    <input type="number" step="0.01" name="price" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-black focus:ring-black" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Discount Price ($)</label>
                    <input type="number" step="0.01" name="discount_price" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-black focus:ring-black" placeholder="Optional">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Stock Quantity *</label>
                    <input type="number" name="stock" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-black focus:ring-black" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Colors</label>
                    <input type="text" name="color" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-black focus:ring-black" placeholder="e.g. Red, Blue, Black">
                    <span class="text-xs text-gray-500">Comma separated</span>
                </div>
                <div class="col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Sizes</label>
                    <input type="text" name="size" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-black focus:ring-black" placeholder="e.g. S, M, L, XL or 30, 32, 34">
                    <span class="text-xs text-gray-500">Comma separated</span>
                </div>
            </div>

            <button type="submit" class="w-full bg-black text-white font-bold py-4 px-4 rounded-xl hover:bg-gray-800 transition duration-300 shadow-lg mt-4 text-lg">
                Save Product
            </button>
        </form>
    </div>

    <script>
        // NAYA: Multi-Image Live Preview Script
        function setupPreview(inputId, previewBoxId, previewImgId) {
            document.getElementById(inputId).addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById(previewImgId).src = e.target.result;
                        document.getElementById(previewBoxId).classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                } else {
                    document.getElementById(previewBoxId).classList.add('hidden');
                }
            });
        }

        setupPreview('img-1', 'preview-box-1', 'preview-1');
        setupPreview('img-2', 'preview-box-2', 'preview-2');
        setupPreview('img-3', 'preview-box-3', 'preview-3');
        setupPreview('img-4', 'preview-box-4', 'preview-4');
    </script>
</body>
</html>