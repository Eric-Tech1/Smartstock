@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-8">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Sales Report
        </h1>

        <p class="text-gray-500 mt-1">
            View, filter and export all sales transactions.
        </p>
    </div>

</div>

<!-- FILTER + EXPORT SECTION -->

<div class="bg-white p-6 rounded-2xl shadow mb-8">

    <form
        method="GET"
        action="{{ route('reports.sales') }}"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4"
    >

        <!-- START DATE -->

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-2">
                Start Date
            </label>

            <input
                type="date"
                name="start_date"
                value="{{ request('start_date') }}"
                class="
                    w-full
                    border
                    border-gray-300
                    rounded-xl
                    px-4
                    py-3
                    focus:ring-2
                    focus:ring-blue-500
                    focus:outline-none
                "
            >
        </div>

        <!-- END DATE -->

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-2">
                End Date
            </label>

            <input
                type="date"
                name="end_date"
                value="{{ request('end_date') }}"
                class="
                    w-full
                    border
                    border-gray-300
                    rounded-xl
                    px-4
                    py-3
                    focus:ring-2
                    focus:ring-blue-500
                    focus:outline-none
                "
            >
        </div>

        <!-- FILTER BUTTON -->

        <div class="flex items-end">
            <button
                type="submit"
                class="
                    w-full
                    bg-blue-600
                    hover:bg-blue-700
                    text-white
                    px-6
                    py-3
                    rounded-xl
                    font-semibold
                    transition
                "
            >
                Filter Report
            </button>
        </div>

        <!-- EXPORT CSV -->

        <div class="flex items-end">
            <a
                href="{{ route('reports.sales.csv') }}"
                class="
                    w-full
                    bg-green-600
                    hover:bg-green-700
                    text-white
                    px-6
                    py-3
                    rounded-xl
                    font-semibold
                    text-center
                    transition
                "
            >
                Download CSV
            </a>
        </div>

        <!-- EXPORT PDF -->

        <div class="flex items-end">
            <a
                href="{{ route('reports.sales.pdf') }}"
                class="
                    w-full
                    bg-red-600
                    hover:bg-red-700
                    text-white
                    px-6
                    py-3
                    rounded-xl
                    font-semibold
                    text-center
                    transition
                "
            >
                Download PDF
            </a>
        </div>

    </form>

</div>

<!-- REPORT TABLE -->

<div class="bg-white rounded-2xl shadow overflow-hidden">

    <div class="p-6 border-b">

        <h2 class="text-xl font-bold text-gray-800">
            Sales Transactions
        </h2>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-50">

                <tr>

                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">
                        Product
                    </th>

                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">
                        Quantity
                    </th>

                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">
                        Total Price
                    </th>

                    <th class="text-left px-6 py-4 text-sm font-semibold text-gray-600">
                        Date
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($sales as $sale)

                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $sale->product->name ?? 'Deleted Product' }}
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $sale->quantity }}
                        </td>

                        <td class="px-6 py-4 font-semibold text-green-600">
                            &#8358;{{ number_format($sale->total_price, 2) }}
                        </td>

                        <td class="px-6 py-4 text-gray-500">
                            {{ $sale->created_at->format('d M Y') }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                            No sales records found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection