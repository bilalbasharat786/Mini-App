<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; 
use App\Models\Slider;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    // --- SLIDER MANAGEMENT LOGIC ---

   // 1. Sliders ka page dikhana
    public function manageSliders() {
        $sliders = Slider::orderBy('created_at', 'desc')->get();
        return view('admin.sliders', compact('sliders'));
    }

    // 2. Naya Slider Image Save Karna (Direct in Public Folder)
    public function storeSlider(Request $request) {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072', // Max 3MB
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_slider_' . $file->getClientOriginalName();
            
            // MAGIC YAHAN HAI: Direct public/images/sliders folder mein move kar do
            $file->move(public_path('images/sliders'), $filename); 

            // Database mein mukammal path save karo taake frontend pe easily show ho
            $imageUrl = 'images/sliders/' . $filename;

            Slider::create(['image_url' => $imageUrl]);
            return back()->with('success', 'Slider Image Added Successfully!');
        }
        return back()->with('error', 'Please select an image.');
    }

    // 3. Slider Delete Karna (Database + Folder se)
    public function deleteSlider($id) {
        $slider = Slider::findOrFail($id);
        
        if ($slider->image_url && !str_contains($slider->image_url, 'http')) { 
            // Public folder se physically tasweer dhoond kar delete karna
            $imagePath = public_path($slider->image_url);
            if(File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        
        $slider->delete(); // Database se delete
        
        return back()->with('success', 'Slider Image Deleted Completely!');
    }

    // 1. Admin ko Product Add karne ka form dikhana
    public function addProduct() {
        $categories = Category::all();

        if($categories->isEmpty()) {
            Category::create(['name' => 'Men', 'slug' => 'men']);
            Category::create(['name' => 'Women', 'slug' => 'women']);
            $categories = Category::all();
        }

        return view('admin.add_product', compact('categories'));
    }

    // 2. Form ka data pakar kar Database mein save karna
public function storeProduct(Request $request) {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'category_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', 
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try {
            $img1 = null; $img2 = null; $img3 = null; $img4 = null;
            $path = public_path('images/products'); // NAYA PATH

            if ($request->hasFile('image')) {
                $filename = time() . '_1_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move($path, $filename);
                $img1 = 'images/products/' . $filename; 
            }
            if ($request->hasFile('image_2')) {
                $filename = time() . '_2_' . $request->file('image_2')->getClientOriginalName();
                $request->file('image_2')->move($path, $filename);
                $img2 = 'images/products/' . $filename; 
            }
            if ($request->hasFile('image_3')) {
                $filename = time() . '_3_' . $request->file('image_3')->getClientOriginalName();
                $request->file('image_3')->move($path, $filename);
                $img3 = 'images/products/' . $filename; 
            }
            if ($request->hasFile('image_4')) {
                $filename = time() . '_4_' . $request->file('image_4')->getClientOriginalName();
                $request->file('image_4')->move($path, $filename);
                $img4 = 'images/products/' . $filename; 
            }

            $product = Product::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'description' => $request->description ?? 'No description',
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'color' => $request->color,                  
                'size' => $request->size,                    
                'stock' => $request->stock ?? 0,
                'image_url' => $img1,
                'image_url_2' => $img2,
                'image_url_3' => $img3,
                'image_url_4' => $img4,
            ]);
            
            return back()->with('success', 'Product & All Images Added Successfully!');

        } catch (\Exception $e) {
            Log::error("FAIL: Error aaya: " . $e->getMessage());
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    // Admin: Saare Orders Dekhna
    public function viewOrders() {
        $orders = \App\Models\Order::with('items.product')->orderBy('created_at', 'desc')->get();
        return view('admin.orders', compact('orders'));
    }

    // Admin: Order ka Status Update Karna
    public function updateOrderStatus(Request $request, $id) {
        $order = \App\Models\Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        
        return back()->with('success', 'Order status updated successfully!');
    }

    // 1. Saare Products ki List Dikhana (Manage Products)
    public function manageProducts() {
        $products = \App\Models\Product::with('category')->orderBy('created_at', 'desc')->get();
        return view('admin.manage_products', compact('products'));
    }

    // 2. Edit ka Form Dikhana
    public function editProduct($id) {
        $product = \App\Models\Product::findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('admin.edit_product', compact('product', 'categories'));
    }
public function updateProduct(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'category_id' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $product = \App\Models\Product::findOrFail($id);
        
        $img1 = $product->image_url;
        $img2 = $product->image_url_2;
        $img3 = $product->image_url_3;
        $img4 = $product->image_url_4;
        
        $path = public_path('images/products');

        if ($request->hasFile('image')) {
            if ($img1 && !str_contains($img1, 'http') && File::exists(public_path($img1))) { File::delete(public_path($img1)); }
            $filename = time() . '_1_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move($path, $filename);
            $img1 = 'images/products/' . $filename;
        }
        if ($request->hasFile('image_2')) {
            if ($img2 && !str_contains($img2, 'http') && File::exists(public_path($img2))) { File::delete(public_path($img2)); }
            $filename = time() . '_2_' . $request->file('image_2')->getClientOriginalName();
            $request->file('image_2')->move($path, $filename);
            $img2 = 'images/products/' . $filename;
        }
        if ($request->hasFile('image_3')) {
            if ($img3 && !str_contains($img3, 'http') && File::exists(public_path($img3))) { File::delete(public_path($img3)); }
            $filename = time() . '_3_' . $request->file('image_3')->getClientOriginalName();
            $request->file('image_3')->move($path, $filename);
            $img3 = 'images/products/' . $filename;
        }
        if ($request->hasFile('image_4')) {
            if ($img4 && !str_contains($img4, 'http') && File::exists(public_path($img4))) { File::delete(public_path($img4)); }
            $filename = time() . '_4_' . $request->file('image_4')->getClientOriginalName();
            $request->file('image_4')->move($path, $filename);
            $img4 = 'images/products/' . $filename;
        }
        
        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description ?? 'No description',
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'color' => $request->color,                  
            'size' => $request->size,                    
            'stock' => $request->stock ?? 0,
            'image_url' => $img1,
            'image_url_2' => $img2,
            'image_url_3' => $img3,
            'image_url_4' => $img4,
        ]);

        return redirect()->route('admin.manage_products')->with('success', 'Product Updated Successfully!');
    }

    // 4. Product ko hamesha ke liye Delete karna
    public function deleteProduct($id) {
        $product = \App\Models\Product::findOrFail($id);
        
        if ($product->image_url && !str_contains($product->image_url, 'http') && File::exists(public_path($product->image_url))) { File::delete(public_path($product->image_url)); }
        if ($product->image_url_2 && !str_contains($product->image_url_2, 'http') && File::exists(public_path($product->image_url_2))) { File::delete(public_path($product->image_url_2)); }
        if ($product->image_url_3 && !str_contains($product->image_url_3, 'http') && File::exists(public_path($product->image_url_3))) { File::delete(public_path($product->image_url_3)); }
        if ($product->image_url_4 && !str_contains($product->image_url_4, 'http') && File::exists(public_path($product->image_url_4))) { File::delete(public_path($product->image_url_4)); }

        $product->delete();
        
        return back()->with('success', 'Product & All Images Deleted Successfully!');
    }
}