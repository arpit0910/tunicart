<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Order;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Coupon;
use App\Models\Subscriber;
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
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'image' => $request->file('image') ? $request->file('image')->store('categories', 'public') : null,
        ]);
        return redirect()->back()->with('success', 'Category created successfully');
    }

    public function categoryUpdate(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        $category = Category::findOrFail($id);
        $data = [
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
        ];
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }
        $category->update($data);
        return redirect()->back()->with('success', 'Category updated successfully');
    }

    public function categoryDelete($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }

    public function products()
    {
        $products = Product::with('category', 'attributeValues.attribute')->latest()->get();
        $categories = Category::all();
        $attributes = Attribute::with('values')->get();
        return view('admin.products', compact('products', 'categories', 'attributes'));
    }

    public function productStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required'
        ]);

        $product = Product::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'is_featured' => $request->has('is_featured'),
            'image' => $request->file('image') ? $request->file('image')->store('products', 'public') : null,
            'back_image' => $request->file('back_image') ? $request->file('back_image')->store('products', 'public') : null,
        ]);

        if ($request->has('attribute_values')) {
            $syncData = [];
            foreach ($request->attribute_values as $valId) {
                $syncData[$valId] = [];
                if ($request->hasFile("variant_image_$valId")) {
                    $syncData[$valId]['image'] = $request->file("variant_image_$valId")->store('variants', 'public');
                }
                if ($request->hasFile("variant_back_image_$valId")) {
                    $syncData[$valId]['back_image'] = $request->file("variant_back_image_$valId")->store('variants', 'public');
                }
            }
            $product->attributeValues()->sync($syncData);
        }

        return redirect()->back()->with('success', 'Product created successfully');
    }

    public function productUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required'
        ]);

        $product = Product::findOrFail($id);
        
        $data = [
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'is_featured' => $request->has('is_featured'),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        if ($request->hasFile('back_image')) {
            $data['back_image'] = $request->file('back_image')->store('products', 'public');
        }

        $product->update($data);

        if ($request->has('attribute_values')) {
            $syncData = [];
            foreach ($request->attribute_values as $valId) {
                $syncData[$valId] = [];
                
                // Keep existing images if no new one uploaded
                $existing = $product->attributeValues()->where('attribute_value_id', $valId)->first();
                if ($existing && $existing->pivot->image) $syncData[$valId]['image'] = $existing->pivot->image;
                if ($existing && $existing->pivot->back_image) $syncData[$valId]['back_image'] = $existing->pivot->back_image;

                if ($request->hasFile("variant_image_$valId")) {
                    $syncData[$valId]['image'] = $request->file("variant_image_$valId")->store('variants', 'public');
                }
                if ($request->hasFile("variant_back_image_$valId")) {
                    $syncData[$valId]['back_image'] = $request->file("variant_back_image_$valId")->store('variants', 'public');
                }
            }
            $product->attributeValues()->sync($syncData);
        } else {
            $product->attributeValues()->detach();
        }

        return redirect()->back()->with('success', 'Product updated successfully');
    }

    public function productDelete($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Product deleted successfully');
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

    public function bannerUpdate(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $data = [
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'link' => $request->link,
        ];
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('banners', 'public');
        }
        $banner->update($data);
        return redirect()->back()->with('success', 'Banner updated successfully');
    }

    public function bannerDelete($id)
    {
        Banner::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Banner deleted successfully');
    }

    public function testimonials()
    {
        $testimonials = Testimonial::latest()->get();
        return view('admin.testimonials', compact('testimonials'));
    }

    public function testimonialStore(Request $request)
    {
        $request->validate(['user_name' => 'required', 'content' => 'required']);
        Testimonial::create([
            'user_name' => $request->user_name,
            'content' => $request->content,
            'rating' => $request->rating ?? 5,
            'image' => $request->file('image') ? $request->file('image')->store('testimonials', 'public') : null,
        ]);
        return redirect()->back()->with('success', 'Testimonial added successfully');
    }

    public function testimonialUpdate(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $data = [
            'user_name' => $request->user_name,
            'content' => $request->content,
            'rating' => $request->rating ?? 5,
        ];
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('testimonials', 'public');
        }
        $testimonial->update($data);
        return redirect()->back()->with('success', 'Testimonial updated successfully');
    }

    public function testimonialDelete($id)
    {
        Testimonial::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Testimonial deleted successfully');
    }

    public function faqs()
    {
        $faqs = Faq::latest()->get();
        return view('admin.faqs', compact('faqs'));
    }

    public function couponStore(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric',
            'min_amount' => 'nullable|numeric',
            'expiry_date' => 'nullable|date'
        ]);
        Coupon::create($request->all());
        return redirect()->back()->with('success', 'Coupon created successfully');
    }

    public function coupons()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons', compact('coupons'));
    }

    public function couponUpdate(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update($request->all());
        return redirect()->back()->with('success', 'Coupon updated successfully');
    }

    public function couponDelete($id)
    {
        Coupon::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Coupon deleted successfully');
    }

    public function subscribers()
    {
        $subscribers = Subscriber::latest()->get();
        return view('admin.subscribers', compact('subscribers'));
    }

    public function faqStore(Request $request)
    {
        $request->validate(['question' => 'required', 'answer' => 'required']);
        Faq::create($request->all());
        return redirect()->back()->with('success', 'FAQ added successfully');
    }

    public function faqUpdate(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->update($request->all());
        return redirect()->back()->with('success', 'FAQ updated successfully');
    }

    public function faqDelete($id)
    {
        Faq::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'FAQ deleted successfully');
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

    public function attributes()
    {
        $attributes = Attribute::with('values')->get();
        return view('admin.attributes', compact('attributes'));
    }

    public function attributeStore(Request $request)
    {
        $request->validate(['name' => 'required']);
        Attribute::create(['name' => $request->name]);
        return redirect()->back()->with('success', 'Attribute created successfully');
    }

    public function attributeValueStore(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required'
        ]);
        AttributeValue::create($request->all());
        return redirect()->back()->with('success', 'Attribute value added successfully');
    }
}
