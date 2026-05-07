@extends('layouts.frontend')

@section('title', 'Shop - Tunicart')

@section('content')
<section class="section reveal" style="background: var(--bg-color); min-height: 100vh; padding-top: 50px;">
    <div class="container">
        <div class="section-title">
            <h1 style="font-weight: 900; font-size: 3rem; margin-bottom: 10px;">The <span style="color: var(--secondary-color);">Shop</span></h1>
            <p style="font-size: 1.1rem; color: var(--text-light);">Premium engineered apparel for the digital age</p>
        </div>

        <div style="display: flex; gap: 40px; margin-top: 50px; flex-wrap: wrap;">
            <!-- Filters Sidebar -->
            <div style="flex: 1; min-width: 280px;">
                <div class="glass" style="padding: 35px; border-radius: 24px; position: sticky; top: 120px; border: 1px solid var(--glass-border);">
                    <h3 style="margin-bottom: 30px; font-size: 1.4rem; font-weight: 800; display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-sliders" style="color: var(--primary-color);"></i> Filters
                    </h3>
                    
                    <div style="margin-bottom: 35px;">
                        <h4 style="margin-bottom: 20px; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-light);">Categories</h4>
                        <ul style="display: flex; flex-direction: column; gap: 15px;">
                            <li>
                                <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; font-weight: 600; transition: var(--transition);">
                                    <input type="checkbox" checked style="width: 18px; height: 18px; accent-color: var(--secondary-color);"> All Collections
                                </label>
                            </li>
                            @foreach($categories as $category)
                                <li>
                                    <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; color: var(--text-light); hover: color: var(--white); transition: var(--transition);">
                                        <input type="checkbox" style="width: 18px; height: 18px; accent-color: var(--secondary-color);"> {{ $category->name }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div style="margin-bottom: 35px;">
                        <h4 style="margin-bottom: 20px; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-light);">Price Range</h4>
                        <input type="range" style="width: 100%; accent-color: var(--primary-color); height: 6px; border-radius: 10px;" min="0" max="2000" value="2000">
                        <div style="display: flex; justify-content: space-between; font-size: 0.9rem; font-weight: 700; margin-top: 15px; color: var(--white);">
                            <span>₹0</span>
                            <span>₹2,000</span>
                        </div>
                    </div>
                    
                    <button class="btn btn-primary" style="width: 100%; padding: 15px; border-radius: 12px; font-size: 0.95rem; box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);">
                        Apply Selection
                    </button>
                </div>
            </div>

            <!-- Products Grid -->
            <div style="flex: 3; min-width: 300px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding: 0 5px;">
                    <span style="color: var(--text-light); font-size: 0.95rem; font-weight: 600;">Showing <span style="color: #fff;">{{ $products->count() }}</span> masterworks</span>
                    <select style="background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); color: #fff; padding: 8px 15px; border-radius: 8px; font-family: inherit; font-size: 0.9rem; outline: none;">
                        <option>Newest First</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Most Popular</option>
                    </select>
                </div>

                <div class="products-grid">
                    @forelse($products as $product)
                        <div class="product-card" onclick="window.location.href='{{ route('products.show', $product->slug) }}'" style="cursor: pointer;">
                            <div class="product-image">
                                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="transition: var(--transition);">
                                @if($product->is_featured)
                                    <span class="product-badge" style="background: linear-gradient(135deg, var(--accent-color), #db2777); border: none;">Featured Drop</span>
                                @endif
                                <div style="position: absolute; bottom: 15px; right: 15px; opacity: 0; transform: translateY(10px); transition: var(--transition);" class="card-action">
                                    <span class="btn btn-primary" style="padding: 8px 15px; font-size: 0.75rem; border-radius: 8px;">View Details</span>
                                </div>
                            </div>
                            <div class="product-info" style="padding: 25px;">
                                <span style="font-size: 0.75rem; color: var(--secondary-color); font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px;">{{ $product->category->name }}</span>
                                <h3 style="margin: 10px 0 15px; font-size: 1.2rem; font-weight: 800; line-height: 1.3;">
                                    <a href="{{ route('products.show', $product->slug) }}" style="color: #fff;">{{ $product->name }}</a>
                                </h3>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                                    <span class="product-price" style="font-size: 1.4rem; font-weight: 900;">₹{{ $product->price }}</span>
                                    <div style="display: flex; gap: 5px; color: #fbbf24; font-size: 0.8rem;">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="glass" style="grid-column: 1/-1; text-align: center; padding: 80px 40px; border-radius: 30px; border: 1px dashed var(--glass-border);">
                            <i class="fa-solid fa-magnifying-glass" style="font-size: 3rem; color: var(--text-light); margin-bottom: 20px; opacity: 0.3;"></i>
                            <h3 style="font-weight: 800; margin-bottom: 10px;">No masterworks found.</h3>
                            <p style="color: var(--text-light);">Try adjusting your filters to find your perfect fit.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .product-card:hover .product-image img {
        transform: scale(1.08);
        filter: brightness(0.8);
    }
    .product-card:hover .card-action {
        opacity: 1;
        transform: translateY(0);
    }
</style>

@endsection
