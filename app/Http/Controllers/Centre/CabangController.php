<?php

namespace App\Http\Controllers\Centre;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CabangController extends Controller
{
    public function index()
    {
        $cabangs = Cabang::where('tipe', 'CABANG')->get();
        return view('centre.cabang.index', compact('cabangs'));
    }

    public function create()
    {
        return view('centre.cabang.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_cabang' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ]);

    DB::transaction(function () use ($request) {

        $cabang = Cabang::create([
            'nama_cabang' => $request->nama_cabang,
            'tipe' => 'CABANG'
        ]);

        User::create([
            'name' => $request->nama_cabang,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'ADMIN', // sesuaikan kalau role kamu beda
            'cabang_id' => $cabang->id
        ]);
    });

    return redirect()->route('centre.cabang.index')
        ->with('success', 'Cabang dan akun login berhasil dibuat');
}

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama_cabang' => 'required|string|max:255',
    //     ]);

    //     Cabang::create([
    //         'nama_cabang' => $request->nama_cabang,
    //         'tipe' => 'CABANG'
    //     ]);

    //     return redirect()->route('centre.cabang.index')
    //         ->with('success', 'Cabang berhasil ditambahkan');
    // }

    public function edit(Cabang $cabang)
    {
        return view('centre.cabang.edit', compact('cabang'));
    }

    public function update(Request $request, Cabang $cabang)
    {
        $request->validate([
            'nama_cabang' => 'required|string|max:255',
        ]);

        $cabang->update([
            'nama_cabang' => $request->nama_cabang
        ]);

        return redirect()->route('centre.cabang.index')
            ->with('success', 'Cabang berhasil diperbarui');
    }

    public function destroy(Cabang $cabang)
    {
        $cabang->delete();

        return redirect()->route('centre.cabang.index')
            ->with('success', 'Cabang berhasil dihapus');
    }
}
