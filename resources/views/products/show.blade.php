@extends('layouts.frontend')

@section('title', $product->name . ' - Tunicart')

@section('styles')
<style>
    .variant-label {
        padding: 8px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
        display: inline-block;
        user-select: none;
    }
    .variant-option input:checked + .variant-label {
        border-color: var(--primary-color);
        background: var(--primary-color);
        color: white;
        box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.2);
    }
    .variant-label:hover {
        border-color: var(--primary-color);
    }
</style>
@endsection

@section('content')
<section class="section">
    <div class="container">
        <div style="display: flex; gap: 50px; flex-wrap: wrap;" class="flex-responsive">
            <!-- Product Image -->
            <div style="flex: 1; min-width: 300px;" class="mobile-100">
                <div class="product-image" style="height: 500px; border-radius: 20px; overflow: hidden;" class="mobile-height-auto">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" id="mainImage">
                </div>
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <img src="{{ asset('storage/' . $product->image) }}" style="width: 80px; height: 80px; border-radius: 10px; cursor: pointer; border: 2px solid var(--primary-color);">
                    <!-- Placeholder for back image if exists -->
                </div>
            </div>

            <!-- Product Details & Customization -->
            <div style="flex: 1; min-width: 300px;" class="mobile-100">
                <span style="color: var(--primary-color); font-weight: 700;">{{ $product->category->name }}</span>
                <h1 style="font-size: 2.5rem; margin-bottom: 10px;">{{ $product->name }}</h1>
                <div class="product-price" style="font-size: 2rem; margin-bottom: 20px;">₹{{ $product->price }}</div>
                <p style="color: var(--text-light); margin-bottom: 30px;">{{ $product->description }}</p>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" enctype="multipart/form-data" class="custom-form" style="background: var(--bg-alt); padding: 35px; border-radius: 24px; border: 1px solid var(--glass-border); box-shadow: var(--shadow);">
                    @csrf
                    <h3 style="margin-bottom: 25px; font-weight: 800; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-wand-magic-sparkles" style="color: var(--accent-color);"></i> Personalize Masterwork
                    </h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;" class="mobile-grid-1">
                        <div>
                            <label style="display: block; margin-bottom: 12px; font-weight: 700; font-size: 0.9rem; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px;">Front Design</label>
                            <div class="upload-box" onclick="document.getElementById('front_image').click()" style="border: 2px dashed var(--accent-color); background: rgba(var(--primary-rgb), 0.02); padding: 30px; border-radius: 15px; text-align: center; transition: var(--transition);">
                                <i class="fa-solid fa-cloud-arrow-up" style="font-size: 1.8rem; color: var(--primary-color);"></i>
                                <p style="font-size: 0.8rem; margin-top: 10px; font-weight: 700;">Upload Front</p>
                                <input type="file" name="front_image" id="front_image" style="display: none;" onchange="previewFile(this, 'front-preview')">
                            </div>
                            <div id="front-preview" style="margin-top: 15px; display: none; position: relative;">
                                <img src="" style="width: 100%; border-radius: 12px; border: 2px solid var(--accent-color);">
                            </div>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 12px; font-weight: 700; font-size: 0.9rem; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px;">Back Design</label>
                            <div class="upload-box" onclick="document.getElementById('back_image').click()" style="border: 2px dashed var(--accent-color); background: rgba(var(--primary-rgb), 0.02); padding: 30px; border-radius: 15px; text-align: center; transition: var(--transition);">
                                <i class="fa-solid fa-cloud-arrow-up" style="font-size: 1.8rem; color: var(--primary-color);"></i>
                                <p style="font-size: 0.8rem; margin-top: 10px; font-weight: 700;">Upload Back</p>
                                <input type="file" name="back_image" id="back_image" style="display: none;" onchange="previewFile(this, 'back-preview')">
                            </div>
                            <div id="back-preview" style="margin-top: 15px; display: none; position: relative;">
                                <img src="" style="width: 100%; border-radius: 12px; border: 2px solid var(--accent-color);">
                            </div>
                        </div>
                    </div>

                    @if($variants->count() > 0)
                        <div style="margin-bottom: 35px;">
                            @foreach($variants as $attributeName => $values)
                                <div style="margin-bottom: 25px;">
                                    <label style="display: block; margin-bottom: 12px; font-weight: 700; font-size: 0.9rem; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px;">Select {{ $attributeName }}</label>
                                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                                        @foreach($values as $val)
                                            <div class="variant-option">
                                                <input type="radio" name="variants[{{ $attributeName }}]" value="{{ $val->value }}" id="variant_{{ $val->id }}" style="display: none;" {{ $loop->first ? 'checked' : '' }}>
                                                <label for="variant_{{ $val->id }}" class="variant-label" style="padding: 12px 20px; border: 2px solid var(--glass-border); border-radius: 12px; cursor: pointer; font-weight: 700; transition: var(--transition); background: #fff;">
                                                    {{ $val->value }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div style="margin-bottom: 30px;">
                        <label style="display: block; margin-bottom: 12px; font-weight: 700; font-size: 0.9rem; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px;">Instructions</label>
                        <textarea name="notes" placeholder="e.g., 'Place logo on chest', 'Add name on back'" style="width: 100%; padding: 15px; border-radius: 12px; border: 1px solid var(--glass-border); height: 100px; font-family: inherit; background: #fff;"></textarea>
                    </div>

                    <div style="display: flex; gap: 20px; align-items: center;">
                        <div style="display: flex; align-items: center; border: 1px solid var(--glass-border); border-radius: 12px; padding: 10px 20px; background: #fff;">
                            <span style="margin-right: 15px; font-weight: 800; font-size: 0.9rem; color: var(--text-light);">QTY</span>
                            <input type="number" name="quantity" value="1" min="1" style="width: 40px; border: none; font-size: 1.1rem; font-weight: 900; text-align: center; background: transparent !important; color: var(--black) !important;">
                        </div>
                        <button type="submit" class="btn btn-primary" style="flex: 1; padding: 18px; border-radius: 12px; font-size: 1rem; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); box-shadow: 0 10px 25px var(--accent-glow);">
                            Assemble Order <i class="fa-solid fa-cart-plus" style="margin-left: 10px;"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Reviews Section -->
        <div style="margin-top: 80px;">
            <h2 style="margin-bottom: 40px; font-size: 2rem;">Customer Reviews ({{ $product->reviews->count() }})</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 50px;" class="flex-responsive">
                <!-- Review List -->
                <div style="max-height: 600px; overflow-y: auto; padding-right: 20px;">
                    @forelse($product->reviews as $review)
                        <div style="background: var(--bg-alt); padding: 25px; border-radius: 15px; margin-bottom: 20px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <div style="font-weight: 700;">{{ $review->user->name }}</div>
                                <div style="color: var(--secondary-color);">
                                    @for($i=0; $i<$review->rating; $i++) <i class="fa-solid fa-star"></i> @endfor
                                </div>
                            </div>
                            <p style="color: var(--text-light); font-size: 0.95rem;">{{ $review->comment }}</p>
                            <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 15px;">{{ $review->created_at->format('M d, Y') }}</div>
                        </div>
                    @empty
                        <p style="color: var(--text-light); padding: 60px; background: var(--bg-alt); border-radius: 15px; text-align: center;">No reviews yet. Be the first to review this product!</p>
                    @endforelse
                </div>

                <!-- Review Form -->
                <div>
                    @auth
                        <div style="background: #fff; padding: 40px; border-radius: 20px; box-shadow: var(--shadow); position: sticky; top: 100px;">
                            <h3 style="margin-bottom: 25px;">Share Your Experience</h3>
                            <form action="{{ route('reviews.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label style="display: block; margin-bottom: 10px; font-weight: 600;">Rating</label>
                                    <div style="display: flex; gap: 10px; font-size: 1.5rem; color: #cbd5e1; cursor: pointer;" id="starRating">
                                        @for($i=1; $i<=5; $i++)
                                            <i class="fa-solid fa-star" data-value="{{ $i }}" onclick="setRating({{ $i }})"></i>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="ratingInput" value="5">
                                </div>
                                <div class="form-group" style="margin-bottom: 25px;">
                                    <label style="display: block; margin-bottom: 10px; font-weight: 600;">Your Comment</label>
                                    <textarea name="comment" rows="4" style="width: 100%; padding: 15px; border-radius: 10px; border: 1px solid #ddd; font-family: inherit;" placeholder="How's the fabric and fit?"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px;">Submit Review</button>
                            </form>
                        </div>
                    @else
                        <div style="background: var(--bg-alt); padding: 40px; border-radius: 20px; text-align: center; border: 2px dashed #cbd5e1;">
                            <p style="margin-bottom: 20px; color: var(--text-light);">Bought this product? Share your feedback!</p>
                            <a href="{{ route('login') }}" class="btn btn-primary">Login to Review</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div style="margin-top: 80px;">
            <h2 style="margin-bottom: 40px; font-size: 2rem; text-align: center;">Frequently Asked Questions</h2>
            <div style="max-width: 800px; margin: 0 auto;">
                <div class="faq-item">
                    <div class="faq-header" onclick="toggleFaq(this)">
                        <span>What is the quality of the fabric?</span>
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div class="faq-content">
                        <p style="padding: 20px;">We use premium 100% combed cotton, bio-washed for a soft feel and long-lasting durability. Our fabric is 180 GSM, making it perfect for the Indian climate.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-header" onclick="toggleFaq(this)">
                        <span>How long does delivery take?</span>
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div class="faq-content">
                        <p style="padding: 20px;">For most cities in India, we deliver within 5-7 working days. Custom printed orders may take an additional 2 days for processing.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-header" onclick="toggleFaq(this)">
                        <span>Can I return a customized t-shirt?</span>
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div class="faq-content">
                        <p style="padding: 20px;">Customized products are made specifically for you and cannot be returned unless they are defective or damaged upon arrival.</p>
                    </div>
                </div>
        </div>

        @if($related_products->count() > 0)
        <!-- Related Products -->
        <div style="margin-top: 100px;">
            <h2 style="margin-bottom: 40px; font-size: 2rem; text-align: center;">You May Also <span style="color: var(--secondary-color);">Like</span></h2>
            <div class="products-grid">
                @foreach($related_products as $rel)
                    <div class="product-card" onclick="window.location.href='{{ route('products.show', $rel->slug) }}'" style="cursor: pointer;">
                        <div class="product-image">
                            <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->name }}">
                        </div>
                        <div class="product-info">
                            <span style="font-size: 0.7rem; color: var(--secondary-color); font-weight: 800; text-transform: uppercase;">{{ $rel->category->name }}</span>
                            <h3 style="margin: 5px 0 10px; font-size: 1.1rem;">{{ $rel->name }}</h3>
                            <div class="product-price">₹{{ $rel->price }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

@section('scripts')
<script>
    function toggleFaq(header) {
        const content = header.nextElementSibling;
        const icon = header.querySelector('i');
        
        if (content.style.maxHeight) {
            content.style.maxHeight = null;
            icon.classList.replace('fa-minus', 'fa-plus');
        } else {
            content.style.maxHeight = content.scrollHeight + "px";
            icon.classList.replace('fa-plus', 'fa-minus');
        }
    }
    function previewFile(input, previewId) {
        const preview = document.getElementById(previewId);
        const img = preview.querySelector('img');
        const file = input.files[0];
        const reader = new FileReader();

        reader.onloadend = function () {
            img.src = reader.result;
            preview.style.display = 'block';
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            img.src = "";
            preview.style.display = 'none';
        }
    }

    function setRating(rating) {
        const stars = document.querySelectorAll('#starRating i');
        const input = document.getElementById('ratingInput');
        input.value = rating;
        
        stars.forEach((star, index) => {
            if (index < rating) {
                star.style.color = 'var(--secondary-color)';
            } else {
                star.style.color = '#cbd5e1';
            }
        });
    }

    // Initialize with 5 stars
    window.onload = () => setRating(5);
</script>
@endsection
@endsection
