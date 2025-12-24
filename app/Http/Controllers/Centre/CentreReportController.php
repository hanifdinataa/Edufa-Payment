<?php

namespace App\Http\Controllers\Centre;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\Invoice;

class CentreReportController extends Controller
{
    public function index()
{
    return view('centre.laporan.index', [
        'cabangs' => Cabang::where('tipe','CABANG')->get()
    ]);
}

public function detail(Cabang $cabang)
{
    $invoices = Invoice::whereHas('siswa', fn($q)=>
        $q->where('cabang_id',$cabang->id)
    )->get();

    return view('centre.laporan.detail', compact('cabang','invoices'));
}

}
