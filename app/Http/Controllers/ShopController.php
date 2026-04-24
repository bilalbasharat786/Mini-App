<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Slider; // NAYA: Slider model yahan add kiya hai
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    // NAYA FUNCTION: Contact Us Page ke liye
    public function contact() {
        return view('shop.contact');
    }
    // NAYA FUNCTION: Search ke liye
    public function search(Request $request) {
        $query = $request->input('q'); // 'q' hamare search input ka naam hoga
        $products = collect(); // Default empty collection
        
        if ($query) {
            // LIKE query automatically capital/small letters ko handle kar leti hai
            $products = \App\Models\Product::where('name', 'LIKE', '%' . $query . '%')
                                           ->orWhere('description', 'LIKE', '%' . $query . '%')
                                           ->get();
        }

        return view('shop.search', compact('products', 'query'));
    }
    // NAYA FUNCTION: Category ke hisaab se products dikhane ke liye
    public function category($slug) {
        // 1. URL se slug (men/women) pakar kar database se category nikalo
        $category = \App\Models\Category::where('slug', strtolower($slug))->orWhere('name', $slug)->firstOrFail();
        
        // 2. Sirf usi category ke products nikalo
        $products = \App\Models\Product::where('category_id', $category->id)->get();
        
        // 3. Naye page par bhej do
        return view('shop.category', compact('category', 'products'));
    }
    public function index() {
        Log::info("USER SIDE: Kisi ne main store ka page open kiya.");
        
        // NAYA: Hero section ke liye auto-sliding banners database se nikalo
        $sliders = Slider::where('is_active', true)->orderBy('created_at', 'desc')->get();
        
        // Products ke sath unki Categories bhi DB se nikalo
        $products = Product::with('category')->get();
        
        Log::info("USER SIDE: Database se " . $products->count() . " products aur " . $sliders->count() . " sliders fetch kiye gaye.");
        
        // NAYA: 'sliders' variable ko frontend view mein pass kiya
        return view('shop.index', compact('products', 'sliders'));
    }

    public function showProduct($id) {
        $product = Product::with('category')->findOrFail($id);
        return view('shop.show', compact('product'));
    }
}