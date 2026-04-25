<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // 1. Checkout Form Dikhana
    public function index() {
        Log::info("CHECKOUT LOG: User checkout page par aaya.");
        
        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->route('shop.home')->with('error', 'Aapka cart khali hai!');
        }

        // NAYA LOGIC: Yahan discount check ho raha hai total ke liye
        $total = 0;
        foreach($cart as $item) {
            $activePrice = (isset($item['discount_price']) && $item['discount_price'] > 0) ? $item['discount_price'] : $item['price'];
            $total += $activePrice * $item['quantity'];
        }

        return view('checkout.index', compact('cart', 'total'));
    }

    // 2. Order Place Karna (Database mein save karna)
    public function placeOrder(Request $request) {
        Log::info("CHECKOUT LOG: Order process ho raha hai. Data:", $request->all());

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
        ]);

        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->route('shop.home')->with('error', 'Aapka cart khali hai!');
        }

        try {
            // NAYA LOGIC: Database mein save karne se pehle bhi discount check karo
            $total = 0;
            foreach($cart as $item) { 
                $activePrice = (isset($item['discount_price']) && $item['discount_price'] > 0) ? $item['discount_price'] : $item['price'];
                $total += $activePrice * $item['quantity']; 
            }

            // 1. Order main table mein save karo
            $order = Order::create([
                'user_id' => Auth::id(), 
                'total_price' => $total, // Ab yahan sahi discount wala total jayega
                'status' => 'pending',
                'shipping_address' => $request->address . ", " . $request->city . " (Phone: " . $request->phone . ")",
            ]);

            // Guest user ke liye order ki ID session mein mehfooz kar lein
            $guestOrders = session()->get('guest_orders', []);
            $guestOrders[] = $order->id;
            session()->put('guest_orders', $guestOrders);
            
            // 2. Order ke items table mein save karo
            foreach($cart as $id => $details) {
                // Item ki price bhi discount wali save karni hai
                $itemActivePrice = (isset($details['discount_price']) && $details['discount_price'] > 0) ? $details['discount_price'] : $details['price'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $itemActivePrice, // Sahi price save hogi
                ]);
            }

            Log::info("CHECKOUT SUCCESS: Order ID " . $order->id . " successfully place ho gaya!");

            // 3. Cart khali kar do
            session()->forget('cart');

            // 4. Redirect to Orders
            return redirect()->route('user.orders')->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            Log::error("CHECKOUT FAIL: " . $e->getMessage());
            session()->put('cart', $cart); 
            return redirect()->route('checkout.index')->with('error', 'Database Error: ' . $e->getMessage());
        }
    }
}
