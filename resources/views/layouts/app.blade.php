<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartStock</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="dashboard-body">

<div class="app-container">

    <aside class="sidebar">
        <div class="sidebar-top">
            <div class="logo-section">
                <div class="logo-box"></div>
                <span class="logo-text">SmartStock</span>
            </div>

            <nav class="nav-menu">
                <a href="/dashboard" class="nav-item {{ Request::is('dashboard*') || Request::is('admin/dashboard*') ? 'active' : '' }}">📊 Dashboard</a>
                <a href="/products" class="nav-item {{ Request::is('products*') ? 'active' : '' }}">📦 Products</a>
                <a href="/sales" class="nav-item {{ Request::is('sales*') ? 'active' : '' }}">💰 Sales</a>
                <a href="/reports/sales" class="nav-item {{ Request::is('reports*') ? 'active' : '' }}">📄 Reports</a>
            </nav>
        </div>

        <div class="sidebar-bottom">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn" style="color: #ef4444; border: none; background: none; cursor: pointer; font-family: inherit; font-weight: 500;">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        <header class="top-header" style="display: flex; justify-content: flex-end; align-items: center; padding: 24px 40px; gap: 25px;">
    
    @php
        // Only count if the column exists to prevent errors during migration
        $lowStockCount = Schema::hasColumn('products', 'low_stock_threshold') 
            ? \App\Models\Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')->count() 
            : 0;
    @endphp

    @if($lowStockCount > 0)
    <div class="notification-wrapper" style="position: relative; cursor: pointer; transition: transform 0.2s;" 
         onclick="window.location='/products?filter=low_stock'"
         onmouseover="this.style.transform='scale(1.1)'" 
         onmouseout="this.style.transform='scale(1)'"
         title="Low Stock Alert: {{ $lowStockCount }} items">
        
        <!-- Bell Icon with subtle color -->
        <span style="font-size: 1.4rem; color: #64748b;">🔔</span>
        
        <!-- Badge with Pulse Animation -->
        <span class="pulse-badge" style="
            position: absolute; 
            top: -2px; 
            right: -2px; 
            background: #ef4444; 
            color: white; 
            border-radius: 50%; 
            min-width: 18px; 
            height: 18px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 0.65rem; 
            font-weight: 800;
            border: 2px solid #fff;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
        ">
            {{ $lowStockCount }}
        </span>
    </div>

    <style>
        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }
        .pulse-badge {
            animation: pulse-red 2s infinite;
        }
    </style>
    @endif

    <div class="user-profile" style="display: flex; align-items: center; gap: 12px; border-left: 1px solid #e2e8f0; padding-left: 20px;">
        <div class="user-info" style="text-align: right;">
            <span class="user-name" style="display: block; font-weight: 700; color: #1e293b; font-size: 0.95rem;">
                {{ Auth::user()->name ?? 'Admin User' }}
            </span>
            <span class="user-role" style="display: block; font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.025em;">
                {{ Auth::user()->role ?? 'Manager' }}
            </span>
        </div>
        <div class="avatar" style="width: 40px; height: 40px; background: var(--accent-mint); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #064e3b;">
            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
        </div>
    </div>
</header>

        <section class="content-wrapper">
            @yield('content')
        </section>
    </main>

</div>

</body>
</html>