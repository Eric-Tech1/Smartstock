import React from 'react';
import { useForm } from '@inertiajs/react';

export default function Create({ products = [], onClose }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        product_id: '',
        quantity: '',
        customer_name: '',
        customer_phone: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('sales.store'), {
            onSuccess: () => {
                reset();
                if (onClose) onClose();
            },
        });
    };

    return (
        <div>
            <div className="dashboard-header" style={{ marginBottom: '30px' }}>
                <div>
                    <h1 className="page-title" style={{ fontSize: '1.5rem' }}>New Sales Transaction</h1>
                    <p className="page-subtitle">Enter product details and customer information.</p>
                </div>
            </div>

            <form onSubmit={submit} id="salesForm">
                <div style={{ display: 'grid', gridTemplateColumns: '1fr', gap: '24px' }}>
                    
                    <div className="card p-8 shadow-sm" style={{ border: '1px solid #f1f5f9' }}>
                        <h3 style={{ marginBottom: '20px', fontSize: '1.1rem', color: '#1e293b', borderBottom: '1px solid #f1f5f9', paddingBottom: '10px' }}>Item Details</h3>
                        
                        <div style={{ marginBottom: '20px' }}>
                            {/* Fixed letterSpacing below */}
                            <label style={{ display: 'block', fontWeight: '600', color: '#64748b', marginBottom: '8px', fontSize: '0.75rem', letterSpacing: '0.05em' }}>SELECT PRODUCT</label>
                            <select 
                                value={data.product_id}
                                onChange={e => setData('product_id', e.target.value)}
                                required 
                                style={{ width: '100%', padding: '12px', borderRadius: '10px', border: '1px solid #e2e8f0', fontFamily: 'inherit' }}
                            >
                                <option value="" disabled>Search inventory...</option>
                                {products.map((product) => (
                                    <option key={product.id} value={product.id}>
                                        {product.name} — ₦{Number(product.price).toLocaleString()} (Stock: {product.stock_quantity})
                                    </option>
                                ))}
                            </select>
                            {errors.product_id && <div style={{ color: '#ef4444', fontSize: '0.75rem', marginTop: '4px' }}>{errors.product_id}</div>}
                        </div>

                        <div style={{ marginBottom: '20px' }}>
                            {/* Fixed letterSpacing below */}
                            <label style={{ display: 'block', fontWeight: '600', color: '#64748b', marginBottom: '8px', fontSize: '0.75rem', letterSpacing: '0.05em' }}>QUANTITY</label>
                            <input 
                                type="number" 
                                value={data.quantity}
                                onChange={e => setData('quantity', e.target.value)}
                                min="1" 
                                required 
                                placeholder="0" 
                                style={{ width: '100%', padding: '12px', borderRadius: '10px', border: '1px solid #e2e8f0' }} 
                            />
                            {errors.quantity && <div style={{ color: '#ef4444', fontSize: '0.75rem', marginTop: '4px' }}>{errors.quantity}</div>}
                        </div>
                    </div>

                    <div className="card p-8" style={{ backgroundColor: '#f8fafc', border: '1px solid #e2e8f0' }}>
                        <h3 style={{ marginBottom: '20px', fontSize: '1.1rem', color: '#1e293b', borderBottom: '1px solid #e2e8f0', paddingBottom: '10px' }}>Customer Info</h3>
                        
                        <div style={{ marginBottom: '15px' }}>
                            <label style={{ display: 'block', fontWeight: '600', color: '#64748b', marginBottom: '5px', fontSize: '0.75rem' }}>NAME</label>
                            <input 
                                type="text" 
                                value={data.customer_name}
                                onChange={e => setData('customer_name', e.target.value)}
                                placeholder="Optional" 
                                style={{ width: '100%', padding: '10px', borderRadius: '8px', border: '1px solid #cbd5e1' }} 
                            />
                        </div>

                        <div style={{ marginBottom: '15px' }}>
                            <label style={{ display: 'block', fontWeight: '600', color: '#64748b', marginBottom: '5px', fontSize: '0.75rem' }}>PHONE NUMBER</label>
                            <input 
                                type="text" 
                                value={data.customer_phone}
                                onChange={e => setData('customer_phone', e.target.value)}
                                placeholder="Optional" 
                                style={{ width: '100%', padding: '10px', borderRadius: '8px', border: '1px solid #cbd5e1' }} 
                            />
                        </div>

                        <div style={{ marginTop: '30px' }}>
                            <button 
                                type="submit" 
                                disabled={processing}
                                className="btn" 
                                style={{ width: '100%', backgroundColor: 'var(--accent-mint)', color: '#064e3b', fontWeight: '700', padding: '14px', border: 'none', borderRadius: '12px', cursor: 'pointer', opacity: processing ? 0.7 : 1 }}
                            >
                                {processing ? 'PROCESSING...' : 'COMPLETE SALE & PRINT'}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    );
}