@extends('layouts.admin.app')

@section('content')

<div class="page-wrapper">

    <div class="breadcrumb">
        <a href="{{ route('centre.dashboard') }}">Beranda</a>
        <span>›</span>
        <strong>List Siswa</strong>
    </div>

    <h2 class="page-title">Daftar Seluruh Siswa</h2>

    <div class="card">

        <table class="table-custom">
            <thead>
                <tr>
                    <th>Nama Anak</th>
                    <th>Orang Tua</th>
                    <th>Cabang</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $siswa)
                <tr>
                    <td>{{ $siswa->nama_anak }}</td>
                    <td>{{ $siswa->nama_orangtua }}</td>
                    <td>
                        <span class="badge-cabang">
                            {{ $siswa->cabang->nama_cabang ?? '-' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="empty-text">
                        Belum ada data siswa
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>

@endsection