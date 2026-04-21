<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // 1. Admin Form dikhane ke liye
    public function create() {
        return view('admin.add_product');
    }

    // 2. Product Save karne ke liye
    public function store(Request $request) {
        // Debugging: Check incoming data
        Log::info("Admin submitted a product:", $request->all());

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        if($product) {
            Log::info("Product successfully saved in DB. ID: " . $product->id);
        } else {
            Log::error("Failed to save product in database.");
        }

        return back()->with('success', 'Product added successfully!');
    }

    // 3. User Website par Products dikhane ke liye
    public function index() {
        $products = Product::all();
        Log::info("Fetched all products for storefront. Count: " . $products->count());
        return view('store.index', compact('products'));
    }
}
