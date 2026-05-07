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
        body { background: #f0f2f5; display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: #1a1a1a; color: #fff; padding: 30px 0; display: flex; flex-direction: column; }
        .sidebar-brand { padding: 0 30px 40px; font-size: 1.5rem; font-weight: 800; border-bottom: 1px solid #333; margin-bottom: 30px; }
        .sidebar-menu { list-style: none; flex: 1; }
        .sidebar-menu li a { display: flex; align-items: center; gap: 15px; padding: 15px 30px; color: #aaa; transition: 0.3s; }
        .sidebar-menu li a:hover, .sidebar-menu li a.active { background: var(--primary-color); color: #fff; }
        .main-content { flex: 1; padding: 40px; overflow-y: auto; }
        .admin-card { background: #fff; padding: 25px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
        .form-control { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ddd; font-family: inherit; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">Tunicart Admin</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}" class="{{ Route::is('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.categories') }}" class="{{ Route::is('admin.categories') ? 'active' : '' }}"><i class="fa-solid fa-list"></i> Categories</a></li>
            <li><a href="{{ route('admin.products') }}" class="{{ Route::is('admin.products') ? 'active' : '' }}"><i class="fa-solid fa-shirt"></i> Products</a></li>
            <li><a href="{{ route('admin.banners') }}" class="{{ Route::is('admin.banners') ? 'active' : '' }}"><i class="fa-solid fa-image"></i> Banners</a></li>
            <li><a href="{{ route('admin.orders') }}" class="{{ Route::is('admin.orders') ? 'active' : '' }}"><i class="fa-solid fa-truck"></i> Manage Orders</a></li>
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
