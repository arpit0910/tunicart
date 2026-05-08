@extends('layouts.frontend')

@section('title', 'Shop - Tunicart')

@section('content')
<section class="section reveal" style="background: var(--bg-color); min-height: 100vh; padding-top: 50px;">
    <div class="container">
        <div class="section-title">
            <h1 style="font-weight: 900; font-size: 3rem; margin-bottom: 10px;">The <span style="color: var(--secondary-color);">Shop</span></h1>
            <p style="font-size: 1.1rem; color: var(--text-light);">Premium engineered apparel for the digital age</p>
        </div>

        <div style="display: flex; gap: 40px; margin-top: 50px; flex-wrap: wrap;" class="flex-responsive">
            <!-- Filters Sidebar -->
            <div style="flex: 1; min-width: 250px;" class="mobile-100">
                <div class="glass mobile-px-20" style="padding: 35px; border-radius: 24px; position: sticky; top: 100px; border: 1px solid var(--glass-border); box-shadow: var(--shadow);">
                    <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                        <h3 style="margin-bottom: 30px; font-size: 1.4rem; font-weight: 800; display: flex; align-items: center; gap: 12px; color: var(--black);">
                            <i class="fa-solid fa-sliders" style="color: var(--accent-color);"></i> Filters
                        </h3>

                        <div style="margin-bottom: 30px;">
                            <h4 style="margin-bottom: 15px; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-light); font-weight: 800;">Search</h4>
                            <div style="position: relative;">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search masterworks..." style="width: 100%; padding: 14px 15px; padding-right: 45px; border-radius: 12px; border: 1px solid var(--glass-border); outline: none; background: #fff; font-weight: 600; color: var(--black);">
                                <button type="submit" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); border: none; background: none; color: var(--accent-color); cursor: pointer; font-size: 1.1rem;">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 35px;">
                            <h4 style="margin-bottom: 20px; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-light); font-weight: 800;">Collections</h4>
                            <div style="display: flex; flex-direction: column; gap: 15px;">
                                <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; font-weight: 700; color: var(--black);">
                                    <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()" style="accent-color: var(--accent-color); width: 18px; height: 18px;"> All Drops
                                </label>
                                @foreach($categories as $category)
                                    <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; color: var(--text-light); font-weight: 600; transition: var(--transition);">
                                        <input type="radio" name="category" value="{{ $category->id }}" {{ request('category') == $category->id ? 'checked' : '' }} onchange="this.form.submit()" style="accent-color: var(--accent-color); width: 18px; height: 18px;"> {{ $category->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <input type="hidden" name="sort" id="sortInput" value="{{ request('sort') }}">
                        
                        <a href="{{ route('products.index') }}" class="btn" style="width: 100%; padding: 14px; border-radius: 12px; font-size: 0.85rem; border: 1px solid var(--glass-border); text-align: center; color: var(--black); font-weight: 800; background: #fff;">
                            Reset View
                        </a>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div style="flex: 3; min-width: 300px;" class="mobile-100">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; padding: 0 10px;">
                    <span style="color: var(--text-light); font-size: 0.9rem; font-weight: 700;">MANIFESTING <span style="color: var(--accent-color);">{{ $products->total() }}</span> DESIGNS</span>
                    <select onchange="document.getElementById('sortInput').value = this.value; document.getElementById('filterForm').submit();" style="background: #fff; border: 1px solid var(--glass-border); color: var(--black); padding: 10px 20px; border-radius: 12px; font-family: inherit; font-size: 0.9rem; outline: none; cursor: pointer; font-weight: 700; box-shadow: var(--shadow);">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest Drops</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Minimalist</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: Premium</option>
                    </select>
                </div>

                <div class="products-grid" style="gap: 30px;">
                    @forelse($products as $product)
                        <div class="product-card" onclick="window.location.href='{{ route('products.show', $product->slug) }}'" style="cursor: pointer; background: #fff; border-radius: 24px; box-shadow: var(--shadow); transition: var(--transition);">
                            <div class="product-image" style="border-radius: 24px 24px 0 0; overflow: hidden; height: 400px; position: relative;">
                                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1); width: 100%; height: 100%; object-fit: cover;">
                                @if($product->is_featured)
                                    <span class="product-badge" style="background: var(--accent-color); color: var(--primary-color); border: none; font-weight: 900; letter-spacing: 1px; box-shadow: 0 5px 15px var(--accent-glow);">EXCLUSIVE DROP</span>
                                @endif
                                <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(30, 14, 0, 0.4), transparent); opacity: 0; transition: var(--transition);" class="image-overlay"></div>
                                <div style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%) translateY(20px); opacity: 0; transition: var(--transition); z-index: 2; width: 80%;" class="card-action">
                                    <span class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 0.85rem; border-radius: 10px; background: #fff; color: var(--primary-color); font-weight: 900; box-shadow: 0 10px 20px rgba(0,0,0,0.2);">Configure Design</span>
                                </div>
                            </div>
                            <div class="product-info" style="padding: 30px;">
                                <span style="font-size: 0.7rem; color: var(--accent-color); font-weight: 900; text-transform: uppercase; letter-spacing: 2px;">{{ $product->category->name }}</span>
                                <h3 style="margin: 8px 0 20px; font-size: 1.25rem; font-weight: 900; line-height: 1.2;">
                                    <a href="{{ route('products.show', $product->slug) }}" style="color: var(--black);">{{ $product->name }}</a>
                                </h3>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span class="product-price" style="font-size: 1.5rem; font-weight: 900; color: var(--primary-color);">₹{{ $product->price }}</span>
                                    <div style="display: flex; gap: 4px; color: var(--accent-color); font-size: 0.85rem;">
                                        @for($i=0; $i<5; $i++) <i class="fa-solid fa-star"></i> @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="glass" style="grid-column: 1/-1; text-align: center; padding: 100px 40px; border-radius: 40px; border: 2px dashed var(--accent-color); background: var(--bg-alt);">
                            <div style="width: 100px; height: 100px; background: rgba(var(--primary-rgb), 0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px;">
                                <i class="fa-solid fa-magnifying-glass-chart" style="font-size: 2.5rem; color: var(--accent-color); opacity: 0.5;"></i>
                            </div>
                            <h2 style="font-weight: 900; color: var(--black); margin-bottom: 15px;">No Manifestations Found</h2>
                            <p style="color: var(--text-light); font-size: 1.1rem; max-width: 400px; margin: 0 auto 40px;">Your search criteria did not match any current designs. Try expanding your vision.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary" style="padding: 15px 40px; border-radius: 50px;">Reset Vision Matrix</a>
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
