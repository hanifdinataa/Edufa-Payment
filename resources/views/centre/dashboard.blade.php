{{-- resources/views/centre/dashboard.blade.php --}}
@extends('layouts.admin.app')

@section('content')
<h2 style="margin-bottom: 16px;">Dashboard Centre</h2>

<div class="table-card">
    <table class="modern-table">
        <thead>
            <tr>
                <th>Cabang</th>
                <th>Total Invoice</th>
                <th>Sudah Dibayar</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $row)
            <tr>
                <td>{{ $row->nama_cabang }}</td>
                <td>{{ $row->total }}</td>
                <td>{{ $row->paid }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<a href="/centre/laporan" class="link-action">Lihat Cabang</a>

<style>
    .table-card {
        overflow-x: auto;
        margin-bottom: 20px;
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 500px;
    }

    .modern-table th {
        text-align: left;
        font-size: 14px;
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

    .link-action {
        display: inline-block;
        margin-top: 8px;
        color: #800000;
        font-weight: 600;
        text-decoration: none;
    }

    .link-action:hover {
        text-decoration: underline;
    }
</style>
@endsection
