<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Inertia\Inertia;

class SaleController extends Controller
{
    /**
     * Display a listing of the sales and products for the popup.
     */
    public function index()
    {
        // Fetch sales with product relationship for the main table
        $sales = Sale::with('product')->latest()->get();

        // Fetch products with stock for the 'New Sale' popup
        $products = Product::where('stock_quantity', '>', 0)
                           ->orderBy('name')
                           ->get();

        // Pass both to the Index component
        return Inertia::render('Sales/Index', [
            'sales' => $sales,
            'products' => $products
        ]);
    }

    /**
     * Store a newly created sale in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Ensure stock is available before processing
        if ($product->stock_quantity < $request->quantity) {
            return back()->withErrors(['quantity' => 'Insufficient stock available.']);
        }

        $total_price = $product->price * $request->quantity;

        $sale = Sale::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $total_price,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
        ]);

        // Update stock
        $product->decrement('stock_quantity', $request->quantity);

        // Redirecting back to the index to refresh the table and show the receipt
        return redirect()->route('sales.index')->with('success', 'Sale completed successfully.');
    }
}