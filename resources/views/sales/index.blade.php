@extends('layouts.app')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="page-title">Sales Transactions</h1>
        <p class="page-subtitle">Track and manage all recorded sales history.</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('sales.create') }}" class="btn" style="background-color: var(--accent-mint); color: #064e3b;">
            + New Sale
        </a>
    </div>
</div>

<div class="card p-6">
    <div class="table-responsive">
        <table class="modern-table">
            <thead>
                <tr>
                    <th style="width: 35%">PRODUCT</th>
                    <th style="width: 15%">QUANTITY</th>
                    <th style="width: 20%">TOTAL PRICE</th>
                    <th style="width: 20%">DATE</th>
                    <th style="width: 10%; text-align: right; padding-right: 20px;">STATUS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                <tr>
                    <td>
                        <div class="product-info-cell">
                            <span class="dot" style="background-color: #4ade80"></span>
                            <span class="font-bold">{{ $sale->product->name ?? 'Deleted Product' }}</span>
                        </div>
                    </td>
                    <td class="text-muted">{{ $sale->quantity }} units</td>
                    <td class="font-bold">₦{{ number_format($sale->total_price) }}</td>
                    <td>
                        <span class="text-muted">{{ $sale->created_at->format('d M Y, h:i A') }}</span>
                    </td>
                    <td style="text-align: right; padding-right: 20px;">
                        <span class="trend-indicator up">Completed</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if($sales->isEmpty())
    <div class="text-center mt-10">
        <p class="text-muted">No sales transactions found.</p>
    </div>
@endif

@endsection