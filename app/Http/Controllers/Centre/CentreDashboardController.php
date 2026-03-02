<?php
// app/Http/Controllers/Centre/CentreDashboardController.php
namespace App\Http\Controllers\Centre;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class CentreDashboardController extends Controller
{
    public function index()
{
    $data = Invoice::selectRaw('
        cabangs.nama_cabang,
        count(*) as total,
        sum(case when status="PAID" then 1 else 0 end) as paid
    ')
    ->join('siswas','siswas.id','=','invoices.siswa_id')
    ->join('cabangs','cabangs.id','=','siswas.cabang_id')
    ->groupBy('cabangs.id')
    ->get();

    return view('centre.dashboard', compact('data'));
}
}
