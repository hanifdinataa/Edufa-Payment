@extends('layouts.admin.app')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span>›</span>
        <a href="{{ route('admin.invoice.index') }}">Invoice</a>
        <span>›</span>
        <strong>Edit</strong>
    </div>

    <h2 class="page-title">Edit Invoice</h2>

    <form method="POST" action="{{ route('admin.invoice.update', $invoice->id) }}" class="form-card" id="formInvoice">
        @csrf @method('PUT')

        <div class="form-group">
            <label>
                <span class="label-icon">👨‍🎓</span>
                Siswa
            </label>
            <select name="siswa_id" required>
                @foreach ($siswas as $siswa)
                    <option value="{{ $siswa->id }}" {{ $invoice->siswa_id == $siswa->id ? 'selected' : '' }}>
                        {{ $siswa->nama_anak }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>
                <span class="label-icon">💰</span>
                Nominal
            </label>
            <input type="number" name="nominal" value="{{ $invoice->nominal }}" required>
        </div>

        <div class="form-group">
            <label>
                <span class="label-icon">📋</span>
                Tipe
            </label>
            <select name="tipe" required>
                <option value="DP" {{ $invoice->tipe === 'DP' ? 'selected' : '' }}>DP</option>
                <option value="BULANAN" {{ $invoice->tipe === 'BULANAN' ? 'selected' : '' }}>Bulanan</option>
            </select>
        </div>

        <div class="form-group">
            <label>
                <span class="label-icon">📅</span>
                Periode
            </label>
            <input type="text" name="periode" value="{{ $invoice->periode }}" placeholder="Contoh: 2025-01" required>
        </div>

        <div class="form-group">
            <label>
                <span class="label-icon">⏰</span>
                Jatuh Tempo
            </label>
            <input type="date" name="due_date" value="{{ $invoice->due_date }}" required>
        </div>

        <div class="form-action">
            <a href="{{ route('admin.invoice.index') }}" class="btn-secondary">
                Batal
            </a>
            <button type="submit" class="btn-primary">
                <span>💾</span>
                Simpan Perubahan
            </button>
        </div>
    </form>

    <style>
        .form-card {
            max-width: 560px;
            background: #fff;
            padding: 32px;
            border-radius: 20px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, .08);
            margin: 24px auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #374151;
        }

        .label-icon {
            font-size: 18px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #800000;
            box-shadow: 0 0 0 4px rgba(128, 0, 0, .1);
        }

        .form-action {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }

        .btn-primary {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 24px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #800000 0%, #b30000 100%);
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(128, 0, 0, .3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(128, 0, 0, .4);
        }

        .btn-secondary {
            padding: 14px 24px;
            border-radius: 12px;
            background: #f3f4f6;
            color: #6b7280;
            text-decoration: none;
            font-size: 15px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
            color: #374151;
        }
    </style>

    <script>
        anime({
            targets: '#formInvoice',
            opacity: [0, 1],
            translateY: [20, 0],
            duration: 600,
            easing: 'easeOutCubic'
        });
    </script>
@endsection
