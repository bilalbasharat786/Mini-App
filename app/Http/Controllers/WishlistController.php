<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WishlistController extends Controller
{
    // 1. Wishlist ka page dikhana
    public function index() {
        $wishlist_ids = session()->get('wishlist', []);
        
        // Database se sirf wo products nikalo jin ki IDs session mein hain
        $products = Product::whereIn('id', $wishlist_ids)->get();
        
        return view('wishlist.index', compact('products'));
    }

    // 2. Product ko Wishlist mein daalna
    public function add($id) {
        $wishlist = session()->get('wishlist', []);

        // Check karo ke pehle se toh nahi para hua
        if(!in_array($id, $wishlist)) {
            $wishlist[] = $id;
            session()->put('wishlist', $wishlist);
            return back()->with('success', 'Item added to your Wishlist! ❤️');
        }

        return back()->with('success', 'Item is already in your Wishlist!');
    }

    // 3. Product ko Wishlist se nikalna
    public function remove($id) {
        $wishlist = session()->get('wishlist', []);

        if(($key = array_search($id, $wishlist)) !== false) {
            unset($wishlist[$key]);
            session()->put('wishlist', $wishlist); // Update session
        }

        return back()->with('success', 'Item removed from Wishlist!');
    }
}