import React, { useEffect, useRef } from 'react';
import { Head, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

export default function Dashboard({ 
    auth, 
    stats, 
    bestProduct, 
    topProducts, 
    salesData,
    lowStockProducts,
    setSelectedProduct 
}) {
    const chartRef = useRef(null);
    const { totalRevenue, totalSales, revenueChange, lowStock } = stats || {};

    useEffect(() => {
        if (chartRef.current) {
            const chartInstance = new Chart(chartRef.current, {
                type: 'line',
                data: {
                    labels: salesData.map(d => d.date),
                    datasets: [{
                        label: 'Revenue',
                        data: salesData.map(d => d.total),
                        borderColor: '#4ade80',
                        backgroundColor: 'rgba(74, 222, 128, 0.05)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#4ade80',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            titleFont: { size: 14, family: 'Plus Jakarta Sans' },
                            bodyFont: { family: 'Plus Jakarta Sans' },
                            callbacks: {
                                label: (context) => ` ₦${context.parsed.y.toLocaleString()}`
                            }
                        }
                    },
                    scales: {
                        x: { 
                            grid: { display: false },
                            ticks: { color: '#94a3b8', font: { family: 'Plus Jakarta Sans', size: 10 } }
                        },
                        y: { 
                            border: { dash: [4, 4] },
                            grid: { color: '#f1f5f9' },
                            ticks: { 
                                color: '#94a3b8',
                                font: { family: 'Plus Jakarta Sans', size: 10 },
                                callback: (value) => `₦${value.toLocaleString()}`
                            }
                        }
                    }
                }
            });

            return () => chartInstance.destroy();
        }
    }, [salesData]);

    return (
        <AuthenticatedLayout auth={auth}>
            <Head title="Analytics Overview" />

            {/* Header Section */}
            <div className="dashboard-header">
                <div>
                    <h1 className="page-title">Analytics Overview</h1>
                    <p className="page-subtitle">Real-time monitoring of revenue, sales, and inventory health.</p>
                </div>
                <div className="header-actions">
                    <span className="date-display">
                        {new Date().toLocaleDateString('en-GB', { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' })}
                    </span>
                </div>
            </div>

            {/* Stats Cards Row */}
            <div className="stats-container mb-10">
                <div className="card stat-card-alt">
                    <div className="card-header-inline">
                        <span className="icon-label blue">₦</span>
                        <h3 className="block-title">Revenue</h3>
                    </div>
                    <div className="card-body-main">
                        <h2 className="main-value">₦{Number(totalRevenue || 0).toLocaleString()}</h2>
                        <div className={`trend-indicator ${revenueChange >= 0 ? 'up' : 'down'}`}>
                            <span className="trend-icon">{revenueChange >= 0 ? '▲' : '▼'}</span>
                            <span className="trend-text">{Math.abs(revenueChange || 0).toFixed(1)}% vs yesterday</span>
                        </div>
                    </div>
                </div>

                <div className="card stat-card-alt">
                    <div className="card-header-inline">
                        <span className="icon-label green">📊</span>
                        <h3 className="block-title">Total Sales</h3>
                    </div>
                    <div className="card-body-main">
                        <h2 className="main-value">{Number(totalSales || 0).toLocaleString()}</h2>
                        <p className="sub-label">Completed Transactions</p>
                    </div>
                </div>

                <div 
                    className="card stat-card-alt" 
                    onClick={() => router.get('/products?filter=low_stock')}
                    style={{ cursor: 'pointer' }}
                >
                    <div className="card-header-inline">
                        <span className="icon-label orange">📦</span>
                        <h3 className="block-title">Inventory</h3>
                    </div>
                    <div className="card-body-main">
                        <h2 className={`main-value ${lowStock > 0 ? 'text-red' : ''}`}>
                            {lowStock ?? 0}
                        </h2>
                        <p className="sub-label">Critical Threshold Alerts</p>
                    </div>
                </div>

                <div className="card stat-card-alt">
                    <div className="card-header-inline">
                        <span className="icon-label purple">⭐</span>
                        <h3 className="block-title">Top Product</h3>
                    </div>
                    <div className="card-body-main">
                        <h2 className="main-value small" style={{ fontSize: '1.1rem', lineHeight: '1.2' }}>
                            {bestProduct?.name || 'N/A'}
                        </h2>
                        <p className="sub-label">Highest Volume Seller</p>
                    </div>
                </div>
            </div>

            <div className="grid-2-cols mb-10">
                <div className="card p-0 overflow-hidden">
                    <div className="p-6 flex-between">
                        <h3 className="block-title">Revenue Performance</h3>
                        <span className="text-muted" style={{ fontSize: '0.8rem' }}>Last 7 Days</span>
                    </div>
                    <div className="chart-wrapper" style={{ height: '300px', padding: '0 20px 20px' }}>
                        <canvas ref={chartRef}></canvas>
                    </div>
                </div>

                <div className="card">
                    <h3 className="block-title mb-6">Top Performers</h3>
                    <div className="table-responsive">
                        <table className="modern-table">
                            <thead>
                                <tr>
                                    <th>PRODUCT</th>
                                    <th className="text-right">UNITS SOLD</th>
                                </tr>
                            </thead>
                            <tbody>
                                {topProducts.map((product) => (
                                    <tr 
                                        key={product.id} 
                                        onClick={() => setSelectedProduct(product)} 
                                        style={{ cursor: 'pointer' }}
                                    >
                                        <td>
                                            <div className="product-info-cell">
                                                <span className="dot" style={{ backgroundColor: '#4ade80' }}></span>
                                                <span className="font-bold">{product.name}</span>
                                            </div>
                                        </td>
                                        <td className="text-right font-bold" style={{ color: '#4ade80' }}>
                                            {product.sales_sum_quantity || 0}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {/* Low Stock Section */}
            {lowStockProducts?.length > 0 && (
                <div className="alert-section">
                    <div className="card" style={{ border: '1px solid #fee2e2', backgroundColor: '#fffafb' }}>
                        <div className="flex-between mb-4" style={{ borderBottom: '1px solid #fee2e2', paddingBottom: '15px' }}>
                            <h3 className="block-title" style={{ color: '#b91c1c' }}>⚠️ Critical Stock Alerts</h3>
                            <span className="badge red" style={{ background: '#ef4444', color: 'white', padding: '4px 12px', borderRadius: '20px', fontSize: '0.75rem' }}>
                                {lowStockProducts.length} Items Require Attention
                            </span>
                        </div>
                        <div className="alert-grid" style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(280px, 1fr))', gap: '15px' }}>
                            {lowStockProducts.map((product) => (
                                <div 
                                    key={product.id} 
                                    className="alert-item-minimal" 
                                    onClick={() => setSelectedProduct(product)}
                                    style={{ display: 'flex', alignItems: 'center', gap: '10px', padding: '10px', background: 'white', borderRadius: '10px', border: '1px solid #fecaca', cursor: 'pointer' }}
                                >
                                    <span className="alert-dot" style={{ height: '8px', width: '8px', background: '#ef4444', borderRadius: '50%', display: 'inline-block' }}></span>
                                    <span className="alert-text" style={{ fontSize: '0.85rem', color: '#1e293b' }}>
                                        <strong style={{ fontWeight: '700' }}>{product.name}</strong> is at <span style={{ color: '#ef4444', fontWeight: '700' }}>{product.stock_quantity}</span> units.
                                    </span>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            )}

            <style>{`
                /* Ensure Font Consistency */
                .page-title, .block-title, .main-value, .font-bold, strong {
                    font-family: 'Plus Jakarta Sans', sans-serif !important;
                }
                
                .page-title { font-weight: 800; letter-spacing: -0.02em; }
                .block-title { font-weight: 700; font-size: 1.1rem; color: #1e293b; }
                .main-value { font-weight: 800; letter-spacing: -0.03em; }
                
                .modern-table th {
                    font-size: 0.75rem;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                    font-weight: 700;
                    color: #64748b;
                }

                @keyframes pulse-red {
                    0% { transform: scale(1); opacity: 1; }
                    50% { transform: scale(1.2); opacity: 0.7; }
                    100% { transform: scale(1); opacity: 1; }
                }
                .alert-dot { animation: pulse-red 2s infinite; }
                .text-red { color: #ef4444 !important; }
            `}</style>
        </AuthenticatedLayout>
    );
}