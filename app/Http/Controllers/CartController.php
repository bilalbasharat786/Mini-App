<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // 1. Cart Page Dikhana
    public function index() {
        Log::info("CART LOG: User opened the cart page.");
        
        $cart = session()->get('cart', []); // Session se cart nikaalo
        
        // Total price calculate karna
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    // 2. Product ko Cart mein daalna
    public function addToCart(Request $request, $id) {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // Agar product pehle se cart mein hai, toh sirf quantity barha do
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
            Log::info("CART LOG: Increased quantity for product ID: " . $id);
        } else {
            // Agar naya product hai toh cart mein add karo
            $imageUrl = $product->image_url ?? 'https://picsum.photos/seed/'.$product->id.'/400/300';
            
          $cart[$id] = [
    "name" => $product->name,
    "quantity" => 1,
    "price" => $product->price,
    "discount_price" => $product->discount_price, // <--- یہ لائن لازمی ہونی چاہیے!
    "image" => $product->image_url,
    "size" => $request->size,
    "color" => $request->color
];
            Log::info("CART LOG: Added new product to cart ID: " . $id);
        }

        session()->put('cart', $cart); 
        
        // YAHAN THEEK KIYA HAI: Ab yeh direct cart page par le jayega
        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    // 3. Cart se product nikalna
    public function remove(Request $request, $id) {
        $cart = session()->get('cart');
        
        if(isset($cart[$id])) {
            unset($cart[$id]); 
            session()->put('cart', $cart);
            Log::info("CART LOG: Removed product ID: " . $id . " from cart.");
        }

        // YAHAN THEEK KIYA HAI: Remove karne ke baad back usi cart page par rahay
        return redirect()->back()->with('success', 'Product removed from cart!');
    }
    // Cart mein Quantity Update karne ka function
    public function update(Request $request, $id) {
        $request->validate([
            'quantity' => 'required|numeric|min:1'
        ]);

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return back()->with('success', 'Cart quantity updated!');
        }

        return back()->with('error', 'Item not found in cart.');
    }
}