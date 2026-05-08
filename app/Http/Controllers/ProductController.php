<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('sort')) {
            if ($request->sort == 'price_low') $query->orderBy('price', 'asc');
            elseif ($request->sort == 'price_high') $query->orderBy('price', 'desc');
            else $query->latest();
        } else {
            $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Category::all();
        return view('products.index', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with(['category', 'reviews.user', 'attributeValues.attribute'])->firstOrFail();
        
        $variants = $product->attributeValues->groupBy(function($val) {
            return $val->attribute->name;
        });

        $related_products = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $product->id)
                                  ->take(4)
                                  ->get();

        return view('products.show', compact('product', 'variants', 'related_products'));
    }
}
