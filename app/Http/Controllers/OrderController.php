<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function myOrders() {
        // Agar user login nahi hai, toh wapas bhej do
        if(!Auth::check()) {
            return redirect('/login')->with('error', 'Please login to view your orders.');
        }

        // Sirf is user ke orders nikalo
        $orders = Order::with('items.product')
                    ->where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();
                    
        return view('user.orders', compact('orders'));
    }
}
