<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    public function index() {
        Log::info("USER SIDE: Kisi ne main store ka page open kiya.");
        
        // Products ke sath unki Categories bhi DB se nikalo
        $products = Product::with('category')->get();
        
        Log::info("USER SIDE: Database se " . $products->count() . " products fetch kiye gaye.");
        
        return view('shop.index', compact('products'));
    }
}