<?php

namespace App\Http\Controllers\Centre;

use App\Http\Controllers\Controller;
use App\Models\Siswa;

class CentreSiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::with('cabang')
            ->orderBy('nama_anak')
            ->get();

        return view('centre.siswa.index', compact('siswas'));
    }
}
