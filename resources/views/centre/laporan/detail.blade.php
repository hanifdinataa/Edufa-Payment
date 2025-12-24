{{-- resources/views/centre/laporan/detail.blade.php --}}
@extends('layouts.admin.app')

@section('content')

{{-- Breadcrumb --}}
<div class="breadcrumb">
    <a href="{{ route('centre.dashboard') }}">Beranda</a>
    <span>›</span>
    <a href="{{ route('centre.laporan.index') }}">Laporan</a>
    <span>›</span>
    <strong>{{ $cabang->nama_cabang }}</strong>
</div>

<h2 class="page-title">Laporan {{ $cabang->nama_cabang }}</h2>

<div class="table-card">
    <table class="modern-table">
        <thead>
            <tr>
                <th>Siswa</th>
                <th>Periode</th>
                <th>Nominal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->siswa->nama_anak }}</td>
                <td>{{ $invoice->periode }}</td>
                <td>Rp {{ number_format($invoice->nominal) }}</td>
                <td>
                    <span class="status {{ strtolower($invoice->status) }}">
                        {{ $invoice->status }}
                    </span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<style>
    /* Breadcrumb */
    .breadcrumb {
        font-size: 13px;
        color: #777;
        margin-bottom: 12px;
    }

    .breadcrumb a {
        color: #777;
        text-decoration: none;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    .breadcrumb span {
        margin: 0 6px;
    }

    .breadcrumb strong {
        color: #800000;
        font-weight: 600;
    }

    /* Title */
    .page-title {
        margin: 8px 0 20px;
        font-size: 22px;
        font-weight: 700;
    }

    /* Table Card */
    .table-card {
        overflow-x: auto;
        animation: fadeUp 0.4s ease forwards;
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;
    }

    .modern-table th {
        text-align: left;
        font-size: 13px;
        color: #666;
        padding: 12px;
        border-bottom: 2px solid #eee;
    }

    .modern-table td {
        padding: 14px 12px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }

    .modern-table tr:hover {
        background: #fafafa;
    }

    /* Status Badge */
    .status {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .status.paid {
        background: #e6f6ee;
        color: #1f9254;
    }

    .status.unpaid {
        background: #fdecec;
        color: #b42318;
    }

    .status.pending {
        background: #fff4e5;
        color: #b54708;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(16px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    anime({
        targets: '.modern-table tbody tr',
        opacity: [0, 1],
        translateY: [10, 0],
        delay: anime.stagger(50),
        easing: 'easeOutQuad'
    });
</script>

@endsection
