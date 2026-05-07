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
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Tunicart Logo"
                            style="height: 70px; width: auto;">
                    </a>
                </div>
                <div class="nav-links">
                    <a href="{{ url('/') }}">Home</a>
                    <a href="{{ route('products.index') }}">Shop</a>
                    <a href="{{ url('/about') }}">About Us</a>
                    <a href="{{ url('/contact') }}">Contact</a>
                </div>
                <div class="nav-icons">
                    <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
                    <a href="{{ route('cart.index') }}"><i class="fa-solid fa-cart-shopping"></i></a>
                    @auth
                        <a href="{{ route('dashboard') }}"><i class="fa-solid fa-user"></i></a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

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
        <a href="{{ route('cart.index') }}">
            <i class="fa-solid fa-cart-shopping"></i>
            <span>Cart</span>
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
                    <h4 style="color: #fff; margin-bottom: 25px;">TUNICART.</h4>
                    <p style="color: var(--text-light); margin-bottom: 20px;">The future of custom apparel. Premium
                        t-shirts tailored to your vision with state-of-the-art print tech.</p>
                    <div class="social-links" style="display: flex; gap: 15px;">
                        <a href="#" style="color: var(--text-light);"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" style="color: var(--text-light);"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" style="color: var(--text-light);"><i class="fa-brands fa-twitter"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4 style="color: #fff; margin-bottom: 25px;">Explore</h4>
                    <ul>
                        <li style="margin-bottom: 12px;"><a href="#" style="color: var(--text-light);">Polo
                                T-Shirts</a></li>
                        <li style="margin-bottom: 12px;"><a href="#" style="color: var(--text-light);">Round
                                Neck</a></li>
                        <li style="margin-bottom: 12px;"><a href="#" style="color: var(--text-light);">Oversized
                                Tees</a></li>
                        <li style="margin-bottom: 12px;"><a href="#" style="color: var(--text-light);">Custom
                                Print</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 style="color: #fff; margin-bottom: 25px;">Support</h4>
                    <ul>
                        <li><a href="{{ url('/about') }}" style="color: var(--text-light);">About Us</a></li>
                        <li><a href="{{ url('/contact') }}" style="color: var(--text-light);">Contact Us</a></li>
                        <li><a href="{{ url('/faq') }}" style="color: var(--text-light);">FAQ Center</a></li>
                        <li><a href="{{ url('/track-order') }}" style="color: var(--text-light);">Track Order</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 style="color: #fff; margin-bottom: 25px;">Join the Drop</h4>
                    <p style="color: var(--text-light); margin-bottom: 20px;">Subscribe for exclusive high-tech drops.
                    </p>
                    <div style="display: flex; gap: 10px;">
                        <input type="email" placeholder="Your Email"
                            style="padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: rgba(255,255,255,0.05); color: #fff; flex: 1;">
                        <button class="btn btn-primary" style="padding: 12px 20px;">Join</button>
                    </div>
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
