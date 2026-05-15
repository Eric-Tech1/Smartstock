<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SmartStock_Receipt_{{ $sale->id }}</title>
    <style>
        :root {
            --primary: #0f172a;
            --accent: #4ade80; /* Matching your mint green */
            --text-muted: #64748b;
        }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            line-height: 1.6; 
            color: var(--primary);
            margin: 0;
            padding: 40px;
            background: #f1f5f9;
        }
        .receipt-card {
            background: #fff;
            max-width: 450px;
            margin: auto;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .header { text-align: center; margin-bottom: 30px; }
        .logo-mark { 
            width: 50px; height: 50px; background: var(--accent); 
            border-radius: 12px; margin: 0 auto 15px; 
        }
        .receipt-title { 
            font-weight: 800; font-size: 1.5rem; letter-spacing: -0.025em; 
            margin: 0; text-transform: uppercase;
        }
        .meta-info { 
            display: flex; justify-content: space-between; 
            font-size: 0.85rem; color: var(--text-muted); 
            margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;
        }
        .customer-box {
            background: #f8fafc; padding: 15px; border-radius: 12px; margin-bottom: 25px;
        }
        .item-row { 
            display: flex; justify-content: space-between; align-items: center; 
            margin-bottom: 10px; font-weight: 500;
        }
        .total-section {
            margin-top: 20px; padding-top: 20px; border-top: 2px solid var(--primary);
        }
        .footer-note {
            text-align: center; font-size: 0.75rem; color: var(--text-muted); margin-top: 30px;
        }
        .btn-group { display: flex; gap: 10px; margin-top: 20px; justify-content: center; }
        .btn-print {
            background: var(--primary); color: white; padding: 10px 20px; 
            border-radius: 8px; border: none; cursor: pointer; font-weight: 600;
        }
        @media print { .no-print { display: none !important; } body { background: white; padding: 0; } .receipt-card { box-shadow: none; border: none; width: 100%; } }
    </style>
</head>
<body>

<div class="receipt-card">
    <div class="header">
        <div class="logo-mark"></div>
        <h1 class="receipt-title">SmartStock</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Transaction Confirmed</p>
    </div>

    <div class="meta-info">
        <span>REF: #SS-{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</span>
        <span>{{ $sale->created_at->format('M d, Y • h:i A') }}</span>
    </div>

    <div class="customer-box">
        <p style="margin: 0; font-size: 0.75rem; color: var(--text-muted); font-weight: 700;">BILL TO</p>
        <p style="margin: 5px 0 0; font-weight: 600;">{{ $sale->customer_name ?? 'Guest Customer' }}</p>
        @if($sale->customer_phone)
            <p style="margin: 0; font-size: 0.85rem;">{{ $sale->customer_phone }}</p>
        @endif
    </div>

    <div class="item-row">
        <span>{{ $sale->product->name }}</span>
        <span>x{{ $sale->quantity }}</span>
    </div>
    <div class="item-row" style="color: var(--text-muted); font-size: 0.9rem;">
        <span>Unit Price</span>
        <span>₦{{ number_format($sale->product->price) }}</span>
    </div>

    <div class="total-section">
        <div class="item-row" style="font-size: 1.25rem; font-weight: 800;">
            <span>TOTAL</span>
            <span>₦{{ number_format($sale->total_price) }}</span>
        </div>
    </div>

    <div class="footer-note">
        <p>Thank you for shopping with us!<br>Please retain this receipt for any returns or exchanges.</p>
    </div>

    <div class="btn-group no-print">
        <button class="btn-print" onclick="window.print()">Print Receipt</button>
        <a href="{{ route('sales.create') }}" style="color: var(--text-muted); font-size: 0.9rem; padding: 10px;">New Sale</a>
    </div>
</div>

</body>
</html>