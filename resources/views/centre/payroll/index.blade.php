{{-- // resources/views/centre/payroll/index.blade.php --}}
@extends('layouts.admin.app')

@section('content')

<div class="page-wrapper">

    <div class="page-header">
        <h2>Data Payroll</h2>
        <a href="{{ route('centre.payroll.create') }}" class="btn-primary">
            + Input Payroll
        </a>
    </div>

    <div class="card">

        <table class="table-custom">
            <thead>
                <tr>
                    <th>Cabang</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Nominal</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payrolls as $payroll)
                    <tr>
                        <td>{{ $payroll->cabang->nama_cabang ?? '-' }}</td>
                        <td>{{ $payroll->bulan }}</td>
                        <td>{{ $payroll->tahun }}</td>
                        <td>Rp {{ number_format($payroll->nominal,0,',','.') }}</td>
                        <td>
                            <a href="{{ route('centre.payroll.edit', $payroll->id) }}"
                               class="btn-small">Edit</a>

                            <form action="{{ route('centre.payroll.destroy', $payroll->id) }}"
                                  method="POST"
                                  style="display:inline;"
                                  onsubmit="return confirm('Yakin hapus payroll ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-text">
                            Belum ada data payroll
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>

@endsection