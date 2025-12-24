{{-- resources/views/admin/invoice/index.blade.php --}}
@extends('layouts.admin.app')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span>›</span>
        <strong>Invoice</strong>
    </div>

    <div class="page-header">
        <div>
            <h2 class="page-title">Data Invoice</h2>
        </div>

        <a href="{{ route('admin.invoice.create') }}" class="btn-add">
            <span class="btn-icon">+</span>
            Buat Invoice
        </a>
    </div>

    @if (session('error'))
        <div class="alert alert-error">
            <span class="alert-icon">⚠️</span>
            <div class="alert-content">
                <div class="alert-title">Error</div>
                <div class="alert-message">{{ session('error') }}</div>
            </div>
            <button class="alert-close" onclick="this.parentElement.remove()">✕</button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✓</span>
            <div class="alert-content">
                <div class="alert-title">Berhasil</div>
                <div class="alert-message">{{ session('success') }}</div>
            </div>
            <button class="alert-close" onclick="this.parentElement.remove()">✕</button>
        </div>
    @endif

    <div class="table-container">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Invoice Code</th>
                    <th>Siswa</th>
                    <th>Nominal</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                    <tr>
                        <td>
                            <span class="code-badge">{{ $invoice->invoice_code }}</span>
                        </td>
                        <td class="strong">{{ $invoice->siswa->nama_anak }}</td>
                        <td>Rp {{ number_format($invoice->nominal) }}</td>
                        <td>
                            <span class="type-badge {{ strtolower($invoice->tipe) }}">
                                {{ $invoice->tipe }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ strtolower($invoice->status) }}">
                                {{ $invoice->status }}
                            </span>
                        </td>
                        <td>
                            <div class="payment-info">
                                <span class="paid">Rp {{ number_format($invoice->total_paid) }}</span>
                                <span class="separator">/</span>
                                <span class="total">Rp {{ number_format($invoice->nominal) }}</span>
                            </div>
                        </td>
                        <td class="aksi">
                            <a href="{{ route('admin.invoice.edit', $invoice->id) }}" class="button-edit">
                                <svg viewBox="0 0 512 512" class="svgIcon">
                                    <path
                                        d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z">
                                    </path>
                                </svg>
                            </a>

                            @if ($invoice->status === 'UNPAID')
                                <form method="POST" action="{{ route('admin.invoice.destroy', $invoice->id) }}"
                                    style="display:inline;">
                                    @csrf @method('DELETE')
                                    {{-- <button class="button-delete" type="submit" onclick="return confirm('Yakin hapus invoice ini?')">
                                        <svg viewBox="0 0 448 512" class="svgIcon">
                                            <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                                        </svg>
                                    </button> --}}
                                    <button type="button" class="button-delete"
                                        onclick="openDeleteModal({{ $invoice->id }})">
                                        <svg viewBox="0 0 448 512" class="svgIcon">
                                            <path
                                                d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('admin.invoice.send-wa', $invoice->id) }}">
                                @csrf
                                <button type="submit" class="wa-btn">
                                    {{-- SVG WhatsApp --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="22"
                                        height="22">
                                        <path fill="currentColor"
                                            d="M16 .6C7.4.6.6 7.4.6 16c0 2.8.7 5.5 2.1 7.9L.2 31.4l7.7-2.5c2.3 1.2 5 1.9 7.9 1.9 8.6 0 15.4-6.8 15.4-15.4C31.4 7.4 24.6.6 16 .6zm0 28.2c-2.5 0-4.9-.7-7-1.9l-.5-.3-4.6 1.5 1.5-4.5-.3-.5c-1.3-2.1-2-4.5-2-7.1C3.1 8.6 8.6 3.1 16 3.1s12.9 5.5 12.9 12.9S23.4 28.8 16 28.8zm7.1-9.6c-.4-.2-2.3-1.1-2.7-1.2-.4-.1-.6-.2-.9.2-.2.4-1 1.2-1.2 1.4-.2.2-.4.3-.8.1s-1.6-.6-3.1-1.9c-1.1-1-1.9-2.2-2.1-2.6-.2-.4 0-.6.2-.8.2-.2.4-.4.6-.6.2-.2.2-.4.4-.6.1-.2 0-.4 0-.6s-.9-2.2-1.2-3c-.3-.8-.7-.7-.9-.7h-.8c-.2 0-.6.1-.9.4-.3.4-1.2 1.2-1.2 2.9s1.2 3.4 1.4 3.6c.2.2 2.4 3.7 5.9 5.2.8.3 1.4.5 1.9.6.8.3 1.5.3 2 .2.6-.1 2.3-.9 2.6-1.8.3-.9.3-1.7.2-1.8-.1-.2-.4-.3-.8-.5z" />
                                    </svg>
                                    <span>Kirim</span>
                                </button>
                            </form>


                            @if ($invoice->status === 'UNPAID')
                                @if ($invoice->status === 'UNPAID')
                                    <form method="POST" action="{{ route('admin.invoice.reminder', $invoice->id) }}">
                                        @csrf
                                        <button type="submit" class="wa-btn reminder">
                                            {{-- SVG WhatsApp --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="22"
                                                height="22">
                                                <path fill="currentColor"
                                                    d="M16 .6C7.4.6.6 7.4.6 16c0 2.8.7 5.5 2.1 7.9L.2 31.4l7.7-2.5c2.3 1.2 5 1.9 7.9 1.9 8.6 0 15.4-6.8 15.4-15.4C31.4 7.4 24.6.6 16 .6zm0 28.2c-2.5 0-4.9-.7-7-1.9l-.5-.3-4.6 1.5 1.5-4.5-.3-.5c-1.3-2.1-2-4.5-2-7.1C3.1 8.6 8.6 3.1 16 3.1s12.9 5.5 12.9 12.9S23.4 28.8 16 28.8zm7.1-9.6c-.4-.2-2.3-1.1-2.7-1.2-.4-.1-.6-.2-.9.2-.2.4-1 1.2-1.2 1.4-.2.2-.4.3-.8.1s-1.6-.6-3.1-1.9c-1.1-1-1.9-2.2-2.1-2.6-.2-.4 0-.6.2-.8.2-.2.4-.4.6-.6.2-.2.2-.4.4-.6.1-.2 0-.4 0-.6s-.9-2.2-1.2-3c-.3-.8-.7-.7-.9-.7h-.8c-.2 0-.6.1-.9.4-.3.4-1.2 1.2-1.2 2.9s1.2 3.4 1.4 3.6c.2.2 2.4 3.7 5.9 5.2.8.3 1.4.5 1.9.6.8.3 1.5.3 2 .2.6-.1 2.3-.9 2.6-1.8.3-.9.3-1.7.2-1.8-.1-.2-.4-.3-.8-.5z" />
                                            </svg>

                                            <span>Reminder</span>
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mobile-list">
        @foreach ($invoices as $invoice)
            <div class="invoice-card">
                <div class="card-header">
                    <div class="invoice-avatar">🧾</div>
                    <div class="card-main">
                        <div class="name">{{ $invoice->siswa->nama_anak }}</div>
                        <span class="code-badge">{{ $invoice->invoice_code }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <span class="info-label">Nominal:</span>
                        <span class="strong">Rp {{ number_format($invoice->nominal) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tipe:</span>
                        <span class="type-badge {{ strtolower($invoice->tipe) }}">{{ $invoice->tipe }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status:</span>
                        <span class="badge {{ strtolower($invoice->status) }}">{{ $invoice->status }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Pembayaran:</span>
                        <div class="payment-info">
                            <span class="paid">Rp {{ number_format($invoice->total_paid) }}</span>
                            <span class="separator">/</span>
                            <span class="total">Rp {{ number_format($invoice->nominal) }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <a href="{{ route('admin.invoice.edit', $invoice->id) }}" class="button-edit">
                        <svg viewBox="0 0 512 512" class="svgIcon">
                            <path
                                d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z">
                            </path>
                        </svg>
                    </a>

                    @if ($invoice->status === 'UNPAID')
                        <form method="POST" action="{{ route('admin.invoice.destroy', $invoice->id) }}"
                            style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="button-delete" type="submit"
                                onclick="return confirm('Yakin hapus invoice ini?')">
                                <svg viewBox="0 0 448 512" class="svgIcon">
                                    <path
                                        d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                                    </path>
                                </svg>
                            </button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.invoice.send-wa', $invoice->id) }}">
                        @csrf
                        <button type="submit" class="wa-btn">
                            (SVG DISINI)
                            <span>Kirim</span>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    {{-- DELETE MODAL --}}
    <div id="deleteModal" class="modal-overlay" style="display:none;">
        <div class="card">
            <svg id="cookieSvg" viewBox="0 0 122.88 122.25">

            </svg>

            <p class="cookieHeading">Hapus Invoice?</p>
            <p class="cookieDescription">
                Invoice yang dihapus tidak bisa dikembalikan.
            </p>

            <div class="buttonContainer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="acceptButton">Hapus</button>
                </form>

                <button class="declineButton" onclick="closeDeleteModal()">Batal</button>
            </div>
        </div>
    </div>
    <script>
        function openDeleteModal(id) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');

            form.action = `/admin/invoice/${id}`;
            modal.style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }
    </script>


    <style>
        .card {
            width: 300px;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px 30px;
            gap: 12px;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
            animation: scaleIn .25s ease;
        }

        @keyframes scaleIn {
            from {
                transform: scale(.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        #cookieSvg {
            width: 50px;
        }

        #cookieSvg path {
            fill: #6b7280;
        }

        .cookieHeading {
            font-size: 18px;
            font-weight: 800;
            color: #111;
        }

        .cookieDescription {
            font-size: 13px;
            text-align: center;
            color: #6b7280;
        }

        .buttonContainer {
            display: flex;
            gap: 14px;
            margin-top: 10px;
        }

        .acceptButton {
            padding: 8px 18px;
            background: #dc2626;
            border: none;
            border-radius: 20px;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
        }

        .acceptButton:hover {
            background: #b91c1c;
        }

        .declineButton {
            padding: 8px 18px;
            background: #e5e7eb;
            border: none;
            border-radius: 20px;
            font-weight: 600;
            cursor: pointer;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-title {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            color: #1a1a1a;
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 12px;
            background: linear-gradient(135deg, #800000 0%, #b30000 100%);
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(128, 0, 0, .3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(128, 0, 0, .4);
        }

        /* Alert Styles */
        .alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-error {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border-left: 4px solid #dc2626;
        }

        .alert-success {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-left: 4px solid #10b981;
        }

        .alert-icon {
            font-size: 24px;
        }

        .alert-content {
            flex: 1;
        }

        .alert-title {
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .alert-error .alert-title {
            color: #dc2626;
        }

        .alert-success .alert-title {
            color: #10b981;
        }

        .alert-message {
            font-size: 13px;
            color: #6b7280;
        }

        .alert-close {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: #9ca3af;
            padding: 4px 8px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .alert-close:hover {
            background: rgba(0, 0, 0, .05);
            color: #374151;
        }

        /* Table Container */
        .table-container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
            overflow-x: auto;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
        }

        .modern-table thead {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        }

        .modern-table th {
            font-size: 12px;
            font-weight: 700;
            color: #6b7280;
            padding: 16px;
            border-bottom: 2px solid #e5e7eb;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: left;
        }

        .modern-table td {
            padding: 16px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
        }

        .modern-table tbody tr {
            transition: all 0.2s ease;
        }

        .modern-table tbody tr:hover {
            background: #f9fafb;
        }

        .strong {
            font-weight: 700;
            color: #1a1a1a;
        }

        .code-badge {
            display: inline-block;
            padding: 4px 10px;
            background: #f3f4f6;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #374151;
            font-weight: 600;
        }

        .type-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
        }

        .type-badge.dp {
            background: #dbeafe;
            color: #1e40af;
        }

        .type-badge.bulanan {
            background: #fef3c7;
            color: #b45309;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge.paid {
            background: #dcfce7;
            color: #16a34a;
        }

        .badge.unpaid {
            background: #fee2e2;
            color: #dc2626;
        }

        .badge.pending {
            background: #fef3c7;
            color: #ca8a04;
        }

        .payment-info {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
        }

        .payment-info .paid {
            color: #10b981;
            font-weight: 700;
        }

        .payment-info .separator {
            color: #d1d5db;
        }

        .payment-info .total {
            color: #6b7280;
        }

        .aksi {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        /* Animated Delete Button */
        .button-delete {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgb(20, 20, 20);
            border: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.164);
            cursor: pointer;
            transition-duration: .3s;
            overflow: hidden;
            position: relative;
        }

        .button-delete .svgIcon {
            width: 12px;
            transition-duration: .3s;
        }

        .button-delete .svgIcon path {
            fill: white;
        }

        .button-delete:hover {
            width: 140px;
            border-radius: 50px;
            transition-duration: .3s;
            background-color: rgb(255, 69, 69);
            align-items: center;
        }

        .button-delete:hover .svgIcon {
            width: 50px;
            transition-duration: .3s;
            transform: translateY(60%);
        }

        .button-delete::before {
            position: absolute;
            top: -20px;
            content: "Delete";
            color: white;
            transition-duration: .3s;
            font-size: 2px;
        }

        .button-delete:hover::before {
            font-size: 13px;
            opacity: 1;
            transform: translateY(30px);
            transition-duration: .3s;
        }

        /* Animated Edit Button */
        .button-edit {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgb(20, 20, 20);
            border: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.164);
            cursor: pointer;
            transition-duration: .3s;
            overflow: hidden;
            position: relative;
            text-decoration: none;
        }

        .button-edit .svgIcon {
            width: 12px;
            transition-duration: .3s;
        }

        .button-edit .svgIcon path {
            fill: white;
        }

        .button-edit:hover {
            width: 140px;
            border-radius: 50px;
            transition-duration: .3s;
            background-color: rgb(53, 116, 255);
            align-items: center;
        }

        .button-edit:hover .svgIcon {
            width: 50px;
            transition-duration: .3s;
            transform: translateY(60%);
        }

        .button-edit::before {
            position: absolute;
            top: -20px;
            content: "Edit";
            color: white;
            transition-duration: .3s;
            font-size: 2px;
        }

        .button-edit:hover::before {
            font-size: 13px;
            opacity: 1;
            transform: translateY(30px);
            transition-duration: .3s;
        }

        .btn-icon {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 12px;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-icon.success {
            color: #10b981;
            background: #f0fdf4;
        }

        .btn-icon.success:hover {
            background: #dcfce7;
        }

        .btn-icon.warning {
            color: #f59e0b;
            background: #fffbeb;
        }

        .btn-icon.warning:hover {
            background: #fef3c7;
        }

        /* Mobile Cards */
        .mobile-list {
            display: none;
        }

        .invoice-card {
            background: #fff;
            border-radius: 16px;
            padding: 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
            margin-bottom: 16px;
            border: 1px solid #f3f4f6;
            transition: all 0.3s ease;
        }

        .invoice-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .12);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .invoice-avatar {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #800000 0%, #b30000 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .card-main .name {
            font-weight: 700;
            font-size: 16px;
            color: #1a1a1a;
            margin-bottom: 4px;
        }

        .card-body {
            padding: 12px 0;
            border-top: 1px solid #f3f4f6;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            font-size: 13px;
        }

        .info-label {
            color: #6b7280;
            font-weight: 600;
        }

        .card-action {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #f3f4f6;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .table-container {
                display: none;
            }

            .mobile-list {
                display: block;
            }
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .wa-btn {
            font-family: inherit;
            font-size: 14px;
            background: #25D366;
            color: white;
            padding: 8px 14px;
            display: flex;
            align-items: center;
            border: none;
            border-radius: 14px;
            overflow: hidden;
            cursor: pointer;
            transition: all .2s;
        }

        .wa-btn.reminder {
            background: #f59e0b;
        }

        .wa-btn span {
            margin-left: 6px;
            transition: transform .3s ease;
            white-space: nowrap;
        }

        .wa-btn svg {
            transition: transform .3s ease;
        }

        .wa-btn:hover svg {
            transform: translateX(6px) rotate(20deg);
        }

        .wa-btn:hover span {
            transform: translateX(30px);
        }

        .wa-btn:active {
            transform: scale(.95);
        }
    </style>
@endsection
