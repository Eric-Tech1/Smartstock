@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    <!-- HEADER -->
    <h1 class="text-3xl font-bold mb-2">
        Add New Product
    </h1>

    <p class="text-gray-500 mb-8">
        Fill in the details below to add a product to your inventory
    </p>

    <!-- FORM CARD -->
    <div class="bg-white p-8 rounded-2xl shadow">

        <form method="POST" action="/products" class="space-y-5">
            @csrf

            <!-- PRODUCT NAME -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Product Name
                </label>

                <input type="text"
                       name="name"
                       placeholder="e.g. iPhone 13"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- SKU -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    SKU
                </label>

                <input type="text"
                       name="sku"
                       placeholder="e.g. IP13-128-BLK"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- PRICE -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Price (₦)
                </label>

                <input type="number"
                       step="0.01"
                       name="price"
                       placeholder="e.g. 250000"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- STOCK -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Stock Quantity
                </label>

                <input type="number"
                       name="stock_quantity"
                       placeholder="e.g. 50"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- CATEGORY -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Category
                </label>

                <input type="text"
                       name="category"
                       placeholder="e.g. Electronics"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- BUTTONS -->
            <div class="flex justify-between items-center pt-4">

                <a href="/products"
                   class="text-gray-600 hover:text-gray-800">
                    Cancel
                </a>

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold">
                    Save Product
                </button>

            </div>

        </form>

    </div>

</div>

@endsection