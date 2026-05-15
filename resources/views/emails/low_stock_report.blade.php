<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; color: #1e293b; line-height: 1.6; }
        .container { padding: 20px; max-width: 600px; margin: auto; border: 1px solid #e2e8f0; border-radius: 12px; }
        .header { border-bottom: 2px solid #4ade80; padding-bottom: 10px; margin-bottom: 20px; }
        .item-table { width: 100%; border-collapse: collapse; }
        .item-table th { text-align: left; color: #64748b; font-size: 0.8rem; padding: 10px; }
        .item-table td { padding: 10px; border-bottom: 1px solid #f1f5f9; }
        .badge { background: #fee2e2; color: #ef4444; padding: 4px 8px; border-radius: 4px; font-weight: bold; }
        .footer { margin-top: 30px; font-size: 0.8rem; color: #94a3b8; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>SmartStock Inventory Alert</h2>
            <p>The following items have dropped below their critical threshold.</p>
        </div>

        <table class="item-table">
            <thead>
                <tr>
                    <th>PRODUCT</th>
                    <th>CURRENT STOCK</th>
                    <th>THRESHOLD</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lowStockItems as $item)
                <tr>
                    <td><strong>{{ $item->name }}</strong></td>
                    <td><span class="badge">{{ $item->stock_quantity }} left</span></td>
                    <td>{{ $item->low_stock_threshold }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>This is an automated report from your SmartStock Dashboard.</p>
            <a href="{{ url('/dashboard') }}" style="color: #4ade80; font-weight: bold; text-decoration: none;">Login to Manage Inventory</a>
        </div>
    </div>
</body>
</html>