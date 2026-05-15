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
        $front_mockup = null;
        $back_mockup = null;

        if ($request->hasFile('front_image')) {
            $front_image = $request->file('front_image')->store('customizations', 'public');
        }
        if ($request->hasFile('back_image')) {
            $back_image = $request->file('back_image')->store('customizations', 'public');
        }
        if ($request->hasFile('front_mockup')) {
            $front_mockup = $request->file('front_mockup')->store('mockups', 'public');
        }
        if ($request->hasFile('back_mockup')) {
            $back_mockup = $request->file('back_mockup')->store('mockups', 'public');
        }

        // Handle Base64 Mockups from Frontend
        if ($request->filled('front_mockup_data')) {
            $data = $request->front_mockup_data;
            if (str_contains($data, 'base64,')) {
                $image_parts = explode(";base64,", $data);
                $image_base64 = base64_decode($image_parts[1]);
                $filename = 'mockup_front_' . uniqid() . '.jpg';
                \Storage::disk('public')->put('mockups/' . $filename, $image_base64);
                $front_mockup = 'mockups/' . $filename;
            }
        }

        if ($request->filled('back_mockup_data')) {
            $data = $request->back_mockup_data;
            if (str_contains($data, 'base64,')) {
                $image_parts = explode(";base64,", $data);
                $image_base64 = base64_decode($image_parts[1]);
                $filename = 'mockup_back_' . uniqid() . '.jpg';
                \Storage::disk('public')->put('mockups/' . $filename, $image_base64);
                $back_mockup = 'mockups/' . $filename;
            }
        }

        $cart[$id . '_' . uniqid()] = [
            "name" => $product->name,
            "quantity" => $request->quantity,
            "price" => $product->price,
            "image" => $product->image,
            "front_image" => $front_image,
            "back_image" => $back_image,
            "front_mockup" => $front_mockup,
            "back_mockup" => $back_mockup,
            "front_placement" => $request->front_placement,
            "back_placement" => $request->back_placement,
            "front_pos_top" => $request->front_pos_top,
            "front_pos_left" => $request->front_pos_left,
            "back_pos_top" => $request->back_pos_top,
            "back_pos_left" => $request->back_pos_left,
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
