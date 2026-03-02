{{-- resources/views/centre/laporan/index.blade.php --}}
@extends('layouts.admin.app')
 
@section('content')

<div class="breadcrumb">
    <a href="{{ route('centre.dashboard') }}">Beranda</a>
    <span>›</span>
    <strong>Laporan Cabang</strong>
</div>

<h2 class="page-title">Laporan Cabang</h2>

<div class="cabang-list">
    @foreach($cabangs as $cabang)
        <a href="{{ route('centre.laporan.detail', $cabang->id) }}" class="cabang-item">
            <span class="cabang-name">{{ $cabang->nama_cabang }}</span>
            <span class="arrow">›</span>
        </a>
    @endforeach
</div>

<style>
    .breadcrumb {
        font-size: 13px;
        color: #777;
        margin-bottom: 12px;
    }

    .breadcrumb a {
        color: #777;
        text-decoration: none;
    }

    .breadcrumb span {
        margin: 0 6px;
    }

    .breadcrumb strong {
        color: #800000;
        font-weight: 600;
    }

    .page-title {
        margin: 8px 0 20px;
        font-size: 22px;
        font-weight: 700;
        color: #222;
    }

    .cabang-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 14px;
    }

    .cabang-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        background: #fff;
        border-radius: 10px;
        text-decoration: none;
        color: #222;
        box-shadow: 0 6px 18px rgba(0,0,0,0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .cabang-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(0,0,0,0.08);
    }

    .cabang-name {
        font-weight: 600;
        font-size: 14px;
    }

    .arrow {
        font-size: 18px;
        color: #800000;
        opacity: 0.6;
    }

    @media (max-width: 480px) {
        .cabang-list {
            grid-template-columns: 1fr;
        }
    }
</style>

@endsection
