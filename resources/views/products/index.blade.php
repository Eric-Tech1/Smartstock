@extends('layouts.app')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Inventory Management</h1>
        <p class="page-subtitle">Manage all your products, stock levels, and pricing.</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('products.create') }}" class="btn" style="background-color: var(--accent-mint); color: #064e3b;">
            + Add New Product
        </a>
    </div>
</div>

<div class="card p-6">
    <div class="table-responsive">
       <table class="modern-table">
    <thead>
        <tr>
            <th style="width: 35%">PRODUCT DETAILS</th>
            <th style="width: 15%">SKU</th>
            <th style="width: 15%">PRICE</th>
            <th style="width: 15%">STOCK LEVEL</th>
            <th style="width: 20%; text-align: right; padding-right: 20px;">ACTIONS</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>
                <div class="product-info-cell">
                    <span class="dot" style="background-color: {{ $product->stock_quantity < 10 ? '#ef4444' : '#4ade80' }}"></span>
                    <span class="font-bold">{{ $product->name }}</span>
                </div>
            </td>
            <td class="text-muted">{{ $product->sku }}</td>
            <td class="font-bold">₦{{ number_format($product->price) }}</td>
            <td>
                <span class="trend-indicator {{ $product->stock_quantity < 10 ? 'down' : 'up' }}">
                    {{ $product->stock_quantity }} in stock
                </span>
            </td>
            <td style="width: 20%; text-align: right; padding-right: 20px;">
                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 8px;">
                    <a href="{{ route('products.edit', $product->id) }}" 
                       class="btn btn-secondary" 
                       style="padding: 6px 16px; font-size: 0.85rem; border-radius: 8px; white-space: nowrap; text-decoration: none;">
                       Edit
                    </a>

                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="margin: 0; display: flex;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Delete this product?')"
                                class="btn" 
                                style="background: #fee2e2; color: #b91c1c; padding: 6px 16px; font-size: 0.85rem; border-radius: 8px; border: none; cursor: pointer; white-space: nowrap;">
                            Delete
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
    </div>
</div>

@if($products->isEmpty())
    <div class="text-center mt-10">
        <p class="text-muted">No products found in the system.</p>
    </div>
@endif

@endsection