{{-- resources/views/payment/not-found.blade.php --}}
@extends('layouts.frontend.app')

@section('content')

<div class="pay-bg">
    <div class="pay-overlay"></div>

    <div class="pay-wrapper">
        <div class="pay-card">

            <div class="card-header">
                <div class="icon-wrapper">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
                <h2 class="title">Invoice Tidak Ditemukan</h2>
                <p class="subtitle">Link tagihan tidak valid atau sudah tidak tersedia</p>
            </div>

            <div class="invoice-box">

                <div class="paid-info not-found">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M8 12h8"></path>
                    </svg>

                    <p class="paid-title">404 - Data Tidak Ditemukan</p>
                    <p class="paid-desc">
                        Invoice yang Anda akses tidak tersedia, mungkin sudah dihapus
                        atau link yang digunakan salah.
                    </p>
                </div>

                {{-- <a href="/" class="btn-pay btn-secondary">
                    <span>Kembali ke Beranda</span>
                </a> --}}

            </div>

        </div>
    </div>
</div>

<!-- Anime.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

<script>
anime({
    targets: '.pay-card',
    opacity: [0, 1],
    translateY: [30, 0],
    duration: 600,
    easing: 'easeOutQuad'
});
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

/* === SAME BASE STYLE === */

.pay-bg {
    min-height: 100vh;
    background: url("{{ asset('background.png') }}") center/cover no-repeat;
    position: relative;
}

.pay-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(128, 0, 0, 0.65), rgba(0, 0, 0, 0.7));
}

.pay-wrapper {
    position: relative;
    z-index: 2;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.pay-card {
    width: 100%;
    max-width: 420px;
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    opacity: 0;
}

.card-header {
    background: linear-gradient(135deg, #800000, #a00000);
    padding: 32px 24px;
    text-align: center;
    color: #fff;
}

.icon-wrapper {
    width: 56px;
    height: 56px;
    margin: 0 auto 16px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.title {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 6px;
}

.subtitle {
    font-size: 13px;
    opacity: 0.9;
}

.invoice-box {
    padding: 28px 24px;
}

.paid-info {
    text-align: center;
    padding: 28px 20px;
    background: #fef2f2;
    border-radius: 14px;
    border: 1px solid #fecaca;
    margin-bottom: 24px;
}

.paid-info svg {
    color: #dc2626;
    margin-bottom: 12px;
}

.paid-title {
    font-size: 16px;
    font-weight: 700;
    color: #991b1b;
    margin-bottom: 6px;
}

.paid-desc {
    font-size: 14px;
    color: #7f1d1d;
    line-height: 1.5;
}

/* BUTTON */
.btn-pay {
    width: 100%;
    padding: 16px;
    border-radius: 12px;
    border: none;
    text-align: center;
    background: #800000;
    color: #fff;
    font-weight: 700;
    text-decoration: none;
    display: block;
    transition: 0.2s ease;
}

.btn-pay:hover {
    background: #a00000;
}

.btn-secondary {
    background: #374151;
}

.btn-secondary:hover {
    background: #1f2937;
}

/* Responsive */
@media (max-width: 480px) {
    .pay-card {
        border-radius: 16px;
    }
}
</style>

@endsection
