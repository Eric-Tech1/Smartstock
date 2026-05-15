import React from 'react';
import { Head } from '@inertiajs/react';

export default function Dashboard({ auth, totalRevenue, totalSales }) {
    return (
        <div className="app-container">
            <Head title="Dashboard" />
            
            <aside className="sidebar">
                {/* Your sidebar logic here */}
                <div className="logo-text">SmartStock</div>
            </aside>

            <main className="main-content">
                <header className="top-header">
                    <h1>Hi, {auth.user.name}</h1>
                </header>

                <div className="stats-container">
                    <div className="card">
                        <h3>Revenue</h3>
                        <h2>₦{totalRevenue.toLocaleString()}</h2>
                    </div>
                </div>
            </main>
        </div>
    );
}