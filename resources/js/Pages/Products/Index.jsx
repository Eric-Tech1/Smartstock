import React, { useState } from 'react';
import { Link, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import CreateProductForm from './Create'; // Import your new form component

export default function Index({ products = [] }) {
    const [showModal, setShowModal] = useState(false); // State to control the pop-up
    const { delete: destroy } = useForm();

    const handleDelete = (id) => {
        if (confirm('Delete this product?')) {
            destroy(route('products.destroy', id));
        }
    };

    return (
        <AuthenticatedLayout>
            <div className="inventory-container" style={{ padding: '2rem', position: 'relative' }}>
                
                {/* --- MODAL OVERLAY --- */}
                {showModal && (
                    <div style={{
                        position: 'fixed', 
                        top: 0, 
                        left: 0, 
                        width: '100%', 
                        height: '100%',
                        backgroundColor: 'rgba(0, 0, 0, 0.5)', 
                        backdropFilter: 'blur(4px)',
                        display: 'flex', 
                        alignItems: 'center', 
                        justifyContent: 'center', 
                        zIndex: 1000
                    }}>
                        <div style={{ 
                            background: 'white', 
                            padding: '10px', 
                            borderRadius: '24px', 
                            width: '600px', 
                            maxWidth: '95%',
                            maxHeight: '90vh',
                            overflowY: 'auto',
                            boxShadow: '0 25px 50px -12px rgba(0, 0, 0, 0.25)'
                        }}>
                            {/* The Form Component */}
                            <CreateProductForm onClose={() => setShowModal(false)} />
                        </div>
                    </div>
                )}

                <div className="dashboard-header" style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '2rem' }}>
                    <div>
                        <h1 className="page-title" style={{ fontSize: '1.8rem', fontWeight: '700', color: '#1e293b', margin: 0 }}>
                            Inventory Management
                        </h1>
                        <p className="page-subtitle" style={{ color: '#64748b', marginTop: '4px' }}>
                            Manage all your products, stock levels, and pricing.
                        </p>
                    </div>
                    <div className="header-actions">
                        {/* CHANGED: Link is now a button that toggles showModal */}
                        <button 
                            onClick={() => setShowModal(true)} 
                            className="btn" 
                            style={{ 
                                backgroundColor: '#ecfdf5', 
                                color: '#064e3b', 
                                padding: '10px 20px', 
                                borderRadius: '12px', 
                                fontWeight: '600', 
                                border: 'none',
                                cursor: 'pointer',
                                display: 'inline-block' 
                            }}
                        >
                            + Add New Product
                        </button>
                    </div>
                </div>

                <div className="card" style={{ background: 'white', borderRadius: '16px', padding: '24px', boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1)' }}>
                    <div className="table-responsive" style={{ overflowX: 'auto' }}>
                        <table className="modern-table" style={{ width: '100%', borderCollapse: 'collapse' }}>
                            <thead>
                                <tr style={{ textAlign: 'left', color: '#64748b', fontSize: '0.85rem', borderBottom: '1px solid #f1f5f9' }}>
                                    <th style={{ width: '35%', padding: '12px' }}>PRODUCT DETAILS</th>
                                    <th style={{ width: '15%' }}>SKU</th>
                                    <th style={{ width: '15%' }}>PRICE</th>
                                    <th style={{ width: '15%' }}>STOCK LEVEL</th>
                                    <th style={{ width: '20%', textAlign: 'right', paddingRight: '20px' }}>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                {products.length > 0 ? (
                                    products.map((product) => (
                                        <tr key={product.id} style={{ borderBottom: '1px solid #f8fafc' }}>
                                            <td style={{ padding: '16px 12px' }}>
                                                <div className="product-info-cell" style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                                                    <span 
                                                        className="dot" 
                                                        style={{ 
                                                            height: '8px', 
                                                            width: '8px', 
                                                            borderRadius: '50%',
                                                            backgroundColor: product.stock_quantity < 10 ? '#ef4444' : '#4ade80' 
                                                        }}
                                                    ></span>
                                                    <span style={{ fontWeight: '700', color: '#1e293b' }}>{product.name}</span>
                                                </div>
                                            </td>
                                            <td style={{ color: '#64748b' }}>{product.sku}</td>
                                            <td style={{ fontWeight: '700' }}>
                                                ₦{Number(product.price).toLocaleString()}
                                            </td>
                                            <td>
                                                <span 
                                                    style={{ 
                                                        color: product.stock_quantity < 10 ? '#ef4444' : '#22c55e',
                                                        fontWeight: '600', 
                                                        fontSize: '0.9rem'
                                                    }}
                                                >
                                                    {product.stock_quantity} in stock
                                                </span>
                                            </td>
                                            <td style={{ textAlign: 'right', paddingRight: '20px' }}>
                                                <div style={{ display: 'flex', justifyContent: 'flex-end', alignItems: 'center', gap: '8px' }}>
                                                    <Link 
                                                        href={route('products.edit', product.id)} 
                                                        style={{ 
                                                            padding: '6px 16px', 
                                                            fontSize: '0.85rem', 
                                                            borderRadius: '8px', 
                                                            background: '#f1f5f9', 
                                                            color: '#475569', 
                                                            textDecoration: 'none',
                                                            fontWeight: '600'
                                                        }}
                                                    >
                                                        Edit
                                                    </Link>
                                                    <button 
                                                        onClick={() => handleDelete(product.id)}
                                                        style={{ 
                                                            background: '#fee2e2', 
                                                            color: '#b91c1c', 
                                                            padding: '6px 16px', 
                                                            fontSize: '0.85rem', 
                                                            borderRadius: '8px', 
                                                            border: 'none', 
                                                            cursor: 'pointer',
                                                            fontWeight: '600'
                                                        }}
                                                    >
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan="5" style={{ textAlign: 'center', padding: '40px', color: '#64748b' }}>
                                            No products found in the system.
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}