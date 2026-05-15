<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LowStockReport extends Mailable
{
    use Queueable, SerializesModels;

    public $lowStockItems;

    public function __construct($items)
    {
        $this->lowStockItems = $items;
    }

    public function build()
    {
        return $this->subject('⚠️ SmartStock: Low Inventory Alert')
                    ->view('emails.low_stock_report');
    }
}