@extends('layouts.frontend')

@section('title', $category->name . ' Collection - Tunicart')

@section('content')
<section class="section reveal" style="background: var(--bg-color); min-height: 100vh; position: relative; overflow: hidden; padding-top: 80px;">
    <!-- Decorative background -->
    <div style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 100%; height: 100%; background: radial-gradient(circle at 50% -20%, rgba(99, 102, 241, 0.15) 0%, transparent 50%); z-index: 0;"></div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <div style="margin-bottom: 60px; text-align: center;">
            <nav style="display: flex; justify-content: center; gap: 10px; margin-bottom: 20px; font-size: 0.85rem; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px;">
                <a href="{{ url('/') }}" style="color: var(--text-light);">Home</a>
                <span>/</span>
                <a href="{{ route('products.index') }}" style="color: var(--text-light);">Shop</a>
                <span>/</span>
                <span style="color: var(--secondary-color); font-weight: 800;">{{ $category->name }}</span>
            </nav>
            <h1 style="font-size: clamp(2.5rem, 8vw, 4.5rem); line-height: 1; margin-bottom: 20px; font-weight: 900; background: linear-gradient(to bottom, #fff, var(--text-light)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ $category->name }}</h1>
            <p style="color: var(--text-light); max-width: 600px; margin: 0 auto; font-size: 1.1rem;">Discover our high-tech, premium {{ strtolower($category->name) }} collection, engineered for style and ultimate comfort.</p>
        </div>

        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card" onclick="window.location.href='{{ route('products.show', $product->slug) }}'" style="cursor: pointer;">
                        <div class="product-image">
                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @if($product->is_featured)
                                <span class="product-badge">Top Pick</span>
                            @endif
                        </div>
                        <div class="product-info">
                            <span style="font-size: 0.75rem; color: var(--primary-color); font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px;">{{ $category->name }}</span>
                            <h3 style="margin: 8px 0 15px; font-size: 1.1rem; line-height: 1.4;"><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h3>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span class="product-price" style="font-size: 1.2rem;">₹{{ $product->price }}</span>
                                <span class="btn btn-primary" style="padding: 6px 18px; font-size: 0.8rem; border-radius: 50px;">Shop Now</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="margin-top: 60px;">
                {{ $products->links() }}
            </div>
        @else
            <div class="glass" style="text-align: center; padding: 100px 40px; border-radius: 40px; border: 1px dashed var(--glass-border);">
                <i class="fa-solid fa-microchip" style="font-size: 4rem; color: var(--primary-color); opacity: 0.2; margin-bottom: 30px;"></i>
                <h2 style="margin-bottom: 15px;">Collection Empty</h2>
                <p style="color: var(--text-light); margin-bottom: 30px;">This category is currently being restocked with our latest drops.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary" style="padding: 15px 40px;">Explore Other Styles</a>
            </div>
        @endif
    </div>
</section>
@endsection
