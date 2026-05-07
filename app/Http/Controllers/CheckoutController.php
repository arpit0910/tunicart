<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('cart.index')->with('error', 'Cart is empty');
        
        $total = 0;
        foreach($cart as $item) $total += $item['price'] * $item['quantity'];
        
        return view('checkout.index', compact('cart', 'total'));
    }

    public function payment(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'shipping_address' => 'required',
            'city' => 'required',
            'pincode' => 'required',
        ]);

        // Store address in session to use after payment simulation
        session(['checkout_details' => $request->all()]);
        
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) $total += $item['price'] * $item['quantity'];

        return view('checkout.payment', compact('total'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate(['transaction_id' => 'required']);
        
        $details = session('checkout_details');
        $cart = session('cart');
        
        if (!$details || !$cart) return redirect()->route('cart.index');

        $total = 0;
        foreach($cart as $item) $total += $item['price'] * $item['quantity'];

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $details['shipping_address'],
            'phone' => $details['phone'],
            'city' => $details['city'],
            'pincode' => $details['pincode'],
            'payment_method' => 'UPI',
            'payment_status' => 'paid',
            'transaction_id' => $request->transaction_id,
        ]);

        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'customization_details' => json_encode([
                    'front' => $item['front_image'] ?? null,
                    'back' => $item['back_image'] ?? null,
                    'notes' => $item['notes'] ?? null
                ])
            ]);
        }

        // Clear cart and details
        session()->forget(['cart', 'checkout_details']);

        return view('checkout.success', compact('order'));
    }
}
