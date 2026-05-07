<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;

class PageController extends Controller
{
    public function about() { return view('pages.about'); }
    public function contact() { return view('pages.contact'); }
    public function privacy() { return view('pages.privacy'); }
    public function terms() { return view('pages.terms'); }
    
    public function collection($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)->latest()->paginate(12);
        return view('pages.collection', compact('category', 'products'));
    }

    public function trackOrder(Request $request) 
    { 
        $order = null;
        if($request->has('order_id')) {
            $order = \App\Models\Order::with('items.product')->find($request->order_id);
        }
        return view('pages.track-order', compact('order')); 
    }

    public function faq() { return view('pages.faq'); }
}
