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

        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
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

        try {
            $cart = session()->get('cart');
            $total = 0;
            foreach($cart as $item) { $total += $item['price'] * $item['quantity']; }

            // 1. Order main table mein save karo
            // Note: Agar user login nahi hai toh hum temporary 1 use kar sakte hain ya Auth::id()
            $order = Order::create([
              'user_id' => Auth::id(), // Agar banda login nahi hai toh DB mein chup-chaap 'null' save ho jayega
                'total_price' => $total,
                'status' => 'pending',
                'shipping_address' => $request->address . ", " . $request->city . " (Phone: " . $request->phone . ")",
            ]);

            // 2. Order ke items items wale table mein save karo
            foreach($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
            }

            Log::info("CHECKOUT SUCCESS: Order ID " . $order->id . " successfully place ho gaya!");

            // 3. Cart khali kar do
            session()->forget('cart');

            return view('checkout.success', ['order_id' => $order->id]);

        } catch (\Exception $e) {
            Log::error("CHECKOUT FAIL: " . $e->getMessage());
            return back()->with('error', 'Order place nahi ho saka: ' . $e->getMessage());
        }
    }
}
