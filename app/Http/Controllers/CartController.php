<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        $front_image = null;
        $back_image = null;

        if ($request->hasFile('front_image')) {
            $front_image = $request->file('front_image')->store('customizations', 'public');
        }
        if ($request->hasFile('back_image')) {
            $back_image = $request->file('back_image')->store('customizations', 'public');
        }

        $cart[$id . '_' . uniqid()] = [
            "name" => $product->name,
            "quantity" => $request->quantity,
            "price" => $product->price,
            "image" => $product->image,
            "front_image" => $front_image,
            "back_image" => $back_image,
            "notes" => $request->notes,
            "variants" => $request->variants,
            "product_id" => $id
        ];

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Product removed successfully');
    }
}
