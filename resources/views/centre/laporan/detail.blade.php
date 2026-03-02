{{-- resources/views/centre/laporan/detail.blade.php --}}
@extends('layouts.admin.app')

@section('content')
    <div class="page-wrapper">

        {{-- Breadcrumb --}}
        <div class="breadcrumb">
            <a href="{{ route('centre.dashboard') }}">Beranda</a>
            <span>›</span>
            <a href="{{ route('centre.laporan.index') }}">Laporan</a>
            <span>›</span>
            <strong>{{ $cabang->nama_cabang }}</strong>
        </div>

        <h2 class="page-title">
            <div class="filter-card">

                <form method="GET">
                    <div class="filter-row">

                        <div class="filter-group">
                            <label>Bulan</label>
                            <select name="bulan">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Tahun</label>
                            <input type="number" name="tahun" value="{{ $tahun }}">
                        </div>

                        <div class="filter-group">
                            <button type="submit" class="btn-primary">
                                Filter
                            </button>
                        </div>

                    </div>
                </form>

            </div>
            Laporan {{ $cabang->nama_cabang }} - {{ $bulan }}/{{ $tahun }}
        </h2>

        {{-- TABLE TRANSAKSI --}}
        <div class="table-card">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Anak</th>
                        <th>Periode</th>
                        <th>Nominal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->created_at->format('d-m-Y') }}</td>
                            <td>{{ $invoice->siswa->nama_anak }}</td>
                            <td>{{ $invoice->periode }}</td>
                            <td>Rp {{ number_format($invoice->nominal, 0, ',', '.') }}</td>
                            <td>
                                <span class="status {{ strtolower($invoice->status) }}">
                                    {{ $invoice->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-text">
                                Belum ada transaksi bulan ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- SUMMARY EXCEL STYLE --}}
        <div class="summary-card">

            <div class="summary-row highlight">
                <span>A. TOTAL PEMBAYARAN</span>
                <strong>Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</strong>
            </div>

            <div class="summary-row danger">
                <span>B. TOTAL PAYROLL</span>
                <strong>Rp {{ number_format($totalPayroll, 0, ',', '.') }}</strong>
            </div>

            <div class="summary-row highlight">
                <span>C. TOTAL (A - B)</span>
                <strong>Rp {{ number_format($cTotal, 0, ',', '.') }}</strong>
            </div>

            <div class="summary-row">
                <span>D. PENYESUAIAN</span>
                <strong>Rp {{ number_format($penyesuaian, 0, ',', '.') }}</strong>
            </div>

            <div class="summary-row highlight">
                <span>E. PEMBAYARAN KE DAERAH</span>
                <strong>
                    Rp {{ number_format($pembayaranDaerah, 0, ',', '.') }}
                </strong>
            </div>

        </div>

    </div>


    <style>
        /* Wrapper */
        .page-wrapper {
            padding-bottom: 40px;
        }

        /* Breadcrumb */
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

        /* Title */
        .page-title {
            margin: 8px 0 20px;
            font-size: 22px;
            font-weight: 700;
        }

        /* Table Card */
        .table-card {
            background: #fff;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
            overflow-x: auto;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        .modern-table th {
            text-align: left;
            font-size: 13px;
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

        .empty-text {
            text-align: center;
            padding: 20px;
            color: #777;
        }

        /* Status */
        .status {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .status.paid {
            background: #e6f6ee;
            color: #1f9254;
        }

        .status.unpaid {
            background: #fdecec;
            color: #b42318;
        }

        .status.pending {
            background: #fff4e5;
            color: #b54708;
        }

        /* Summary Card */
        .summary-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 14px 16px;
            font-size: 14px;
            border-bottom: 1px solid #f1f1f1;
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-row.highlight {
            background: #fff8dc;
            font-weight: 700;
        }

        .summary-row.danger {
            background: #fee2e2;
            color: #991b1b;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        anime({
            targets: '.modern-table tbody tr',
            opacity: [0, 1],
            translateY: [10, 0],
            delay: anime.stagger(40),
            easing: 'easeOutQuad'
        });
    </script>
@endsection
