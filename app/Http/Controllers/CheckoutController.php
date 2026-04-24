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

        // NAYA: Pehle check karo ke cart hai bhi ya nahi
        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->route('shop.home')->with('error', 'Aapka cart khali hai!');
        }

        try {
            $total = 0;
            foreach($cart as $item) { 
                $total += $item['price'] * $item['quantity']; 
            }

            // 1. Order main table mein save karo
            $order = Order::create([
                'user_id' => Auth::id(), // Agar login nahi hai toh null jayega
                'total_price' => $total,
                'status' => 'pending',
                'shipping_address' => $request->address . ", " . $request->city . " (Phone: " . $request->phone . ")",
            ]);

            // 2. Order ke items table mein save karo
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

            // 4. Redirect to Orders
            return redirect()->route('user.orders')->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            // NAYA: Agar error aaye toh redirect back hone par cart check se masla na ho
            Log::error("CHECKOUT FAIL: " . $e->getMessage());
            
            // Cart wapis session mein daal do taake page khali na ho
            session()->put('cart', $cart); 
            
            return redirect()->route('checkout.index')->with('error', 'Database Error: ' . $e->getMessage());
        }
    }
}
