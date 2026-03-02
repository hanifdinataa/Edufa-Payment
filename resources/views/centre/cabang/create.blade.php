@extends('layouts.admin.app')

@section('content')

<div class="page-wrapper">

    <div class="page-header">
        <h2>Tambah Cabang</h2>
        <a href="{{ route('centre.cabang.index') }}" class="btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card">
        <form action="{{ route('centre.cabang.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Cabang</label>
                <input type="text" name="nama_cabang" required>
            </div>

            <div class="form-group">
                <label>Email Login</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Simpan</button>
            </div>
        </form>
    </div>

</div>

@endsection