import React from 'react';
import { useForm } from '@inertiajs/react';

export default function Create({ onClose }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        sku: '',
        price: '',
        stock_quantity: '',
        category: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('products.store'), {
            onSuccess: () => {
                reset();
                onClose();
            },
        });
    };

    return (
        <div className="w-full p-2">
            {/* Header */}
            <div className="mb-6">
                <h2 className="text-xl font-bold text-gray-800">Add New Product</h2>
                <p className="text-sm text-gray-500">Fill in the information below to update your stock.</p>
            </div>

            <form onSubmit={submit} className="space-y-5">
                {/* Product Name - Full Width */}
                <div className="flex flex-col">
                    <label className="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Product Name</label>
                    <input 
                        type="text"
                        value={data.name}
                        onChange={e => setData('name', e.target.value)}
                        placeholder="e.g. iPhone 13 Pro"
                        className="border border-gray-300 rounded-lg px-4 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all"
                    />
                    {errors.name && <span className="text-red-500 text-xs mt-1">{errors.name}</span>}
                </div>

                {/* SKU and Category - Two Columns */}
                <div className="flex gap-4">
                    <div className="flex-1">
                        <label className="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">SKU</label>
                        <input 
                            type="text"
                            value={data.sku}
                            onChange={e => setData('sku', e.target.value)}
                            placeholder="IP13-BLK"
                            className="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none"
                        />
                    </div>
                    <div className="flex-1">
                        <label className="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Category</label>
                        <input 
                            type="text"
                            value={data.category}
                            onChange={e => setData('category', e.target.value)}
                            placeholder="Mobile"
                            className="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none"
                        />
                    </div>
                </div>

                {/* Price and Stock - Two Columns */}
                <div className="flex gap-4">
                    <div className="flex-1">
                        <label className="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Price (₦)</label>
                        <input 
                            type="number"
                            value={data.price}
                            onChange={e => setData('price', e.target.value)}
                            className="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none"
                        />
                    </div>
                    <div className="flex-1">
                        <label className="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Stock Qty</label>
                        <input 
                            type="number"
                            value={data.stock_quantity}
                            onChange={e => setData('stock_quantity', e.target.value)}
                            className="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none"
                        />
                    </div>
                </div>

                {/* Footer Buttons */}
                <div className="flex justify-end items-center gap-3 mt-8 pt-4 border-t border-gray-100">
                    <button 
                        type="button" 
                        onClick={onClose}
                        className="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 transition-colors"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        disabled={processing}
                        className="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold text-sm transition-all disabled:opacity-50 shadow-md"
                    >
                        {processing ? 'Saving...' : 'Add Product'}
                    </button>
                </div>
            </form>
        </div>
    );
}