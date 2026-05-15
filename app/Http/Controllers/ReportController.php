<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    /**
     * Render the main sales report page via Inertia.
     */
    public function sales(Request $request)
    {
        // Start the query with the product relationship
        $query = Sale::with('product');

        // Apply date filters if they exist in the request
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $sales = $query->latest()->get();

        // Return the Inertia Page (matches resources/js/Pages/Reports/Index.jsx)
        return Inertia::render('Reports/Index', [
            'sales' => $sales,
            'filters' => $request->only(['start_date', 'end_date'])
        ]);
    }

    /**
     * CSV EXPORT
     * Updated to support filtered data.
     */
    public function exportCsv(Request $request)
    {
        $query = Sale::with('product');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $sales = $query->get();
        $filename = 'sales_report_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($sales) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Product', 'Quantity', 'Total Price', 'Date']);

            foreach ($sales as $sale) {
                fputcsv($file, [
                    $sale->product->name ?? 'Deleted Product',
                    $sale->quantity,
                    $sale->total_price,
                    $sale->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * PDF EXPORT
     * Updated to support filtered data.
     */
    public function exportPdf(Request $request)
    {
        $query = Sale::with('product');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $sales = $query->get();

        // Note: This still uses a Blade view (reports.sales_pdf) 
        // because PDF engines generally require HTML/CSS, not React components.
        $pdf = Pdf::loadView('reports.sales_pdf', [
            'sales'        => $sales,
            'totalSales'   => $sales->count(),
            'totalRevenue' => $sales->sum('total_price'),
            'filters'      => $request->only(['start_date', 'end_date'])
        ]);

        return $pdf->download('sales_report.pdf');
    }
}