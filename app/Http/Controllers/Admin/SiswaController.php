<?php
// Controller/Admin/SiswaController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::where('cabang_id', Auth::user()->cabang_id)->get();
        return view('admin.siswa.index', compact('siswas'));
    }

    public function create()
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_anak'     => 'required',
            'no_induk'      => 'nullable',
            'nama_orangtua' => 'required',
            'wa'            => 'required',
            'email'         => 'nullable|email',
            'jumlah_sesi'   => 'nullable|numeric',
            'keterangan'    => 'nullable',
        ]);

        $data = $request->only([
            'nama_anak',
            'no_induk',
            'nama_orangtua',
            'wa',
            'email',
            'jumlah_sesi',
            'keterangan',
        ]);

        $data['cabang_id'] = auth()->user()->cabang_id;

        Siswa::create($data);;

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa ditambahkan');
    }

    public function edit(Siswa $siswa)
    {
        $this->authorizeSiswa($siswa);
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $this->authorizeSiswa($siswa);

        $request->validate([
            'nama_anak' => 'required',
            'nama_orangtua' => 'required',
            'wa' => 'required',
        ]);

        $siswa->update($request->only('nama_anak', 'nama_orangtua', 'wa'));

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa diperbarui');
    }

    public function destroy(Siswa $siswa)
    {
        $this->authorizeSiswa($siswa);
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa dihapus');
    }

    /**
     * Pastikan siswa milik cabang yang login
     */
    private function authorizeSiswa(Siswa $siswa)
    {
        if ($siswa->cabang_id !== Auth::user()->cabang_id) {
            abort(403);
        }
    }
}
