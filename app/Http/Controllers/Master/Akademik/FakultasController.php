<?php

namespace App\Http\Controllers\Master\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Akademik\Fakultas;
use App\Models\User;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class FakultasController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Akademik Fakultas';
        $data['pages'] = "Halaman Data Fakultas";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['fakultas'] = Fakultas::with(['dekan', 'sekretaris'])->orderBy('name')->get();
        $data['users'] = User::all();
        $data['is_trash'] = false;

        return view('master.akademik.fakultas-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Akademik Fakultas';
        $data['pages'] = "Halaman Data Fakultas yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['fakultas'] = Fakultas::onlyTrashed()->with(['dekan', 'sekretaris'])->get();
        $data['users'] = User::all();
        $data['is_trash'] = true;

        return view('master.akademik.fakultas-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:fakultas,code',
            'nama_singkat' => 'nullable|string|max:20',
            'akreditasi' => 'nullable|string|max:10',
            'tanggal_akreditasi' => 'nullable|date',
            'sk_pendirian' => 'nullable|string|max:255',
            'tanggal_sk_pendirian' => 'nullable|date',
            'dekan_id' => 'nullable|exists:users,id',
            'sekretaris_id' => 'nullable|exists:users,id',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'is_active' => 'required|boolean'
        ], [
            'name.required' => 'Nama fakultas wajib diisi',
            'code.required' => 'Kode fakultas wajib diisi',
            'code.unique' => 'Kode fakultas sudah ada',
            'dekan_id.exists' => 'Dekan tidak valid',
            'sekretaris_id.exists' => 'Sekretaris tidak valid',
            'email.email' => 'Format email tidak valid'
        ]);

        try {
            $user = Auth::user();
            
            Fakultas::create([
                'name' => $request->name,
                'code' => $request->code,
                'nama_singkat' => $request->nama_singkat,
                'akreditasi' => $request->akreditasi,
                'tanggal_akreditasi' => $request->tanggal_akreditasi,
                'sk_pendirian' => $request->sk_pendirian,
                'tanggal_sk_pendirian' => $request->tanggal_sk_pendirian,
                'dekan_id' => $request->dekan_id,
                'sekretaris_id' => $request->sekretaris_id,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
                'is_active' => $request->is_active,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data fakultas berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $fakultas = Fakultas::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:fakultas,code,' . $id,
            'nama_singkat' => 'nullable|string|max:20',
            'akreditasi' => 'nullable|string|max:10',
            'tanggal_akreditasi' => 'nullable|date',
            'sk_pendirian' => 'nullable|string|max:255',
            'tanggal_sk_pendirian' => 'nullable|date',
            'dekan_id' => 'nullable|exists:users,id',
            'sekretaris_id' => 'nullable|exists:users,id',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'is_active' => 'required|boolean'
        ], [
            'name.required' => 'Nama fakultas wajib diisi',
            'code.required' => 'Kode fakultas wajib diisi',
            'code.unique' => 'Kode fakultas sudah ada',
            'dekan_id.exists' => 'Dekan tidak valid',
            'sekretaris_id.exists' => 'Sekretaris tidak valid',
            'email.email' => 'Format email tidak valid'
        ]);

        try {
            $user = Auth::user();
            
            $fakultas->update([
                'name' => $request->name,
                'code' => $request->code,
                'nama_singkat' => $request->nama_singkat,
                'akreditasi' => $request->akreditasi,
                'tanggal_akreditasi' => $request->tanggal_akreditasi,
                'sk_pendirian' => $request->sk_pendirian,
                'tanggal_sk_pendirian' => $request->tanggal_sk_pendirian,
                'dekan_id' => $request->dekan_id,
                'sekretaris_id' => $request->sekretaris_id,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
                'is_active' => $request->is_active,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data fakultas berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $fakultas = Fakultas::findOrFail($id);

            $user = Auth::user();
            $fakultas->update(['deleted_by' => $user->id]);
            $fakultas->delete();

            Alert::success('Berhasil', 'Data fakultas berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $fakultas = Fakultas::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $fakultas->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $fakultas->restore();

            Alert::success('Berhasil', 'Data fakultas berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}