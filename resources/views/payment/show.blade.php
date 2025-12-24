{{-- resources/views/payment/show.blade.php --}}
@extends('layouts.frontend.app')

@section('content')

<div class="pay-bg">
    <div class="pay-overlay"></div>

    <div class="pay-wrapper">
        <div class="pay-card">

            <div class="card-header">
                <div class="icon-wrapper">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <h2 class="title">Detail Tagihan</h2>
                <p class="subtitle">Informasi pembayaran periode berjalan</p>
            </div>

            <div class="invoice-box">
                <div class="info-section">
                    <div class="info-row">
                        <span class="label">Nama Siswa</span>
                        <strong class="value">{{ $invoice->siswa->nama_anak }}</strong>
                    </div>

                    <div class="info-row">
                        <span class="label">Periode Tagihan</span>
                        <strong class="value">{{ $invoice->periode }}</strong>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="total-section">
                    <span class="total-label">Total Pembayaran</span>
                    <h3 class="total-amount">Rp {{ number_format($invoice->nominal, 0, ',', '.') }}</h3>
                </div>

                <div class="status-section">
                    @if ($invoice->status === 'PAID')
                        <span class="badge badge-paid">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Lunas
                        </span>
                    @elseif ($invoice->status === 'PENDING')
                        <span class="badge badge-pending">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            Menunggu Pembayaran
                        </span>
                    @elseif ($invoice->status === 'UNPAID')
                        <span class="badge badge-unpaid">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                            Belum Dibayar
                        </span>
                    @else
                        <span class="badge badge-expired">{{ $invoice->status }}</span>
                    @endif
                </div>

                @if (in_array($invoice->status, ['UNPAID', 'PENDING']))
                    <form method="POST" action="{{ route('payment.pay', $invoice->invoice_code) }}">
                        @csrf
                        <button class="btn-pay" type="submit">
                            <span>Bayar Sekarang</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </button>
                    </form>
                @else
                    <div class="paid-info">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <p class="paid-title">Pembayaran Berhasil</p>
                        <p class="paid-desc">Terima kasih atas kepercayaan Anda kepada Edufa.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<!-- Anime.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

<script>
// Animasi card masuk
anime({
    targets: '.pay-card',
    opacity: [0, 1],
    translateY: [30, 0],
    duration: 600,
    easing: 'easeOutQuad'
});

// Animasi subtle untuk tombol bayar
const payButton = document.querySelector('.btn-pay');
if (payButton) {
    payButton.addEventListener('mouseenter', function() {
        anime({
            targets: this,
            translateY: -2,
            boxShadow: '0 8px 24px rgba(128, 0, 0, 0.25)',
            duration: 200,
            easing: 'easeOutQuad'
        });
    });
    
    payButton.addEventListener('mouseleave', function() {
        anime({
            targets: this,
            translateY: 0,
            boxShadow: '0 4px 12px rgba(128, 0, 0, 0.15)',
            duration: 200,
            easing: 'easeOutQuad'
        });
    });
}
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
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.pay-bg {
    min-height: 100vh;
    background: url("{{ asset('background.png') }}") center/cover no-repeat;
    position: relative;
}

.pay-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(128, 0, 0, 0.65), rgba(0, 0, 0, 0.7));
    backdrop-filter: blur(2px);
}

.pay-wrapper {
    position: relative;
    z-index: 2;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.pay-card {
    width: 100%;
    max-width: 420px;
    background: #ffffff;
    border-radius: 20px;
    padding: 0;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    opacity: 0;
}

.card-header {
    background: linear-gradient(135deg, #800000, #a00000);
    padding: 32px 24px;
    text-align: center;
    color: white;
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
    backdrop-filter: blur(10px);
}

.icon-wrapper svg {
    color: white;
}

.title {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 6px;
    letter-spacing: -0.3px;
}

.subtitle {
    font-size: 13px;
    opacity: 0.9;
    font-weight: 400;
}

.invoice-box {
    padding: 28px 24px;
}

.info-section {
    margin-bottom: 20px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
    gap: 16px;
}

.info-row:last-child {
    margin-bottom: 0;
}

.label {
    font-size: 14px;
    color: #64748b;
    font-weight: 500;
    flex-shrink: 0;
}

.value {
    font-size: 14px;
    color: #0f172a;
    font-weight: 600;
    text-align: right;
}

.divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
    margin: 24px 0;
}

.total-section {
    text-align: center;
    padding: 20px;
    background: #f8fafc;
    border-radius: 14px;
    margin-bottom: 20px;
}

.total-label {
    display: block;
    font-size: 13px;
    color: #64748b;
    font-weight: 500;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.total-amount {
    font-size: 28px;
    font-weight: 700;
    color: #800000;
    letter-spacing: -0.5px;
}

.status-section {
    text-align: center;
    margin-bottom: 24px;
}

.badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 600;
    text-transform: capitalize;
    letter-spacing: 0.3px;
}

.badge svg {
    flex-shrink: 0;
}

.badge-paid {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.badge-unpaid {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.badge-pending {
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #fde68a;
}

.badge-expired {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
}

.btn-pay {
    width: 100%;
    padding: 16px 24px;
    border: none;
    border-radius: 12px;
    background: #800000;
    color: #ffffff;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(128, 0, 0, 0.15);
    font-family: inherit;
}

.btn-pay:hover {
    background: #a00000;
}

.btn-pay:active {
    transform: scale(0.98);
}

.btn-pay svg {
    flex-shrink: 0;
}

.paid-info {
    text-align: center;
    padding: 28px 20px;
    background: linear-gradient(135deg, #ecfdf5, #f0fdf4);
    border-radius: 14px;
    border: 1px solid #a7f3d0;
}

.paid-info svg {
    color: #059669;
    margin-bottom: 12px;
}

.paid-title {
    font-size: 16px;
    font-weight: 700;
    color: #065f46;
    margin-bottom: 6px;
}

.paid-desc {
    font-size: 14px;
    color: #047857;
    line-height: 1.5;
}

/* Responsiveness */
@media (max-width: 480px) {
    .pay-wrapper {
        padding: 16px;
    }

    .pay-card {
        border-radius: 16px;
    }

    .card-header {
        padding: 28px 20px;
    }

    .title {
        font-size: 20px;
    }

    .invoice-box {
        padding: 24px 20px;
    }

    .total-amount {
        font-size: 24px;
    }

    .info-row {
        flex-direction: column;
        gap: 4px;
        align-items: flex-start;
    }

    .value {
        text-align: left;
    }
}
</style>

@endsection