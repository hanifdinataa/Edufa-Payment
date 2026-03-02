@extends('layouts.admin.app')

@section('content')

<div class="page-wrapper">

    <div class="page-header">
        <h2>Edit Cabang</h2>
        <a href="{{ route('centre.cabang.index') }}" class="btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card">
        <form action="{{ route('centre.cabang.update', $cabang->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Cabang</label>
                <input type="text" name="nama_cabang"
                       value="{{ $cabang->nama_cabang }}" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Update</button>
            </div>
        </form>
    </div>

</div>

@endsection