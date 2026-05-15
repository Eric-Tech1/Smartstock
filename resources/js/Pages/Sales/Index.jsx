import React, { useState } from 'react';
import { Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import CreateSaleForm from './Create'; 

export default function Index({ sales = [], products = [] }) {
    const [showModal, setShowModal] = useState(false);

    return (
        <AuthenticatedLayout>
            {/* CENTERED POPUP MODAL */}
            {showModal && (
                <div className="fixed inset-0 z-[100] flex items-center justify-center p-4">
                    {/* Backdrop: Dims the background and closes modal on click */}
                    <div 
                        className="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" 
                        onClick={() => setShowModal(false)}
                    />
                    
                    {/* Modal Container: Centered, fixed width, and elevated */}
                    <div 
                        className="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl flex flex-col overflow-hidden animate-in fade-in zoom-in duration-200"
                        style={{ maxHeight: '90vh' }}
                    >
                        {/* Modal Header */}
                        <div className="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-white sticky top-0 z-10">
                            <h2 className="text-lg font-bold text-slate-800">New Sales Transaction</h2>
                            <button 
                                onClick={() => setShowModal(false)} 
                                className="p-2 rounded-full hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors"
                            >
                                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        {/* Modal Body: Scrollable area for the form */}
                        <div className="flex-1 overflow-y-auto p-8">
                            <CreateSaleForm products={products} onClose={() => setShowModal(false)} />
                        </div>
                    </div>
                </div>
            )}

            {/* MAIN PAGE TABLE */}
            <div className="dashboard-header">
                <div>
                    <h1 className="page-title">Sales Transactions</h1>
                    <p className="page-subtitle">Track and manage all recorded sales history.</p>
                </div>
                <div className="header-actions">
                    <button 
                        onClick={() => setShowModal(true)}
                        className="btn" 
                        style={{ backgroundColor: 'var(--accent-mint)', color: '#064e3b' }}
                    >
                        + New Sale
                    </button>
                </div>
            </div>

            <div className="card p-6">
                <div className="table-responsive">
                    <table className="modern-table">
                        <thead>
                            <tr>
                                <th style={{ width: '35%' }}>PRODUCT</th>
                                <th style={{ width: '15%' }}>QUANTITY</th>
                                <th style={{ width: '20%' }}>TOTAL PRICE</th>
                                <th style={{ width: '20%' }}>DATE</th>
                                <th style={{ width: '10%', textAlign: 'right', paddingRight: '20px' }}>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            {sales.map((sale) => (
                                <tr key={sale.id}>
                                    <td>
                                        <div className="product-info-cell">
                                            <span className="dot" style={{ backgroundColor: '#4ade80' }}></span>
                                            <span className="font-bold">
                                                {sale.product ? sale.product.name : 'Deleted Product'}
                                            </span>
                                        </div>
                                    </td>
                                    <td className="text-muted">{sale.quantity} units</td>
                                    <td className="font-bold">
                                        ₦{Number(sale.total_price).toLocaleString()}
                                    </td>
                                    <td>
                                        <span className="text-muted">
                                            {new Date(sale.created_at).toLocaleString('en-GB', {
                                                day: '2-digit', month: 'short', year: 'numeric',
                                                hour: '2-digit', minute: '2-digit', hour12: true
                                            }).replace(',', '')}
                                        </span>
                                    </td>
                                    <td style={{ textAlign: 'right', paddingRight: '20px' }}>
                                        <span className="trend-indicator up">Completed</span>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>

            {sales.length === 0 && (
                <div className="text-center mt-10">
                    <p className="text-muted">No sales transactions found.</p>
                </div>
            )}
        </AuthenticatedLayout>
    );
}