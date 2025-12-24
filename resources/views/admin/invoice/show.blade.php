{{-- resources/views/admin/invoice/show.blade.php --}}
@extends('layouts.admin.app')

@section('content')

<div class="page-header">
    <h2 class="page-title">Detail Invoice</h2>
</div>

<div class="form-card">
    <p><strong>Siswa:</strong> {{ $invoice->siswa->nama_anak }}</p>
    <p><strong>Nominal:</strong> Rp {{ number_format($invoice->nominal) }}</p>
    <p><strong>Status:</strong> {{ $invoice->status }}</p>

    <div class="aksi" style="margin-top:16px;">
        <form method="POST" action="{{ route('admin.invoice.send-wa', $invoice->id) }}">
            @csrf
            <button class="btn-icon edit">Kirim WA</button>
        </form>

        @if ($invoice->status === 'UNPAID')
        <form method="POST" action="{{ route('admin.invoice.reminder', $invoice->id) }}">
            @csrf
            <button class="btn-icon delete">Reminder</button>
        </form>
        @endif
    </div>
</div>

<style>
.form-card {
    max-width: 480px;
    background: #fff;
    padding: 20px;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0,0,0,.05);
}
</style>
@endsection
