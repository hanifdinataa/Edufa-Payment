@extends('layouts.admin.app')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
</div>

<h2 class="page-title">Dashboard Admin Cabang</h2>

{{-- FILTER --}}
<form method="GET" action="{{ route('admin.dashboard') }}" class="filter-bar">
    <div class="filter-group">
        <select name="bulan">
            <option value="">Semua Bulan</option>
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                </option>
            @endfor
        </select>

        <select name="tahun">
            <option value="">Semua Tahun</option>
            @for ($y = now()->year; $y >= now()->year - 5; $y--)
                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                    {{ $y }}
                </option>
            @endfor
        </select>

        <button type="submit">Filter</button>

        <a href="{{ route('admin.dashboard') }}" class="btn-reset">Reset</a>
    </div>
</form>

@if(request('bulan') || request('tahun'))
    <div class="info-bar">
        Menampilkan data
        {{ request('bulan') ? \Carbon\Carbon::create()->month((int) request('bulan'))->translatedFormat('F') : 'Semua Bulan' }}
        {{ request('tahun') ?? '' }}
    </div>
@endif

{{-- MENU --}}
<div class="menu-grid">
    <a href="{{ route('admin.siswa.index') }}" class="menu-card">
        <div class="menu-icon">👨‍🎓</div>
        <div>
            <div class="menu-title">Data Siswa</div>
            <div class="menu-desc">Kelola data siswa cabang</div>
        </div>
    </a>

    <a href="{{ route('admin.invoice.index') }}" class="menu-card">
        <div class="menu-icon">🧾</div>
        <div>
            <div class="menu-title">Data Invoice</div>
            <div class="menu-desc">Kelola pembayaran & invoice</div>
        </div>
    </a>
</div>

<br>

{{-- STATISTICS --}}
<div class="stats-grid">
    <div class="stat-card green">
        <div class="stat-top">
            <span>Invoice Lunas</span>
            <span class="badge">✔</span>
        </div>
        <div class="stat-value">{{ $invoiceLunas }}</div>
    </div>

    <div class="stat-card orange">
        <div class="stat-top">
            <span>Invoice Menunggu</span>
            <span class="badge">!</span>
        </div>
        <div class="stat-value">{{ $invoiceMenunggu }}</div>
    </div>

    <div class="stat-card blue">
        <div class="stat-top">
            <span>Invoice DP</span>
            <span class="badge">DP</span>
        </div>
        <div class="stat-value">{{ $invoiceDP }}</div>
        <div class="stat-footer">sebagian bayar</div>
    </div>

    <div class="stat-card green">
        <div class="stat-top">
            <span>Pemasukan</span>
            <span class="badge">Rp</span>
        </div>
        <div class="stat-value">
            Rp {{ number_format($totalMasuk) }}
        </div>
        <div class="stat-footer up">cashflow</div>
    </div>
</div>

<style>
.page-title {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 16px;
}

.info-bar {
    background: #e8f4fd;
    color: #1e3a8a;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 13px;
    margin-bottom: 24px;
}

/* FILTER */
.filter-bar {
    margin-bottom: 16px;
}

.filter-group {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.filter-group select,
.filter-group button,
.btn-reset {
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    font-size: 14px;
}

.filter-group button {
    background: #3b82f6;
    color: #fff;
    border: none;
    cursor: pointer;
}

.btn-reset {
    background: #f3f4f6;
    text-decoration: none;
    color: #374151;
}

/* STAT GRID */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 16px;
    margin-bottom: 32px;
}

.stat-card {
    background: #fff;
    border-radius: 12px;
    padding: 16px 18px;
    border: 1px solid #e5e7eb;
}

.stat-top {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 12px;
}

.stat-value {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 6px;
}

.stat-footer {
    font-size: 12px;
    color: #6b7280;
}

.stat-footer.up {
    color: #16a34a;
}

.badge {
    background: #f3f4f6;
    border-radius: 50%;
    width: 26px;
    height: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
}

/* COLOR */
.stat-card.green { border-bottom: 3px solid #22c55e; }
.stat-card.orange { border-bottom: 3px solid #f59e0b; }
.stat-card.blue { border-bottom: 3px solid #3b82f6; }

/* MENU */
.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 16px;
}

.menu-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 18px;
    display: flex;
    gap: 14px;
    text-decoration: none;
    color: inherit;
}

.menu-icon {
    font-size: 32px;
}

.menu-title {
    font-weight: 700;
    margin-bottom: 4px;
}

.menu-desc {
    font-size: 13px;
    color: #6b7280;
}

@media (max-width: 768px) {
    .stats-grid,
    .menu-grid {
        grid-template-columns: 1fr;
    }
}
</style>

@endsection
