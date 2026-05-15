@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    <h1 class="text-3xl font-bold mb-2">
        Edit Product
    </h1>

    <p class="text-gray-500 mb-8">
        Update product details in your inventory
    </p>


    <div class="bg-white p-8 rounded-2xl shadow">

        <form method="POST" action="/products/{{ $product->id }}" class="space-y-5">
            @csrf
            @method('PUT')


            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Product Name
                </label>

                <input type="text"
                       name="name"
                       value="{{ $product->name }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    SKU
                </label>

                <input type="text"
                       name="sku"
                       value="{{ $product->sku }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

           
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Price (₦)
                </label>

                <input type="number"
                       step="0.01"
                       name="price"
                       value="{{ $product->price }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Stock Quantity
                </label>

                <input type="number"
                       name="stock_quantity"
                       value="{{ $product->stock_quantity }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Category
                </label>

                <input type="text"
                       name="category"
                       value="{{ $product->category }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div class="flex justify-between items-center pt-4">

                <a href="/products"
                   class="text-gray-600 hover:text-gray-800">
                    Cancel
                </a>

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold">
                    Update Product
                </button>

            </div>

        </form>

    </div>

</div>

@endsection