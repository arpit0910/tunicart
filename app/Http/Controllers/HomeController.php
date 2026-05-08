<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->get();
        $featured_products = Product::where('is_featured', true)->with('category')->take(4)->get();
        $categories = Category::withCount('products')->take(4)->get();
        $testimonials = Testimonial::latest()->take(3)->get();
        
        return view('welcome', compact('banners', 'featured_products', 'categories', 'testimonials'));
    }

    public function subscribe(Request $request)
    {
        $request->validate(['email' => 'required|email|unique:subscribers']);
        \App\Models\Subscriber::create(['email' => $request->email]);
        return redirect()->back()->with('success', 'Thank you for subscribing!');
    }
}
