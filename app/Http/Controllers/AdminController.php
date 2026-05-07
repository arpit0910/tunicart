<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::sum('total_amount'),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    public function categories()
    {
        $categories = Category::latest()->get();
        return view('admin.categories', compact('categories'));
    }

    public function categoryStore(Request $request)
    {
        $request->validate(['name' => 'required']);
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $request->file('image') ? $request->file('image')->store('categories', 'public') : null,
        ]);
        return redirect()->back()->with('success', 'Category created successfully');
    }

    public function products()
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::all();
        return view('admin.products', compact('products', 'categories'));
    }

    public function productStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required'
        ]);

        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'is_featured' => $request->has('is_featured'),
            'image' => $request->file('image') ? $request->file('image')->store('products', 'public') : null,
        ]);
        return redirect()->back()->with('success', 'Product created successfully');
    }

    public function banners()
    {
        $banners = Banner::latest()->get();
        return view('admin.banners', compact('banners'));
    }

    public function bannerStore(Request $request)
    {
        $request->validate(['image' => 'required|image']);
        Banner::create([
            'image' => $request->file('image')->store('banners', 'public'),
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'link' => $request->link,
        ]);
        return redirect()->back()->with('success', 'Banner created successfully');
    }

    public function orders()
    {
        $orders = Order::with(['user', 'items.product'])->latest()->get();
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    public function queries()
    {
        $queries = \App\Models\ContactQuery::latest()->get();
        return view('admin.queries', compact('queries'));
    }

    public function updateQueryStatus($id)
    {
        $query = \App\Models\ContactQuery::findOrFail($id);
        $query->update(['status' => 'replied']);
        return redirect()->back()->with('success', 'Query marked as replied');
    }
}
