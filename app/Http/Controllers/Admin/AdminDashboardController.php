<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->filled('bulan') ? (int) $request->bulan : null;
        $tahun = $request->filled('tahun') ? (int) $request->tahun : null;

        $cabangId = Auth::user()->cabang_id;

        $invoiceMenunggu = Invoice::whereIn('status', ['UNPAID', 'PENDING'])
            ->whereHas('siswa', fn($q) => $q->where('cabang_id', $cabangId))
            ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))
            ->when($tahun, fn($q) => $q->whereYear('created_at', $tahun))
            ->count();

        $invoiceLunas = Invoice::where('status', 'PAID')
            ->whereHas('siswa', fn($q) => $q->where('cabang_id', $cabangId))
            ->when($bulan, fn($q) => $q->whereMonth('paid_at', $bulan))
            ->when($tahun, fn($q) => $q->whereYear('paid_at', $tahun))
            ->count();

        $invoiceDP = Invoice::where('status', 'DP')
            ->whereHas('siswa', fn($q) => $q->where('cabang_id', $cabangId))
            ->count();

        $totalMasuk = 0;

        return view('admin.dashboard', compact(
            'invoiceMenunggu',
            'invoiceLunas',
            'invoiceDP',
            'totalMasuk'
        ));
    }
}



// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use App\Models\Transaksi;
// use App\Models\Invoice;
// use Illuminate\Support\Facades\Auth;

// class AdminDashboardController extends Controller
// {
//     public function index()
//     {
//         $bulan = now()->month;
//         $tahun = now()->year;

//         $totalMasuk = Transaksi::whereMonth('paid_at', $bulan)
//             ->whereYear('paid_at', $tahun)
//             ->sum('amount');

//         $invoiceMenunggu = Invoice::whereHas('siswa', function ($q) {
//                 $q->where('cabang_id', Auth::user()->cabang_id);
//             })
//             ->get()
//             ->filter(fn ($i) => $i->payment_status === 'MENUNGGU')
//             ->count();

//         $invoiceDP = Invoice::whereHas('siswa', function ($q) {
//                 $q->where('cabang_id', Auth::user()->cabang_id);
//             })
//             ->get()
//             ->filter(fn ($i) => $i->payment_status === 'DP')
//             ->count();

//         $invoiceLunas = Invoice::whereHas('siswa', function ($q) {
//                 $q->where('cabang_id', Auth::user()->cabang_id);
//             })
//             ->get()
//             ->filter(fn ($i) => $i->payment_status === 'LUNAS')
//             ->count();

//         return view('admin.dashboard', compact(
//             'totalMasuk',
//             'invoiceMenunggu',
//             'invoiceDP',
//             'invoiceLunas'
//         ));
//     }
// }
