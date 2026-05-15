@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="dashboard-header">
    <div>
        <h1 class="page-title">Analytics Overview</h1>
        <p class="page-subtitle">Real-time monitoring of revenue, sales, and inventory health.</p>
    </div>
    <div class="header-actions">
        <span class="date-display">{{ now()->format('D, M d, Y') }}</span>
    </div>
</div>

<div class="stats-container mb-10">
    <!-- Revenue Card -->
    <div class="card stat-card-alt">
        <div class="card-header-inline">
            <span class="icon-label blue">₦</span>
            <h3 class="block-title">Revenue</h3>
        </div>
        <div class="card-body-main">
            <h2 class="main-value">₦{{ number_format($totalRevenue, 0) }}</h2>
            <div class="trend-indicator {{ $revenueChange >= 0 ? 'up' : 'down' }}">
                <span class="trend-icon">{{ $revenueChange >= 0 ? '▲' : '▼' }}</span>
                <span class="trend-text">{{ abs(number_format($revenueChange, 1)) }}% vs yesterday</span>
            </div>
        </div>
    </div>

    <!-- Total Sales Card -->
    <div class="card stat-card-alt">
        <div class="card-header-inline">
            <span class="icon-label green">📊</span>
            <h3 class="block-title">Total Sales</h3>
        </div>
        <div class="card-body-main">
            <h2 class="main-value">{{ number_format($totalSales) }}</h2>
            <p class="sub-label">Completed Transactions</p>
        </div>
    </div>

    <!-- Improved Inventory Card (Syncs with threshold) -->
    <div class="card stat-card-alt" onclick="window.location='/products?filter=low_stock'" style="cursor: pointer;">
        <div class="card-header-inline">
            <span class="icon-label orange">📦</span>
            <h3 class="block-title">Inventory</h3>
        </div>
        <div class="card-body-main">
            @php
                $lowStockCount = \App\Models\Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')->count();
            @endphp
            <h2 class="main-value {{ $lowStockCount > 0 ? 'text-red' : '' }}">{{ $lowStockCount }}</h2>
            <p class="sub-label">Critical Threshold Alerts</p>
        </div>
    </div>

    <!-- Top Product Card -->
    <div class="card stat-card-alt">
        <div class="card-header-inline">
            <span class="icon-label purple">⭐</span>
            <h3 class="block-title">Top Product</h3>
        </div>
        <div class="card-body-main">
            <h2 class="main-value small" style="font-size: 1.1rem; line-height: 1.2;">{{ $bestProduct->name ?? 'N/A' }}</h2>
            <p class="sub-label">Highest Volume Seller</p>
        </div>
    </div>
</div>

<div class="grid-2-cols mb-10">
    <!-- Chart Section -->
    <div class="card p-0 overflow-hidden">
        <div class="p-6 flex-between">
            <h3 class="block-title">Revenue Performance</h3>
            <span class="text-muted" style="font-size: 0.8rem;">Last 7 Days</span>
        </div>
        <div class="chart-wrapper" style="height: 300px; padding: 0 20px 20px;">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Product Table -->
    <div class="card">
        <h3 class="block-title mb-6">Top Performers</h3>
        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>PRODUCT</th>
                        <th class="text-right">UNITS SOLD</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topProducts as $product)
                    <tr>
                        <td>
                            <div class="product-info-cell">
                                <span class="dot" style="background-color: var(--accent-mint)"></span>
                                <span class="font-bold">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="text-right font-bold" style="color: var(--accent-mint);">{{ $product->sales_sum_quantity ?? 0 }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Refined Critical Alerts Section -->
@php
    $lowStockProducts = \App\Models\Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')->get();
@endphp

@if($lowStockProducts->count() > 0)
<div class="alert-section">
    <div class="card" style="border: 1px solid #fee2e2; background-color: #fffafb;">
        <div class="flex-between mb-4" style="border-bottom: 1px solid #fee2e2; padding-bottom: 15px;">
            <h3 class="block-title" style="color: #b91c1c;">⚠️ Critical Stock Alerts</h3>
            <span class="badge red" style="background: #ef4444; color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem;">
                {{ $lowStockProducts->count() }} Items Require Attention
            </span>
        </div>
        <div class="alert-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 15px;">
            @foreach($lowStockProducts as $product)
            <div class="alert-item-minimal" style="display: flex; align-items: center; gap: 10px; padding: 10px; background: white; border-radius: 10px; border: 1px solid #fecaca;">
                <span class="alert-dot" style="height: 8px; width: 8px; background: #ef4444; border-radius: 50%; display: inline-block; animation: pulse-red 2s infinite;"></span>
                <span class="alert-text" style="font-size: 0.85rem; color: #1e293b;">
                    <strong>{{ $product->name }}</strong> is at <span style="color: #ef4444; font-weight: 700;">{{ $product->stock_quantity }}</span> units.
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart');
        
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($salesData->pluck('date')) !!},
                    datasets: [{
                        label: 'Revenue',
                        data: {!! json_encode($salesData->pluck('total')) !!},
                        borderColor: '#4ade80',
                        backgroundColor: 'rgba(74, 222, 128, 0.05)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#4ade80',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            titleFont: { size: 14 },
                            callbacks: {
                                label: function(context) {
                                    return ' ₦' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        x: { 
                            grid: { display: false },
                            ticks: { color: '#94a3b8', font: { family: 'Plus Jakarta Sans', size: 10 } }
                        },
                        y: { 
                            border: { dash: [4, 4] },
                            grid: { color: '#f1f5f9' },
                            ticks: { 
                                color: '#94a3b8',
                                font: { family: 'Plus Jakarta Sans', size: 10 },
                                callback: function(value) { return '₦' + value.toLocaleString(); }
                            }
                        }
                    }
                }
            });
        }
    });
</script>

<style>
    @keyframes pulse-red {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }
    .text-red { color: #ef4444 !important; }
</style>

@endsection