@extends('layouts.frontend')

@section('title', 'My Wishlist - Tunicart')

@section('content')
<section class="section" style="background: var(--bg-color); min-height: 80vh; padding-top: 50px;">
    <div class="container">
        <div class="section-title">
            <h1 style="font-weight: 900; font-size: 3rem;">My <span style="color: var(--secondary-color);">Wishlist</span></h1>
            <p>Your curated collection of engineered apparel</p>
        </div>

        <div class="products-grid" style="margin-top: 50px;">
            @forelse($wishlist as $item)
                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                        <form action="{{ route('wishlist.toggle', $item->product->id) }}" method="POST" style="position: absolute; top: 15px; right: 15px;">
                            @csrf
                            <button type="submit" class="glass" style="width: 40px; height: 40px; border-radius: 50%; border: none; color: var(--primary-color); cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-heart"></i>
                            </button>
                        </form>
                    </div>
                    <div class="product-info" style="padding: 25px;">
                        <h3 style="margin: 0 0 15px; font-size: 1.2rem; font-weight: 800;">
                            <a href="{{ route('products.show', $item->product->slug) }}" style="color: var(--black);">{{ $item->product->name }}</a>
                        </h3>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span class="product-price" style="font-size: 1.4rem; font-weight: 900;">₹{{ $item->product->price }}</span>
                            <a href="{{ route('products.show', $item->product->slug) }}" class="btn btn-primary" style="padding: 8px 15px; font-size: 0.8rem; border-radius: 8px;">View</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="glass" style="grid-column: 1/-1; text-align: center; padding: 100px 40px; border-radius: 30px; border: 1px dashed var(--glass-border);">
                    <i class="fa-regular fa-heart" style="font-size: 4rem; color: var(--text-light); margin-bottom: 20px; opacity: 0.2;"></i>
                    <h2 style="font-weight: 800; margin-bottom: 15px;">Your wishlist is empty</h2>
                    <p style="color: var(--text-light); margin-bottom: 30px;">Save your favorite masterworks here to review them later.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Start Shopping</a>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
