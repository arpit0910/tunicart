@extends('layouts.frontend')

@section('title', 'Tunicart - Custom T-Shirts & Premium Apparel')

@section('content')
    <!-- Hero Slider / Banner Section -->
    <section class="hero-section reveal">
        @forelse($banners as $banner)
            <div class="hero bg-pattern"
                style="background-image: url('{{ asset('storage/' . $banner->image) }}'); background-size: cover; background-position: center;">
                <div class="container">
                    <div class="hero-content">
                        <span
                            style="color: var(--primary-color); font-weight: 700; text-transform: uppercase; letter-spacing: 2px;">{{ $banner->sub_title }}</span>
                        <h1>{{ $banner->title }}</h1>
                        <div style="display: flex; gap: 20px;">
                            <a href="{{ $banner->link ?? route('products.index') }}" class="btn btn-primary">Explore Now</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <section class="hero" style="min-height: 80vh; display: flex; align-items: center; position: relative;">
                <div class="container">
                    <div style="display: flex; align-items: center; gap: 50px; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 300px; z-index: 2;">
                            <span style="display: inline-block; padding: 6px 15px; background: rgba(99, 102, 241, 0.1); border: 1px solid var(--primary-color); color: var(--primary-color); border-radius: 50px; font-weight: 700; font-size: 0.8rem; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 2px;">
                                The Future of Custom Apparel
                            </span>
                            <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); line-height: 1.1; margin-bottom: 25px; font-weight: 900; color: #fff;">
                                Print Your <span style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 0 0 20px rgba(99, 102, 241, 0.3);">Imagination</span> in High-Def
                            </h1>
                            <p style="font-size: 1.1rem; color: var(--text-light); margin-bottom: 40px; max-width: 500px;">
                                Experience the next level of customization. Tunicart combines premium fabric technology with advanced digital printing to bring your vision to life.
                            </p>
                            <div style="display: flex; gap: 20px;">
                                <a href="{{ route('products.index') }}" class="btn btn-primary" style="padding: 15px 35px;">Launch Creator</a>
                                <a href="#" class="btn glass" style="padding: 15px 35px; border: 1px solid var(--glass-border); color: #fff;">View Drops</a>
                            </div>
                        </div>
                        <div style="flex: 1; min-width: 300px; position: relative;">
                            <div style="position: absolute; inset: 0; background: radial-gradient(circle, var(--primary-color) 0%, transparent 70%); filter: blur(60px); opacity: 0.2; transform: scale(1.2);"></div>
                            <img src="{{ asset('images/hero-hitech.png') }}" alt="High-Tech Customization" style="width: 100%; filter: drop-shadow(0 0 30px rgba(99, 102, 241, 0.3)); animation: float 6s ease-in-out infinite;">
                        </div>
                    </div>
                </div>
            </section>
            
            <style>
                @keyframes float {
                    0%, 100% { transform: translateY(0); }
                    50% { transform: translateY(-20px); }
                }
            </style>
        @endforelse
    </section>

    <!-- Why Choose Tunicart? (Features) -->
    <section class="section reveal" style="background: var(--bg-alt); position: relative;">
        <div class="container">
            <div class="section-title">
                <h2>The Tunicart Edge</h2>
                <p>Engineered for comfort, designed for the future</p>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                <!-- Feature 1 -->
                <div class="glass" style="padding: 40px; border-radius: 30px; position: relative; overflow: hidden; transition: var(--transition); border: 1px solid rgba(99, 102, 241, 0.2);">
                    <span style="position: absolute; top: 10px; right: 20px; font-size: 4rem; font-weight: 900; color: rgba(255,255,255,0.03); z-index: 0;">01</span>
                    <div style="width: 60px; height: 60px; background: rgba(99, 102, 241, 0.15); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin-bottom: 25px; color: var(--primary-color); font-size: 1.8rem; box-shadow: 0 0 20px rgba(99, 102, 241, 0.2);">
                        <i class="fa-solid fa-microchip"></i>
                    </div>
                    <h3 style="font-size: 1.4rem; margin-bottom: 15px; font-weight: 800; color: #fff;">HD Print Matrix</h3>
                    <p style="font-size: 1rem; color: var(--text-light); line-height: 1.6; position: relative; z-index: 1;">Industrial-grade molecular bonding ensures your designs never fade, peel, or crack, wash after wash.</p>
                </div>
                <!-- Feature 2 -->
                <div class="glass" style="padding: 40px; border-radius: 30px; position: relative; overflow: hidden; transition: var(--transition); border: 1px solid rgba(6, 182, 212, 0.2);">
                    <span style="position: absolute; top: 10px; right: 20px; font-size: 4rem; font-weight: 900; color: rgba(255,255,255,0.03); z-index: 0;">02</span>
                    <div style="width: 60px; height: 60px; background: rgba(6, 182, 212, 0.15); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin-bottom: 25px; color: var(--secondary-color); font-size: 1.8rem; box-shadow: 0 0 20px rgba(6, 182, 212, 0.2);">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <h3 style="font-size: 1.4rem; margin-bottom: 15px; font-weight: 800; color: #fff;">Premium Cotton</h3>
                    <p style="font-size: 1rem; color: var(--text-light); line-height: 1.6; position: relative; z-index: 1;">100% sustainable, pre-shrunk cotton that's bio-washed for an ultra-soft, luxury skin-feel.</p>
                </div>
                <!-- Feature 3 -->
                <div class="glass" style="padding: 40px; border-radius: 30px; position: relative; overflow: hidden; transition: var(--transition); border: 1px solid rgba(244, 114, 182, 0.2);">
                    <span style="position: absolute; top: 10px; right: 20px; font-size: 4rem; font-weight: 900; color: rgba(255,255,255,0.03); z-index: 0;">03</span>
                    <div style="width: 60px; height: 60px; background: rgba(244, 114, 182, 0.15); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin-bottom: 25px; color: var(--accent-color); font-size: 1.8rem; box-shadow: 0 0 20px rgba(244, 114, 182, 0.2);">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <h3 style="font-size: 1.4rem; margin-bottom: 15px; font-weight: 800; color: #fff;">Priority Dispatch</h3>
                    <p style="font-size: 1rem; color: var(--text-light); line-height: 1.6; position: relative; z-index: 1;">Lightning-fast 48-hour order processing with real-time end-to-end tracking across India.</p>
                </div>
                <!-- Feature 4 -->
                <div class="glass" style="padding: 40px; border-radius: 30px; position: relative; overflow: hidden; transition: var(--transition); border: 1px solid rgba(16, 185, 129, 0.2);">
                    <span style="position: absolute; top: 10px; right: 20px; font-size: 4rem; font-weight: 900; color: rgba(255,255,255,0.03); z-index: 0;">04</span>
                    <div style="width: 60px; height: 60px; background: rgba(16, 185, 129, 0.15); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin-bottom: 25px; color: #10b981; font-size: 1.8rem; box-shadow: 0 0 20px rgba(16, 185, 129, 0.2);">
                        <i class="fa-solid fa-clipboard-check"></i>
                    </div>
                    <h3 style="font-size: 1.4rem; margin-bottom: 15px; font-weight: 800; color: #fff;">12-Point QC</h3>
                    <p style="font-size: 1rem; color: var(--text-light); line-height: 1.6; position: relative; z-index: 1;">Every single garment undergoes a rigorous 12-point quality check before it leaves our facility.</p>
                </div>
                <!-- Feature 5 -->
                <div class="glass" style="padding: 40px; border-radius: 30px; position: relative; overflow: hidden; transition: var(--transition); border: 1px solid rgba(245, 158, 11, 0.2);">
                    <span style="position: absolute; top: 10px; right: 20px; font-size: 4rem; font-weight: 900; color: rgba(255,255,255,0.03); z-index: 0;">05</span>
                    <div style="width: 60px; height: 60px; background: rgba(245, 158, 11, 0.15); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin-bottom: 25px; color: #f59e0b; font-size: 1.8rem; box-shadow: 0 0 20px rgba(245, 158, 11, 0.2);">
                        <i class="fa-solid fa-rotate"></i>
                    </div>
                    <h3 style="font-size: 1.4rem; margin-bottom: 15px; font-weight: 800; color: #fff;">Easy Exchanges</h3>
                    <p style="font-size: 1rem; color: var(--text-light); line-height: 1.6; position: relative; z-index: 1;">Not the perfect fit? We offer 7-day exchanges on catalog items. <span style="color: var(--accent-color); font-size: 0.85rem; display: block; margin-top: 5px;">*Excludes customized products.</span></p>
                </div>
                <!-- Feature 6 -->
                <div class="glass" style="padding: 40px; border-radius: 30px; position: relative; overflow: hidden; transition: var(--transition); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <span style="position: absolute; top: 10px; right: 20px; font-size: 4rem; font-weight: 900; color: rgba(255,255,255,0.03); z-index: 0;">06</span>
                    <div style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.05); border-radius: 18px; display: flex; align-items: center; justify-content: center; margin-bottom: 25px; color: #fff; font-size: 1.8rem; box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <h3 style="font-size: 1.4rem; margin-bottom: 15px; font-weight: 800; color: #fff;">Secure Node Pay</h3>
                    <p style="font-size: 1rem; color: var(--text-light); line-height: 1.6; position: relative; z-index: 1;">256-bit encrypted UPI & Card payments for a safe and seamless checkout experience.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="section bg-pattern reveal">
        <div class="container">
            <div class="section-title">
                <h2>Our Collections</h2>
                <p>Designed for every mood and every occasion</p>
            </div>
            <div class="categories-grid">
                @foreach ($categories as $cat)
                    <div class="category-card" onclick="window.location.href='{{ route('collection.show', $cat->slug) }}'" style="cursor: pointer;">
                        <img src="{{ Str::startsWith($cat->image, 'http') ? $cat->image : asset('storage/' . $cat->image) }}"
                            alt="{{ $cat->name }}">
                        <div class="category-overlay">
                            <h3>{{ $cat->name }}</h3>
                            <p>{{ $cat->products_count }} Products</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="section reveal" style="background: var(--bg-alt);">
        <div class="container">
            <div class="section-title">
                <h2>Best Sellers</h2>
                <p>Trending styles that India loves</p>
            </div>
            <div class="products-grid">
                @foreach ($featured_products as $product)
                    <div class="product-card" onclick="window.location.href='{{ route('products.show', $product->slug) }}'" style="cursor: pointer;">
                        <div class="product-image">
                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            <span class="product-badge">Top Choice</span>
                        </div>
                        <div class="product-info">
                            <h4 style="color: var(--primary-color); font-size: 0.8rem; text-transform: uppercase;">
                                {{ $product->category->name }}</h4>
                            <h3 style="margin: 5px 0 15px;"><a
                                    href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h3>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span class="product-price">₹{{ $product->price }}</span>
                                <span class="btn btn-primary" style="padding: 5px 15px; font-size: 0.8rem;">Shop Now</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Special Promo Section (Hi-Tech Redesign) -->
    <section class="section reveal" style="padding: 100px 0; background: var(--bg-color); position: relative; overflow: hidden;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 100%; height: 100%; background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 70%);"></div>
        <div class="container">
            <div class="glass" style="padding: 80px 40px; border-radius: 40px; border: 2px solid var(--primary-color); position: relative; text-align: center; box-shadow: 0 0 50px rgba(99, 102, 241, 0.2);">
                <div style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); background: var(--primary-color); color: #fff; padding: 5px 25px; border-radius: 50px; font-weight: 900; letter-spacing: 2px; text-transform: uppercase; font-size: 0.8rem;">
                    Limited Time Phase
                </div>
                <h2 style="font-size: clamp(2rem, 5vw, 4rem); margin-bottom: 20px; line-height: 1; color: #fff;">ACTIVATE <span style="color: var(--secondary-color);">20% OFF</span></h2>
                <p style="font-size: 1.2rem; color: var(--text-light); margin-bottom: 40px;">Upgrade your wardrobe with our inaugural collection discount.</p>
                
                <div style="display: inline-flex; align-items: center; gap: 20px; background: rgba(0,0,0,0.3); padding: 15px 30px; border-radius: 15px; border: 1px dashed var(--secondary-color); margin-bottom: 40px;">
                    <span style="color: var(--text-light); font-size: 0.9rem; font-weight: 600;">ACCESS CODE:</span>
                    <span style="font-size: 1.8rem; font-weight: 900; color: var(--secondary-color); letter-spacing: 4px;">TUNICART20</span>
                </div>
                
                <div>
                    <a href="{{ route('products.index') }}" class="btn btn-primary" style="padding: 20px 60px; font-size: 1.1rem; border-radius: 50px;">Redeem Now <i class="fa-solid fa-arrow-right" style="margin-left: 10px;"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Trendy Bento Grid: Shop by Style -->
    <section class="section reveal">
        <div class="container">
            <div class="section-title">
                <h2>Explore the Look</h2>
                <p>Curated styles for every version of you</p>
            </div>
            <div class="bento-grid">
                <div class="bento-item large" onclick="window.location.href='{{ route('products.index') }}'">
                    <img src="https://images.unsplash.com/photo-1554568218-0f1715e72254?auto=format&fit=crop&w=800&q=80" alt="Street Edit">
                    <div class="bento-overlay">
                        <h3>The Street Edit</h3>
                        <p>Oversized & Bold</p>
                    </div>
                </div>
                <div class="bento-item wide" onclick="window.location.href='{{ route('products.index') }}'">
                    <img src="https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?auto=format&fit=crop&w=800&q=80" alt="Corporate Polos">
                    <div class="bento-overlay center">
                        <h3>Corporate Polos</h3>
                    </div>
                </div>
                <div class="bento-item small" onclick="window.location.href='{{ route('products.index') }}'">
                    <img src="https://images.unsplash.com/photo-1576566588028-4147f3842f27?auto=format&fit=crop&w=400&q=80" alt="Graphic Tees">
                    <div class="bento-overlay center">
                        <h4>Graphic Tees</h4>
                    </div>
                </div>
                <div class="bento-item accent" onclick="window.location.href='{{ route('products.index') }}'">
                    <i class="fa-solid fa-plus"></i>
                    <h4>Your Design Here</h4>
                </div>
            </div>
        </div>
    </section>

    <style>
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(2, 250px);
            gap: 20px;
        }
        .bento-item {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            cursor: pointer;
            transition: var(--transition);
        }
        .bento-item:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .bento-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .bento-item.large { grid-column: span 2; grid-row: span 2; }
        .bento-item.wide { grid-column: span 2; }
        .bento-item.accent {
            background: var(--secondary-color);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--black);
            padding: 20px;
            text-align: center;
        }
        .bento-item.accent i { font-size: 2.5rem; margin-bottom: 15px; }
        .bento-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 30px;
            color: #fff;
        }
        .bento-overlay.center {
            justify-content: center;
            align-items: center;
            background: rgba(0,0,0,0.4);
        }
        @media (max-width: 992px) {
            .bento-grid {
                grid-template-columns: repeat(2, 1fr);
                grid-template-rows: auto;
            }
            .bento-item.large { grid-column: span 2; height: 400px; }
            .bento-item.wide { grid-column: span 2; height: 250px; }
            .bento-item { height: 250px; }
        }
        @media (max-width: 576px) {
            .bento-grid { grid-template-columns: 1fr; }
            .bento-item.large, .bento-item.wide { grid-column: span 1; }
        }
    </style>

    <!-- Testimonials -->
    <section class="section testimonials">
        <div class="container">
            <div class="section-title">
                <h2 style="color: var(--white);">Hear from our Fam</h2>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                @forelse($testimonials as $t)
                    <div class="testimonial-card">
                        <div style="display: flex; gap: 5px; color: var(--secondary-color); margin-bottom: 15px;">
                            @for ($i = 0; $i < $t->rating; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </div>
                        <p>"{{ $t->content }}"</p>
                        <div style="margin-top: 20px; font-weight: 700;">- {{ $t->user_name }}</div>
                    </div>
                @empty
                    <p style="text-align: center; width: 100%;">Be the first to leave a testimonial!</p>
                @endforelse
            </div>
        </div>
    </section>
    
    <!-- Enterprise/Bulk Orders Section -->
    <section class="section" style="background: var(--bg-alt); position: relative;">
        <div class="container">
            <div style="display: flex; align-items: center; gap: 60px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 300px;">
                    <h2 style="font-size: 2.5rem; margin-bottom: 20px;">Corporate & Bulk Orders</h2>
                    <p style="font-size: 1.1rem; color: var(--text-light); margin-bottom: 30px;">Planning an event or need branded apparel for your team? Tunicart offers premium bulk printing services with massive discounts and dedicated support.</p>
                    <ul style="margin-bottom: 30px; list-style: none; padding: 0;">
                        <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 15px;">
                            <i class="fa-solid fa-check-circle" style="color: var(--primary-color); font-size: 1.2rem;"></i> 
                            <span>Flat Discounts for 20+ units</span>
                        </li>
                        <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 15px;">
                            <i class="fa-solid fa-check-circle" style="color: var(--primary-color); font-size: 1.2rem;"></i> 
                            <span>Free Design Consultation</span>
                        </li>
                        <li style="margin-bottom: 15px; display: flex; align-items: center; gap: 15px;">
                            <i class="fa-solid fa-check-circle" style="color: var(--primary-color); font-size: 1.2rem;"></i> 
                            <span>Express Pan-India Delivery</span>
                        </li>
                    </ul>
                </div>
                <div class="glass" style="flex: 1; min-width: 350px; padding: 40px; border-radius: 20px;">
                    <h3 style="margin-bottom: 25px; color: #fff;">Get a Bulk Quote</h3>
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="subject" value="Enterprise Order Query">
                        <div style="margin-bottom: 15px;">
                            <input type="text" name="name" placeholder="Contact Person Name" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: rgba(255,255,255,0.05); color: #fff;" required>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <input type="email" name="email" placeholder="Business Email" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: rgba(255,255,255,0.05); color: #fff;" required>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <input type="text" name="phone" placeholder="Phone Number" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: rgba(255,255,255,0.05); color: #fff;" required>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <textarea name="message" placeholder="Tell us about your bulk requirement (Qty, Style, etc.)..." style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: rgba(255,255,255,0.05); color: #fff; height: 100px; font-family: inherit;" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px;">Submit Request</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick FAQs on Homepage -->
    <section class="section">
        <div class="container">
            <div class="section-title">
                <h2>Got Questions?</h2>
                <p>Quick answers to our most common queries</p>
            </div>
            <div style="max-width: 800px; margin: 0 auto;">
                <div class="faq-item">
                    <div class="faq-header" onclick="toggleFaq(this)">
                        <span>How long does the print last?</span>
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div class="faq-content">
                        <p style="padding: 20px;">Our prints are high-quality DTG/Screen prints designed to last for 50+ washes without cracking or fading, provided you follow the wash-care instructions.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-header" onclick="toggleFaq(this)">
                        <span>Do you offer cash on delivery?</span>
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div class="faq-content">
                        <p style="padding: 20px;">Yes, we offer Cash on Delivery across most pin codes in India. However, for custom printed orders, we may require a partial advance for security.</p>
                    </div>
                </div>
                <div style="text-align: center; margin-top: 30px;">
                    <a href="{{ route('faq') }}" style="color: var(--primary-color); font-weight: 700; display: inline-flex; align-items: center; gap: 10px;">
                        View All FAQs <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

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
    </script>

    <!-- Newsletter -->
    <section class="section" style="background: var(--bg-color);">
        <div class="container"
            style="max-width: 800px; text-align: center; background: var(--bg-alt); padding: 60px; border-radius: 30px; border: 1px solid var(--glass-border);">
            <h2 style="margin-bottom: 15px;">Join the Tunicart Club</h2>
            <p style="color: var(--text-light); margin-bottom: 30px;">Get exclusive deals, early access to new drops, and more.</p>
            <form style="display: flex; gap: 10px; max-width: 500px; margin: 0 auto; flex-wrap: wrap;">
                <input type="email" placeholder="Enter your email"
                    style="flex: 1; padding: 15px; border-radius: 10px; border: 1px solid var(--glass-border); background: rgba(255,255,255,0.05); color: #fff; min-width: 250px;">
                <button type="submit" class="btn btn-primary" style="padding: 15px 30px;">Subscribe</button>
            </form>
        </div>
    </section>
@endsection
