@extends('layouts.app')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">New Sales Transaction</h1>
        <p class="page-subtitle">Enter product details and customer information to generate a receipt.</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">View Sales History</a>
    </div>
</div>

<div style="max-width: 900px; margin: 0 auto;">
    <form method="POST" action="{{ route('sales.store') }}" id="salesForm">
        @csrf
        <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 24px;">
            
            <div class="card p-8">
                <h3 style="margin-bottom: 20px; font-size: 1.1rem; color: #1e293b; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">Item Details</h3>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #64748b; margin-bottom: 8px; font-size: 0.75rem; letter-spacing: 0.05em;">SELECT PRODUCT</label>
                    <select name="product_id" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; font-family: inherit;">
                        <option value="" disabled selected>Search inventory...</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }} — ₦{{ number_format($product->price) }} (Stock: {{ $product->stock_quantity }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #64748b; margin-bottom: 8px; font-size: 0.75rem; letter-spacing: 0.05em;">QUANTITY</label>
                    <input type="number" name="quantity" min="1" required placeholder="0" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0;">
                </div>
            </div>

            <!-- Right Column: Buyer Details -->
            <div class="card p-8" style="background-color: #f8fafc;">
                <h3 style="margin-bottom: 20px; font-size: 1.1rem; color: #1e293b; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">Customer Info</h3>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; color: #64748b; margin-bottom: 5px; font-size: 0.75rem;">NAME</label>
                    <input type="text" name="customer_name" placeholder="Optional" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; color: #64748b; margin-bottom: 5px; font-size: 0.75rem;">PHONE NUMBER</label>
                    <input type="text" name="customer_phone" placeholder="Optional" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                </div>

                <div style="margin-top: 30px;">
                    <button type="submit" class="btn" style="width: 100%; background-color: var(--accent-mint); color: #064e3b; font-weight: 700; padding: 14px; border: none; border-radius: 12px; cursor: pointer;">
                        COMPLETE SALE & PRINT
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection