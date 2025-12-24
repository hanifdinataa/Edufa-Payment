{{-- resources/views/payment/pay.blade.php --}}
@extends('layouts.frontend.app')

@section('content')

<div class="pay-bg">
    <div class="pay-overlay"></div>

    <div class="pay-wrapper">
        <div class="pay-card">

            <div class="card-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                    <line x1="1" y1="10" x2="23" y2="10"></line>
                </svg>
            </div>

            <h2 class="title">Lanjutkan Pembayaran</h2>

            <p class="subtitle">
                Anda akan diarahkan ke halaman pembayaran yang aman untuk melanjutkan transaksi.
            </p>

            <button id="pay-button" class="btn-pay">
                <span>Lanjutkan ke Pembayaran</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </button>

            {{-- <div class="secure-info">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <span>Pembayaran dilindungi enkripsi SSL</span>
            </div> --}}

        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Auto open Snap (BEST PRACTICE)
    window.snap.pay('{{ $snapToken }}', {
        onSuccess: function () {
            window.location.href = "{{ route('payment.show', $invoice->invoice_code) }}";
        },
        onPending: function () {
            window.location.href = "{{ route('payment.show', $invoice->invoice_code) }}";
        },
        onError: function () {
            alert('Terjadi kesalahan pembayaran. Silakan coba kembali.');
            window.location.href = "{{ route('payment.show', $invoice->invoice_code) }}";
        },
        onClose: function () {
            window.location.href = "{{ route('payment.show', $invoice->invoice_code) }}";
        }
    });

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
    padding: 40px 32px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    text-align: center;
    opacity: 0;
}

.card-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 24px;
    background: linear-gradient(135deg, #800000, #a00000);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(128, 0, 0, 0.25);
}

.card-icon svg {
    color: white;
}

.title {
    font-size: 24px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 12px;
    letter-spacing: -0.4px;
}

.subtitle {
    font-size: 15px;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 32px;
    max-width: 340px;
    margin-left: auto;
    margin-right: auto;
}

.btn-pay {
    width: 100%;
    padding: 16px 24px;
    border: none;
    border-radius: 12px;
    background: #800000;
    color: #ffffff;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.25s ease;
    box-shadow: 0 6px 20px rgba(128, 0, 0, 0.2);
    font-family: inherit;
    margin-bottom: 20px;
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

.secure-info {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 20px;
    background: #f8fafc;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
}

.secure-info svg {
    color: #64748b;
    flex-shrink: 0;
}

.secure-info span {
    font-size: 13px;
    color: #64748b;
    font-weight: 500;
}

/* Responsiveness */
@media (max-width: 480px) {
    .pay-wrapper {
        padding: 16px;
    }

    .pay-card {
        padding: 32px 24px;
        border-radius: 16px;
    }

    .card-icon {
        width: 72px;
        height: 72px;
        margin-bottom: 20px;
    }

    .card-icon svg {
        width: 40px;
        height: 40px;
    }

    .title {
        font-size: 22px;
    }

    .subtitle {
        font-size: 14px;
        margin-bottom: 28px;
    }

    .btn-pay {
        padding: 15px 20px;
        font-size: 15px;
    }

    .secure-info {
        flex-direction: column;
        gap: 6px;
        padding: 14px;
    }

    .secure-info span {
        font-size: 12px;
    }
}
</style>

@endsection