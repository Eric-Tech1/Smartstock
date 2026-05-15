import React from 'react';

export default function SlideOver({ isOpen, onClose, title, children }) {
    if (!isOpen) return null;

    return (
        <div style={{
            position: 'fixed',
            top: 0,
            right: 0,
            bottom: 0,
            left: 0,
            zIndex: 100,
            backgroundColor: 'rgba(0, 0, 0, 0.3)', // Dim the background
            display: 'flex',
            justifyContent: 'flex-end'
        }} onClick={onClose}>
            <div 
                style={{
                    width: '80%', // Takes up most of the screen
                    maxWidth: '1000px',
                    height: '100%',
                    backgroundColor: 'white',
                    boxShadow: '-10px 0 30px rgba(0,0,0,0.1)',
                    padding: '40px',
                    overflowY: 'auto'
                }} 
                onClick={e => e.stopPropagation()} // Prevent closing when clicking inside
            >
                <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '30px' }}>
                    <h2>{title}</h2>
                    <button onClick={onClose} style={{ border: 'none', background: 'none', fontSize: '1.5rem', cursor: 'pointer' }}>&times;</button>
                </div>
                {children}
            </div>
        </div>
    );
}