<?php
// app/Http/Controllers/Centre/CentreReportController.php
namespace App\Http\Controllers\Centre;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\Invoice;
use App\Models\Payroll;
use Illuminate\Http\Request;

class CentreReportController extends Controller
{
    public function index()
    {
        return view('centre.laporan.index', [
            'cabangs' => Cabang::where('tipe', 'CABANG')->get()
        ]);
    }

    public function detail(Request $request, Cabang $cabang)
{
    $bulan = $request->bulan ?? now()->month;
    $tahun = $request->tahun ?? now()->year;

    $invoices = Invoice::whereHas('siswa', function ($q) use ($cabang) {
            $q->where('cabang_id', $cabang->id);
        })
        ->where('status', 'PAID')
        ->whereMonth('created_at', $bulan)
        ->whereYear('created_at', $tahun)
        ->get();

    $totalPembayaran = $invoices->sum('nominal');

    $payroll = Payroll::where('cabang_id', $cabang->id)
        ->where('bulan', $bulan)
        ->where('tahun', $tahun)
        ->first();

    $totalPayroll = $payroll->nominal ?? 0;
    $penyesuaian = $payroll->penyesuaian ?? 0;

    $cTotal = $totalPembayaran - $totalPayroll;
    $pembayaranDaerah = ($cTotal * 0.8) + $penyesuaian;

    return view('centre.laporan.detail', compact(
        'cabang',
        'bulan',
        'tahun',
        'invoices',
        'totalPembayaran',
        'totalPayroll',
        'cTotal',
        'penyesuaian',
        'pembayaranDaerah'
    ));
}
// public function detail(Cabang $cabang)
// {
//     $bulan = now()->month;
//     $tahun = now()->year;

//     $invoices = Invoice::whereHas(
//         'siswa',
//         fn($q) =>
//         $q->where('cabang_id', $cabang->id)
//     )->get();

//     $totalTransaksi = Invoice::whereHas('siswa', function ($q) use ($cabang) {
//         $q->where('cabang_id', $cabang->id);
//     })
//         ->where('status', 'PAID')
//         ->whereMonth('created_at', $bulan)
//         ->whereYear('created_at', $tahun)
//         ->sum('nominal');

//     $payroll = Payroll::where('cabang_id', $cabang->id)
//         ->where('bulan', $bulan)
//         ->where('tahun', $tahun)
//         ->first();

//     $nominalPayroll = $payroll->nominal ?? 0;

//     $sisa = $totalTransaksi - $nominalPayroll;

//     return view('centre.laporan.detail', compact(
//         'cabang',
//         'invoices',
//         'totalTransaksi',
//         'nominalPayroll',
//         'sisa'
//     ));
// }
    // public function detail(Cabang $cabang)
    // {
    //     $invoices = Invoice::whereHas(
    //         'siswa',
    //         fn($q) =>
    //         $q->where('cabang_id', $cabang->id)
    //     )->get();
    //     $totalTransaksi = Invoice::whereHas('siswa', function ($q) use ($cabang) {
    //         $q->where('cabang_id', $cabang->id);
    //     })
    //         ->where('status', 'PAID')
    //         ->whereMonth('created_at', $bulan)
    //         ->whereYear('created_at', $tahun)
    //         ->sum('nominal');

    //     $payroll = Payroll::where('cabang_id', $cabang->id)
    //         ->where('bulan', $bulan)
    //         ->where('tahun', $tahun)
    //         ->first();

    //     $nominalPayroll = $payroll->nominal ?? 0;

    //     $sisa = $totalTransaksi - $nominalPayroll;

    //     return view('centre.laporan.detail', compact(
    //         'cabang',
    //         'totalTransaksi',
    //         'nominalPayroll',
    //         'sisa'
    //     ));
    //     // return view('centre.laporan.detail', compact('cabang', 'invoices'));
    // }
}
