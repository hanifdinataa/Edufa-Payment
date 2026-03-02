{{-- // resources/views/centre/payroll/create.blade.php
 --}}
@extends('layouts.admin.app')

@section('content')

<div class="page-wrapper">

    <div class="page-header">
        <h2>Input Payroll</h2>
        <a href="{{ route('centre.payroll.index') }}" class="btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card">

        <form action="{{ route('centre.payroll.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Cabang</label>
                <select name="cabang_id" required>
                    <option value="">-- Pilih Cabang --</option>
                    @foreach($cabangs as $cabang)
                        <option value="{{ $cabang->id }}">
                            {{ $cabang->nama_cabang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Bulan</label>
                <input type="number" name="bulan" min="1" max="12" required>
            </div>

            <div class="form-group">
                <label>Tahun</label>
                <input type="number" name="tahun" required>
            </div>

            <div class="form-group">
                <label>Nominal</label>
                <input type="number" name="nominal" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Simpan</button>
            </div>

        </form>

    </div>

</div>

@endsection