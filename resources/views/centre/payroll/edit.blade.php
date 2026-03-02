@extends('layouts.admin.app')

@section('content')

<div class="page-wrapper">

    <div class="page-header">
        <h2>Edit Payroll</h2>
        <a href="{{ route('centre.payroll.index') }}" class="btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card">

        <form action="{{ route('centre.payroll.update',$payroll->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Cabang</label>
                <select name="cabang_id" required>
                    @foreach($cabangs as $cabang)
                        <option value="{{ $cabang->id }}"
                            {{ $payroll->cabang_id == $cabang->id ? 'selected' : '' }}>
                            {{ $cabang->nama_cabang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Bulan</label>
                <input type="number" name="bulan"
                       value="{{ $payroll->bulan }}"
                       min="1" max="12" required>
            </div>

            <div class="form-group">
                <label>Tahun</label>
                <input type="number" name="tahun"
                       value="{{ $payroll->tahun }}"
                       required>
            </div>

            <div class="form-group">
                <label>Nominal</label>
                <input type="number" name="nominal"
                       value="{{ $payroll->nominal }}"
                       required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    Update
                </button>
            </div>

        </form>

    </div>

</div>

@endsection