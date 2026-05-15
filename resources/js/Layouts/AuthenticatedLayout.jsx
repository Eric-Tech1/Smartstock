import React from 'react';
import { Link, usePage, router } from '@inertiajs/react';

export default function AuthenticatedLayout({ children }) {
    const { auth, lowStockCount } = usePage().props;
    const { url } = usePage();

    const userInitial = auth.user?.name ? auth.user.name.substring(0, 1) : 'A';

    const handleLogout = (e) => {
        e.preventDefault();
        
        // confirm() prevents accidental logouts
        if (confirm('Are you sure you want to log out?')) {
            router.post(route('logout'), {}, {
                // onFinish is the key: it executes after the request completes,
                // allowing us to force a hard browser redirect to /login.
                onFinish: () => {
                    window.location.href = '/login';
                }
            });
        }
    };

    return (
        <div className="app-container">
            {/* --- SIDEBAR --- */}
            <aside className="sidebar">
                <div className="sidebar-top">
                    <div className="logo-section">
                        <div className="logo-box"></div>
                        <span className="logo-text">SmartStock</span>
                    </div>

                    <nav className="nav-menu">
                        <Link 
                            href="/dashboard" 
                            className={`nav-item ${url.startsWith('/dashboard') || url.startsWith('/admin/dashboard') ? 'active' : ''}`}
                        >
                            📊 Dashboard
                        </Link>
                        <Link 
                            href="/products" 
                            className={`nav-item ${url.startsWith('/products') ? 'active' : ''}`}
                        >
                            📦 Products
                        </Link>
                        <Link 
                            href="/sales" 
                            className={`nav-item ${url.startsWith('/sales') ? 'active' : ''}`}
                        >
                            💰 Sales
                        </Link>
                        <Link 
                            href="/reports/sales" 
                            className={`nav-item ${url.startsWith('/reports') ? 'active' : ''}`}
                        >
                            📄 Reports
                        </Link>
                    </nav>
                </div>

                <div className="sidebar-bottom">
                    <button 
                        onClick={handleLogout}
                        className="logout-btn" 
                        style={{ 
                            color: '#ef4444', 
                            border: 'none', 
                            background: 'none', 
                            padding: '10px 20px',
                            textAlign: 'left',
                            width: '100%',
                            cursor: 'pointer', 
                            fontFamily: 'inherit', 
                            fontWeight: '500' 
                        }}
                    >
                        Logout
                    </button>
                </div>
            </aside>

            {/* --- MAIN CONTENT --- */}
            <main className="main-content">
                <header className="top-header" style={{ display: 'flex', justifyContent: 'flex-end', alignItems: 'center', padding: '24px 40px', gap: '25px' }}>
                    
                    {lowStockCount > 0 && (
                        <Link 
                            href="/products?filter=low_stock"
                            className="notification-wrapper" 
                            style={{ position: 'relative', cursor: 'pointer', textDecoration: 'none' }}
                        >
                            <span style={{ fontSize: '1.4rem', color: '#64748b' }}>🔔</span>
                            <span className="pulse-badge" style={{
                                position: 'absolute', 
                                top: '-2px', 
                                right: '-2px', 
                                background: '#ef4444', 
                                color: 'white', 
                                borderRadius: '50%', 
                                minWidth: '18px', 
                                height: '18px', 
                                display: 'flex', 
                                alignItems: 'center', 
                                justifyContent: 'center', 
                                fontSize: '0.65rem', 
                                fontWeight: '800', 
                                border: '2px solid #fff'
                            }}>
                                {lowStockCount}
                            </span>
                        </Link>
                    )}

                    <div className="user-profile" style={{ display: 'flex', alignItems: 'center', gap: '12px', borderLeft: '1px solid #e2e8f0', paddingLeft: '20px' }}>
                        <div className="user-info" style={{ textAlign: 'right' }}>
                            <span className="user-name" style={{ display: 'block', fontWeight: '700', color: '#1e293b', fontSize: '0.95rem' }}>
                                {auth.user?.name || 'Admin User'}
                            </span>
                            <span className="user-role" style={{ display: 'block', fontSize: '0.75rem', color: '#64748b', fontWeight: '600', textTransform: 'uppercase' }}>
                                {auth.user?.role || 'Manager'}
                            </span>
                        </div>
                        <div className="avatar" style={{ width: '40px', height: '40px', background: '#ecfdf5', borderRadius: '12px', display: 'flex', alignItems: 'center', justifyContent: 'center', fontWeight: 'bold', color: '#064e3b' }}>
                            {userInitial}
                        </div>
                    </div>
                </header>

                <section className="content-wrapper">
                    {children}
                </section>
            </main>

            <style>{`
                @keyframes pulse-red {
                    0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
                    70% { box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
                    100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
                }
                .pulse-badge { animation: pulse-red 2s infinite; }
                .logout-btn:hover { background-color: #fef2f2 !important; border-radius: 8px; }
            `}</style>
        </div>
    );
}