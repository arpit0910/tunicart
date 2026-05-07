@extends('layouts.frontend')

@section('title', 'Shop - Tunicart')

@section('content')
<section class="section reveal" style="background: var(--bg-color); min-height: 100vh; padding-top: 50px;">
    <div class="container">
        <div class="section-title">
            <h1>The Shop</h1>
            <p>Premium t-shirts for every style and occasion</p>
        </div>

            <!-- Filters Sidebar -->
            <div style="flex: 1; max-width: 280px;">
                <div class="glass" style="padding: 30px; border-radius: 20px; position: sticky; top: 100px;">
                    <h3 style="margin-bottom: 25px; font-size: 1.2rem; color: #fff;">Categories</h3>
                    <ul style="display: flex; flex-direction: column; gap: 15px;">
                        <li><label style="display: flex; align-items: center; gap: 12px; cursor: pointer; color: var(--text-light);"><input type="checkbox" checked style="accent-color: var(--secondary-color);"> All Products</label></li>
                        @foreach($categories as $category)
                            <li><label style="display: flex; align-items: center; gap: 12px; cursor: pointer; color: var(--text-light);"><input type="checkbox" style="accent-color: var(--secondary-color);"> {{ $category->name }}</label></li>
                        @endforeach
                    </ul>

                    <h3 style="margin: 40px 0 20px; font-size: 1.2rem; color: #fff;">Price Range</h3>
                    <input type="range" style="width: 100%; accent-color: var(--primary-color);" min="0" max="2000">
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--text-light); margin-top: 10px;">
                        <span>₹0</span>
                        <span>₹2000</span>
                    </div>
                    
                    <button class="btn btn-primary" style="width: 100%; margin-top: 30px; padding: 12px;">Apply Filters</button>
                </div>
            </div>

            <!-- Products Grid -->
            <div style="flex: 3;">
                <div class="products-grid">
                    @forelse($products as $product)
                        <div class="product-card" onclick="window.location.href='{{ route('products.show', $product->slug) }}'" style="cursor: pointer;">
                            <div class="product-image">
                                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                @if($product->is_featured)
                                    <span class="product-badge">Best Seller</span>
                                @endif
                            </div>
                            <div class="product-info">
                                <span style="font-size: 0.75rem; color: var(--primary-color); font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">{{ $product->category->name }}</span>
                                <h3 style="margin: 8px 0 15px; font-size: 1.1rem;"><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h3>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span class="product-price">₹{{ $product->price }}</span>
                                    <span class="btn btn-primary" style="padding: 6px 15px; font-size: 0.8rem;">View</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1/-1; text-align: center; padding: 50px;">
                            <h3>No products found.</h3>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
