<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\User;
use App\Mail\LowStockReport;
use Illuminate\Support\Facades\Mail;

class SendLowStockAlerts extends Command
{
    protected $signature = 'inventory:alert';
    protected $description = 'Check for low stock and email the Admin';

    public function handle()
{
    $lowStockItems = Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')->get();

    if ($lowStockItems->count() > 0) {
        // Target Eric specifically by his email
        $admin = User::where('email', 'lucifererix@gmail.com')->first();
        
        if ($admin) {
            Mail::to($admin->email)->send(new LowStockReport($lowStockItems));
            $this->info('Alert email sent to ' . $admin->email);
        }
    }
}
}