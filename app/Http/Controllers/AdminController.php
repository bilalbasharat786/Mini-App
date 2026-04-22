<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // 1. Admin ko Product Add karne ka form dikhana
    public function addProduct() {
        Log::info("STEP 1: Admin ne Add Product page open kiya.");
        
        $categories = Category::all();

        // Smart Trick: Agar category nahi hai toh ek default bana do taake error na aaye
        if($categories->isEmpty()) {
            Log::info("Database mein koi category nahi thi. Auto-creating 'Men' category.");
            Category::create(['name' => 'Men', 'slug' => 'men']);
            Category::create(['name' => 'Women', 'slug' => 'women']);
            $categories = Category::all();
        }

        return view('admin.add_product', compact('categories'));
    }

    // 2. Form ka data pakar kar Database mein save karna
  public function storeProduct(Request $request) {
        Log::info("STEP 2: Admin ne Form Submit kiya. Data:", $request->all());

        // Validation se image nikal di
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
        ]);

        try {
            // Har naye product ke liye ek alag Random Dummy Image generate hogi
            // rand(1, 1000) make sure karega ke tasweer hamesha unique ho
            $dummyImageUrl = 'https://picsum.photos/seed/' . rand(1, 1000) . '/400/300';

            $product = Product::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'description' => $request->description ?? 'No description',
                'price' => $request->price,
                'stock' => $request->stock ?? 0,
                'image_url' => $dummyImageUrl, // Dummy image DB mein save hogi
            ]);
            
            Log::info("STEP 3 SUCCESS: Product DB mein save ho gaya! ID: " . $product->id);
            return back()->with('success', 'Product Added Successfully with Dummy Image!');

        } catch (\Exception $e) {
            Log::error("STEP 3 FAIL: Error aaya: " . $e->getMessage());
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    // Admin: Saare Orders Dekhna
    public function viewOrders() {
        // 'items.product' ka matlab hai ke OrderItem aur Product dono ka data sath fetch karo
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

    // 3. Form se Data la kar Update karna (Bina Image ke)
    public function updateProduct(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
        ]);

        $product = \App\Models\Product::findOrFail($id);
        
        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description ?? 'No description',
            'price' => $request->price,
            'stock' => $request->stock ?? 0,
        ]);

        return redirect()->route('admin.manage_products')->with('success', 'Product Updated Successfully!');
    }

    // 4. Product ko hamesha ke liye Delete karna
    public function deleteProduct($id) {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();
        
        return back()->with('success', 'Product Deleted Successfully!');
    }
}
