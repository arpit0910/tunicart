<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tunicart - Custom T-Shirts')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @yield('styles')
</head>

<body>
    <header style="background: var(--glass); border-bottom: 1px solid var(--glass-border); padding: 10px 0;">
        <div class="container">
            <nav style="display: flex; justify-content: space-between; align-items: center; min-height: 50px;">
                <div class="logo">
                    <a href="{{ url('/') }}" style="display: flex; align-items: center;">
                        <img src="{{ asset('images/logo.png') }}" alt="Tunicart Logo"
                            style="height: 60px; width: auto; filter: drop-shadow(0 0 10px var(--accent-glow));">
                    </a>
                </div>
                <div class="nav-links" style="display: flex; gap: 30px; align-items: center; height: 100%;">
                    <a href="{{ url('/') }}"
                        style="font-weight: 700; color: var(--black); text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; line-height: 1; {{ Request::is('/') ? 'color: var(--accent-color);' : '' }}">Home</a>
                    <a href="{{ route('products.index') }}"
                        style="font-weight: 700; color: var(--black); text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; line-height: 1; {{ Request::is('products*') ? 'color: var(--accent-color);' : '' }}">Shop</a>
                    <a href="{{ url('/about') }}"
                        style="font-weight: 700; color: var(--black); text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; line-height: 1;">About</a>
                    <a href="{{ url('/contact') }}"
                        style="font-weight: 700; color: var(--black); text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; line-height: 1;">Contact</a>
                </div>
                <div class="nav-icons"
                    style="display: flex; gap: 20px; align-items: center; font-size: 1.2rem; color: var(--black); height: 100%;">
                    <a href="{{ route('products.index') }}"
                        style="transition: var(--transition); display: flex; align-items: center;"><i
                            class="fa-solid fa-magnifying-glass"></i></a>
                    <a href="{{ route('wishlist.index') }}"
                        style="transition: var(--transition); position: relative; display: flex; align-items: center;"
                        class="mobile-hide">
                        <i class="fa-solid fa-heart"></i>
                    </a>
                    <a href="{{ route('cart.index') }}"
                        style="transition: var(--transition); position: relative; display: flex; align-items: center;"
                        class="mobile-hide">
                        <i class="fa-solid fa-cart-shopping"></i>
                        @if (count(session('cart', [])) > 0)
                            <span
                                style="position: absolute; -top: 8px; -right: 8px; background: var(--accent-color); color: var(--primary-color); font-size: 0.6rem; width: 15px; height: 15px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900;">{{ count(session('cart', [])) }}</span>
                        @endif
                    </a>
                    @auth
                        @if (Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}"
                                style="transition: var(--transition); color: var(--accent-color); font-size: 0.85rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Dashboard</a>
                        @else
                            <a href="{{ route('dashboard') }}"
                                style="transition: var(--transition); color: var(--accent-color); display: flex; align-items: center;"><i
                                    class="fa-solid fa-circle-user"></i></a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary mobile-hide"
                            style="padding: 10px 25px; font-size: 0.8rem; border-radius: 50px; line-height: 1; min-height: 40px;">Login</a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    @if (session('success'))
        <div
            style="background: var(--accent-color); color: var(--primary-color); padding: 12px; text-align: center; font-weight: 900; position: fixed; top: 0; width: 100%; z-index: 9999; box-shadow: 0 5px 20px var(--accent-glow); text-transform: uppercase; letter-spacing: 1px; font-size: 0.85rem;">
            <i class="fa-solid fa-circle-check" style="margin-right: 10px;"></i> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div
            style="background: #dc2626; color: white; padding: 12px; text-align: center; font-weight: 900; position: fixed; top: 0; width: 100%; z-index: 9999; text-transform: uppercase; letter-spacing: 1px; font-size: 0.85rem;">
            <i class="fa-solid fa-triangle-exclamation" style="margin-right: 10px;"></i> {{ session('error') }}
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <!-- Mobile Navigation -->
    <div class="mobile-nav">
        <a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('products.index') }}" class="{{ Request::is('products*') ? 'active' : '' }}">
            <i class="fa-solid fa-shirt"></i>
            <span>Shop</span>
        </a>
        <a href="{{ route('wishlist.index') }}" class="{{ Request::is('wishlist*') ? 'active' : '' }}">
            <i class="fa-solid fa-heart"></i>
            <span>Wishlist</span>
        </a>
        <a href="{{ route('dashboard') }}">
            <i class="fa-solid fa-user"></i>
            <span>Account</span>
        </a>
    </div>

    <!-- Floating Cart for Mobile -->
    <a href="{{ route('cart.index') }}" class="fab-cart">
        <i class="fa-solid fa-cart-shopping"></i>
    </a>

    <footer style="background: var(--bg-alt); padding-top: 80px; border-top: 1px solid var(--glass-border);">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4 style="color: var(--black); margin-bottom: 25px;">TUNICART.</h4>
                    <p style="color: var(--text-light); margin-bottom: 20px;">The future of custom apparel. Premium
                        t-shirts tailored to your vision with state-of-the-art print tech.</p>
                    <div class="social-links" style="display: flex; gap: 15px;">
                        <a href="#" style="color: var(--text-light);"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" style="color: var(--text-light);"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" style="color: var(--text-light);"><i class="fa-brands fa-twitter"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4 style="color: var(--black); margin-bottom: 25px;">Explore</h4>
                    <ul>
                        <li style="margin-bottom: 12px;"><a href="{{ route('products.index') }}"
                                style="color: var(--text-light);">Round Neck</a></li>
                        <li style="margin-bottom: 12px;"><a href="{{ route('products.index') }}"
                                style="color: var(--text-light);">Polo T-Shirts</a></li>
                        <li style="margin-bottom: 12px;"><a href="{{ route('products.index') }}"
                                style="color: var(--text-light);">Oversized Tees</a></li>
                        <li style="margin-bottom: 12px;"><a href="{{ route('products.index') }}"
                                style="color: var(--text-light);">Custom Print</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 style="color: var(--black); margin-bottom: 25px;">Support</h4>
                    <ul>
                        <li><a href="{{ url('/about') }}" style="color: var(--text-light);">About Us</a></li>
                        <li><a href="{{ url('/contact') }}" style="color: var(--text-light);">Contact Us</a></li>
                        <li><a href="{{ url('/faq') }}" style="color: var(--text-light);">FAQ Center</a></li>
                        <li><a href="{{ url('/track-order') }}" style="color: var(--text-light);">Track Order</a>
                        </li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 style="color: var(--black); margin-bottom: 25px;">Join the Drop</h4>
                    <p style="color: var(--text-light); margin-bottom: 20px;">Subscribe for exclusive high-tech drops.
                    </p>
                    <form action="{{ route('subscribe') }}" method="POST"
                        style="display: flex; gap: 10px; flex-wrap: wrap;">
                        @csrf
                        <div style="flex: 1; min-width: 250px;" class="mobile-100">
                            <input type="email" name="email" placeholder="Your Email" required
                                style="padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: rgba(255,255,255,0.05); color: var(--black); width: 100%;">
                        </div>
                        <button type="submit" class="btn btn-primary" style="padding: 12px 20px;">Join</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom"
                style="margin-top: 60px; padding: 30px 0; border-top: 1px solid var(--glass-border); text-align: center; color: var(--text-light); font-size: 0.9rem;">
                <p>&copy; 2026 Tunicart. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @yield('scripts')
</body>

</html>
