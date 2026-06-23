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
use App\Models\PaymentSetting;
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
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'total_customers' => \App\Models\User::where('is_admin', false)->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_reviews' => \App\Models\Review::count(),
            'pending_queries' => \App\Models\ContactQuery::where('status', 'pending')->count(),
        ];

        $recent_orders = Order::with('user')->latest()->take(5)->get();
        $latest_reviews = \App\Models\Review::with(['user', 'product'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'latest_reviews'));
    }

    public function categories()
    {
        $categories = Category::latest()->get();
        return view('admin.categories', compact('categories'));
    }

    public function categoryCreate()
    {
        return view('admin.categories_create');
    }

    public function categoryEdit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories_edit', compact('category'));
    }

    public function categoryStore(Request $request)
    {
        $request->validate(['name' => 'required']);
        Category::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'image' => $request->file('image') ? $request->file('image')->store('categories', 'public') : null,
        ]);
        return redirect()->route('admin.categories')->with('success', 'Category created successfully');
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
        return redirect()->route('admin.categories')->with('success', 'Category updated successfully');
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

    public function productCreate()
    {
        $categories = Category::all();
        $attributes = Attribute::with('values')->get();
        return view('admin.products_create', compact('categories', 'attributes'));
    }

    public function productEdit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $attributes = Attribute::with('values')->get();
        return view('admin.products_edit', compact('product', 'categories', 'attributes'));
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

        return redirect()->route('admin.products')->with('success', 'Product created successfully');
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

        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
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

    public function bannerCreate()
    {
        return view('admin.banners_create');
    }

    public function bannerEdit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners_edit', compact('banner'));
    }

    public function bannerStore(Request $request)
    {
        $request->validate(['image' => 'required|image']);
        Banner::create([
            'image' => $request->file('image')->store('banners', 'public'),
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'description' => $request->description,
            'button_text' => $request->button_text ?? 'Shop Now',
            'text_color' => $request->text_color ?? '#1E0E00',
            'display_on' => $request->display_on ?? 'both',
            'link' => $request->link,
            'vertical_position' => $request->vertical_position ?? 'center',
            'horizontal_position' => $request->horizontal_position ?? 'flex-start',
            'text_align' => $request->text_align ?? 'left',
        ]);
        return redirect()->route('admin.banners')->with('success', 'Banner created successfully');
    }

    public function bannerUpdate(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $data = [
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'text_color' => $request->text_color,
            'display_on' => $request->display_on,
            'link' => $request->link,
            'vertical_position' => $request->vertical_position ?? 'center',
            'horizontal_position' => $request->horizontal_position ?? 'flex-start',
            'text_align' => $request->text_align ?? 'left',
        ];
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('banners', 'public');
        }
        $banner->update($data);
        return redirect()->route('admin.banners')->with('success', 'Banner updated successfully');
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

    public function testimonialCreate()
    {
        return view('admin.testimonials_create');
    }

    public function testimonialEdit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonials_edit', compact('testimonial'));
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
        return redirect()->route('admin.testimonials')->with('success', 'Testimonial added successfully');
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
        return redirect()->route('admin.testimonials')->with('success', 'Testimonial updated successfully');
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

    public function faqCreate()
    {
        return view('admin.faqs_create');
    }

    public function faqEdit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.faqs_edit', compact('faq'));
    }

    public function faqStore(Request $request)
    {
        $request->validate(['question' => 'required', 'answer' => 'required']);
        Faq::create($request->all());
        return redirect()->route('admin.faqs')->with('success', 'FAQ added successfully');
    }

    public function faqUpdate(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->update($request->all());
        return redirect()->route('admin.faqs')->with('success', 'FAQ updated successfully');
    }

    public function faqDelete($id)
    {
        Faq::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'FAQ deleted successfully');
    }

    public function coupons()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons', compact('coupons'));
    }

    public function couponCreate()
    {
        return view('admin.coupons_create');
    }

    public function couponEdit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons_edit', compact('coupon'));
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
        return redirect()->route('admin.coupons')->with('success', 'Coupon created successfully');
    }

    public function couponUpdate(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update($request->all());
        return redirect()->route('admin.coupons')->with('success', 'Coupon updated successfully');
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

    public function attributeCreate()
    {
        return view('admin.attributes_create');
    }

    public function attributeValueCreate($attribute_id)
    {
        $attribute = Attribute::findOrFail($attribute_id);
        return view('admin.attribute_values_create', compact('attribute'));
    }

    public function attributeStore(Request $request)
    {
        $request->validate(['name' => 'required']);
        Attribute::create(['name' => $request->name]);
        return redirect()->route('admin.attributes')->with('success', 'Attribute created successfully');
    }

    public function attributeValueStore(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required'
        ]);
        AttributeValue::create($request->all());
        return redirect()->route('admin.attributes')->with('success', 'Attribute value added successfully');
    }

    // Customers
    public function customers()
    {
        $customers = \App\Models\User::where('is_admin', false)->latest()->get();
        return view('admin.customers', compact('customers'));
    }

    public function customerDelete($id)
    {
        $user = \App\Models\User::findOrFail($id);
        if ($user->orders()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete customer with existing orders.');
        }
        $user->delete();
        return redirect()->back()->with('success', 'Customer deleted successfully');
    }

    // Reviews
    public function reviews()
    {
        $reviews = \App\Models\Review::with(['user', 'product'])->latest()->get();
        return view('admin.reviews', compact('reviews'));
    }

    public function reviewDelete($id)
    {
        \App\Models\Review::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Review deleted successfully');
    }

    // Subscribers
    public function subscriberDelete($id)
    {
        \App\Models\Subscriber::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Subscriber removed successfully');
    }

    public function queryDelete($id)
    {
        \App\Models\ContactQuery::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Query deleted successfully');
    }

    public function paymentSettings()
    {
        $settings = PaymentSetting::firstOrCreate([
            'id' => 1
        ], [
            'upi_id' => 'tunicart@upi',
            'bank_name' => 'State Bank of India',
            'account_holder' => 'Tunicart Apparel India',
            'account_number' => '1234567890',
            'ifsc_code' => 'SBIN0001234'
        ]);

        return view('admin.payment_settings', compact('settings'));
    }

    public function paymentSettingsUpdate(Request $request)
    {
        $request->validate([
            'upi_id' => 'nullable|string',
            'upi_qr_code' => 'nullable|image|max:2048',
            'bank_name' => 'nullable|string',
            'account_holder' => 'nullable|string',
            'account_number' => 'nullable|string',
            'ifsc_code' => 'nullable|string',
        ]);

        $settings = PaymentSetting::firstOrCreate(['id' => 1]);

        $data = [
            'upi_id' => $request->upi_id,
            'bank_name' => $request->bank_name,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'ifsc_code' => $request->ifsc_code,
        ];

        if ($request->hasFile('upi_qr_code')) {
            $data['upi_qr_code'] = $request->file('upi_qr_code')->store('payments', 'public');
        }

        $settings->update($data);

        return redirect()->route('admin.payment-settings')->with('success', 'Payment settings updated successfully');
    }
}
