import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, router } from '@inertiajs/react';

export default function Index({ sales, filters }) {
    const [values, setValues] = useState({
        start_date: filters.start_date || '',
        end_date: filters.end_date || '',
    });

    function handleChange(e) {
        setValues(values => ({
            ...values,
            [e.target.name]: e.target.value,
        }));
    }

    function handleFilter(e) {
        e.preventDefault();
        router.get(route('reports.sales'), values, {
            preserveState: true,
            replace: true,
        });
    }

    return (
        <AuthenticatedLayout>
            <Head title="Sales Report" />

            <div className="flex items-center justify-between mb-8">
                <div>
                    <h1 className="text-3xl font-bold text-gray-800">Sales Report</h1>
                    <p className="text-gray-500 mt-1">View, filter and export all sales transactions.</p>
                </div>
            </div>

            {/* FILTER + EXPORT SECTION */}
            <div className="bg-white p-6 rounded-2xl shadow mb-8">
                <form onSubmit={handleFilter} className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    {/* START DATE */}
                    <div>
                        <label className="block text-sm font-medium text-gray-600 mb-2">Start Date</label>
                        <input
                            type="date"
                            name="start_date"
                            value={values.start_date}
                            onChange={handleChange}
                            className="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        />
                    </div>

                    {/* END DATE */}
                    <div>
                        <label className="block text-sm font-medium text-gray-600 mb-2">End Date</label>
                        <input
                            type="date"
                            name="end_date"
                            value={values.end_date}
                            onChange={handleChange}
                            className="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        />
                    </div>

                    {/* FILTER BUTTON */}
                    <div className="flex items-end">
                        <button type="submit" className="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition">
                            Filter Report
                        </button>
                    </div>

                    {/* EXPORT CSV - Standard <a> tags for file downloads */}
                    <div className="flex items-end">
                        <a href={route('reports.sales.csv', values)} className="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold text-center transition">
                            Download CSV
                        </a>
                    </div>

                    {/* EXPORT PDF */}
                    <div className="flex items-end">
                        <a href={route('reports.sales.pdf', values)} className="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold text-center transition">
                            Download PDF
                        </a>
                    </div>
                </form>
            </div>

            {/* REPORT TABLE */}
            <div className="bg-white rounded-2xl shadow overflow-hidden">
                <div className="p-6 border-b">
                    <h2 className="text-xl font-bold text-gray-800">Sales Transactions</h2>
                </div>

                <div className="overflow-x-auto">
                    <table className="w-full">
                        <thead className="bg-gray-50">
                            <tr>
                                <th className="text-left px-6 py-4 text-sm font-semibold text-gray-600">Product</th>
                                <th className="text-left px-6 py-4 text-sm font-semibold text-gray-600">Quantity</th>
                                <th className="text-left px-6 py-4 text-sm font-semibold text-gray-600">Total Price</th>
                                <th className="text-left px-6 py-4 text-sm font-semibold text-gray-600">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            {sales.length > 0 ? (
                                sales.map((sale) => (
                                    <tr key={sale.id} className="border-b hover:bg-gray-50 transition">
                                        <td className="px-6 py-4 font-medium text-gray-800">
                                            {sale.product?.name || 'Deleted Product'}
                                        </td>
                                        <td className="px-6 py-4 text-gray-600">{sale.quantity}</td>
                                        <td className="px-6 py-4 font-semibold text-green-600">
                                            ₦{new Intl.NumberFormat().format(sale.total_price)}
                                        </td>
                                        <td className="px-6 py-4 text-gray-500">
                                            {new Date(sale.created_at).toLocaleDateString('en-GB', {
                                                day: '2-digit',
                                                month: 'short',
                                                year: 'numeric'
                                            })}
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan="4" className="px-6 py-10 text-center text-gray-500">
                                        No sales records found.
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}