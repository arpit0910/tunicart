<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tunicart</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f8f9fa; display: flex; min-height: 100vh; font-family: 'Outfit', sans-serif; color: var(--black); }
        .sidebar { width: 280px; background: var(--primary-color); color: #fff; padding: 40px 0; display: flex; flex-direction: column; position: sticky; top: 0; height: 100vh; box-shadow: 10px 0 30px rgba(0,0,0,0.1); }
        .sidebar-brand { padding: 0 40px 40px; font-size: 1.8rem; font-weight: 800; border-bottom: 1px solid rgba(255,255,255,0.05); margin-bottom: 30px; letter-spacing: -1px; color: var(--accent-color); }
        .sidebar-menu { list-style: none; flex: 1; overflow-y: auto; padding-bottom: 40px; -ms-overflow-style: none; scrollbar-width: none; }
        .sidebar-menu::-webkit-scrollbar { display: none; }
        .sidebar-menu li a { display: flex; align-items: center; gap: 15px; padding: 16px 40px; color: rgba(255,255,255,0.6); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); font-weight: 600; text-decoration: none; border-left: 4px solid transparent; }
        .sidebar-menu li a:hover { color: #fff; background: rgba(255,255,255,0.03); }
        .sidebar-menu li a.active { background: rgba(212, 175, 55, 0.08); color: var(--accent-color); border-left-color: var(--accent-color); font-weight: 800; }
        .main-content { flex: 1; padding: 50px; overflow-y: auto; background: #fff; }
        .admin-card { background: #fff; padding: 35px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.04); margin-bottom: 30px; border: 1px solid #f1f1f1; }
        h1 { font-weight: 800; font-size: 2.2rem; margin-bottom: 40px; letter-spacing: -0.5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        th { padding: 20px; text-align: left; border-bottom: 2px solid #f1f1f1; color: var(--text-light); font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; }
        td { padding: 20px; text-align: left; border-bottom: 1px solid #f1f1f1; font-size: 0.95rem; }
        .btn-admin { padding: 10px 20px; border-radius: 10px; font-weight: 700; font-size: 0.85rem; transition: 0.3s; cursor: pointer; border: none; }
        .btn-primary { background: var(--primary-color); color: #fff; }
        .btn-accent { background: var(--accent-color); color: var(--primary-color); }
        .form-control { width: 100%; padding: 14px; border-radius: 12px; border: 1px solid #e1e1e1; font-family: inherit; font-weight: 600; outline: none; transition: 0.3s; }
        .form-control:focus { border-color: var(--accent-color); box-shadow: 0 0 0 4px var(--accent-glow); }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">Tunicart Admin</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}" class="{{ Route::is('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.categories') }}" class="{{ Route::is('admin.categories') ? 'active' : '' }}"><i class="fa-solid fa-list"></i> Categories</a></li>
            <li><a href="{{ route('admin.products') }}" class="{{ Route::is('admin.products') ? 'active' : '' }}"><i class="fa-solid fa-shirt"></i> Products</a></li>
            <li><a href="{{ route('admin.attributes') }}" class="{{ Route::is('admin.attributes') ? 'active' : '' }}"><i class="fa-solid fa-tags"></i> Product Attributes</a></li>
            <li><a href="{{ route('admin.banners') }}" class="{{ Route::is('admin.banners') ? 'active' : '' }}"><i class="fa-solid fa-image"></i> Banners</a></li>
            <li><a href="{{ route('admin.orders') }}" class="{{ Route::is('admin.orders') ? 'active' : '' }}"><i class="fa-solid fa-truck"></i> Manage Orders</a></li>
            <li><a href="{{ route('admin.customers') }}" class="{{ Route::is('admin.customers') ? 'active' : '' }}"><i class="fa-solid fa-user-group"></i> Customers</a></li>
            <li><a href="{{ route('admin.reviews') }}" class="{{ Route::is('admin.reviews') ? 'active' : '' }}"><i class="fa-solid fa-star-half-stroke"></i> Reviews</a></li>
            <li><a href="{{ route('admin.coupons') }}" class="{{ Route::is('admin.coupons') ? 'active' : '' }}"><i class="fa-solid fa-ticket"></i> Coupons</a></li>
            <li><a href="{{ route('admin.faqs') }}" class="{{ Route::is('admin.faqs') ? 'active' : '' }}"><i class="fa-solid fa-circle-question"></i> FAQs</a></li>
            <li><a href="{{ route('admin.testimonials') }}" class="{{ Route::is('admin.testimonials') ? 'active' : '' }}"><i class="fa-solid fa-comment-dots"></i> Testimonials</a></li>
            <li><a href="{{ route('admin.subscribers') }}" class="{{ Route::is('admin.subscribers') ? 'active' : '' }}"><i class="fa-solid fa-users-line"></i> Mailing List</a></li>
            <li><a href="{{ route('admin.queries') }}" class="{{ Route::is('admin.queries') ? 'active' : '' }}"><i class="fa-solid fa-envelope-open-text"></i> User Queries</a></li>
            <li><a href="{{ url('/') }}"><i class="fa-solid fa-eye"></i> View Website</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 10px; margin-bottom: 30px;">
                {{ session('success') }}
            </div>
        @endif
        
        @yield('content')
    </div>
</body>
</html>
