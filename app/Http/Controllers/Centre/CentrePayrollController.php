<?php
// app/Http/Controllers/Centre/CentrePayrollController.php

namespace App\Http\Controllers\Centre;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\Cabang;
use Illuminate\Http\Request;

class CentrePayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('cabang')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->get();

        return view('centre.payroll.index', compact('payrolls'));
    }

    public function create()
    {
        $cabangs = Cabang::where('tipe','CABANG')->get();

        return view('centre.payroll.create', compact('cabangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cabang_id' => 'required',
            'bulan'     => 'required|integer|min:1|max:12',
            'tahun'     => 'required|integer',
            'nominal'   => 'required|numeric|min:0'
        ]);

        // Kalau sudah ada bulan yang sama → update
        Payroll::updateOrCreate(
            [
                'cabang_id' => $request->cabang_id,
                'bulan'     => $request->bulan,
                'tahun'     => $request->tahun,
            ],
            [
                'nominal'   => $request->nominal,
            ]
        );

        return redirect()
            ->route('centre.payroll.index')
            ->with('success', 'Payroll berhasil disimpan');
    }

    public function edit(Payroll $payroll)
    {
        $cabangs = Cabang::where('tipe','CABANG')->get();

        return view('centre.payroll.edit', compact('payroll','cabangs'));
    }

    public function update(Request $request, Payroll $payroll)
    {
        $request->validate([
            'cabang_id' => 'required',
            'bulan'     => 'required|integer|min:1|max:12',
            'tahun'     => 'required|integer',
            'nominal'   => 'required|numeric|min:0'
        ]);

        $payroll->update([
            'cabang_id' => $request->cabang_id,
            'bulan'     => $request->bulan,
            'tahun'     => $request->tahun,
            'nominal'   => $request->nominal,
        ]);

        return redirect()
            ->route('centre.payroll.index')
            ->with('success', 'Payroll berhasil diupdate');
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();

        return redirect()
            ->route('centre.payroll.index')
            ->with('success', 'Payroll berhasil dihapus');
    }
}