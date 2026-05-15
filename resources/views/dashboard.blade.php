@extends('layouts.app')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">
            Hi {{ explode(' ', trim(Auth::user()->name))[0] }},
        </h1>
        <p class="page-subtitle">Welcome back! Here is what's happening with the inventory today.</p>
    </div>
    <div class="header-actions">
        <span class="date-display">{{ now()->format('D, M d, Y') }}</span>
    </div>
</div>

<div class="stats-container mb-10">
    <div class="card stat-card-alt">
        <div class="card-header-inline">
            <span class="icon-label blue">📦</span>
            <h3 class="block-title">Products</h3>
        </div>
        <div class="card-body-main">
            <a href="{{ route('products.index') }}" class="btn btn-secondary mt-2">Manage Inventory</a>
        </div>
    </div>

    <div class="card stat-card-alt">
        <div class="card-header-inline">
            <span class="icon-label green">💰</span>
            <h3 class="block-title">Sales</h3>
        </div>
        <div class="card-body-main">
            <a href="{{ route('sales.create') }}" class="btn btn-primary mt-2">+ Record New Sale</a>
        </div>
    </div>
</div>
@endsection