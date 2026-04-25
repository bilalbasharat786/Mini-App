<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
   public function myOrders() {
        // Naya Logic: Login User ya Guest User dono ke orders dikhao
        $query = \App\Models\Order::query();

        if (\Illuminate\Support\Facades\Auth::check()) {
            // Agar user login hai, toh uske account wale orders uthao
            $query->where('user_id', \Illuminate\Support\Facades\Auth::id());
        } else {
            // Agar bina login ke aaya hai, toh Session wale orders uthao
            $guestOrders = session()->get('guest_orders', []);
            $query->whereIn('id', $guestOrders);
        }

        $orders = $query->with('items.product')->orderBy('created_at', 'desc')->get();
        
        return view('user.orders', compact('orders'));
    }
}
