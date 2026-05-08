<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('cart.index')->with('error', 'Cart is empty');
        
        $total = 0;
        foreach($cart as $item) $total += $item['price'] * $item['quantity'];

        $discount = 0;
        $coupon = session('applied_coupon');
        if ($coupon) {
            if ($coupon->type == 'percent') $discount = ($total * $coupon->value) / 100;
            else $discount = $coupon->value;
        }
        $grand_total = $total - $discount;
        
        return view('checkout.index', compact('cart', 'total', 'discount', 'grand_total'));
    }

    public function applyCoupon(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)->where('status', true)->first();
        
        if (!$coupon) return redirect()->back()->with('error', 'Invalid or inactive coupon');
        if ($coupon->expiry_date && $coupon->expiry_date < now()->toDateString()) return redirect()->back()->with('error', 'Coupon expired');
        
        $total = 0;
        foreach(session('cart', []) as $item) $total += $item['price'] * $item['quantity'];
        
        if ($total < $coupon->min_amount) return redirect()->back()->with('error', 'Minimum order amount for this coupon is ₹'.$coupon->min_amount);
        
        session(['applied_coupon' => $coupon]);
        return redirect()->back()->with('success', 'Coupon applied successfully!');
    }

    public function removeCoupon()
    {
        session()->forget('applied_coupon');
        return redirect()->back()->with('success', 'Coupon removed');
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

        $discount = 0;
        $coupon = session('applied_coupon');
        if ($coupon) {
            if ($coupon->type == 'percent') $discount = ($total * $coupon->value) / 100;
            else $discount = $coupon->value;
        }
        $grand_total = $total - $discount;

        return view('checkout.payment', compact('grand_total'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate(['transaction_id' => 'required']);
        
        $details = session('checkout_details');
        $cart = session('cart');
        
        if (!$details || !$cart) return redirect()->route('cart.index');

        $total = 0;
        foreach($cart as $item) $total += $item['price'] * $item['quantity'];

        $discount = 0;
        $coupon = session('applied_coupon');
        if ($coupon) {
            if ($coupon->type == 'percent') $discount = ($total * $coupon->value) / 100;
            else $discount = $coupon->value;
        }
        $grand_total = $total - $discount;

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $grand_total,
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
            $product = Product::find($item['product_id']);
            if($product) {
                $product->decrement('stock', $item['quantity']);
            }
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'variant_details' => isset($item['variants']) ? json_encode($item['variants']) : null,
                'front_image' => $item['front_image'] ?? null,
                'back_image' => $item['back_image'] ?? null,
                'customization_notes' => $item['notes'] ?? null
            ]);
        }

        // Clear cart and details
        session()->forget(['cart', 'checkout_details']);

        return view('checkout.success', compact('order'));
    }
}
