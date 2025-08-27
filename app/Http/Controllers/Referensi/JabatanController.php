<?php

namespace App\Http\Controllers\Referensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Referensi\Jabatan;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class JabatanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Jabatan';
        $data['pages'] = "Halaman Data Jabatan";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['jabatans'] = Jabatan::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('referensi.jabatan-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Jabatan';
        $data['pages'] = "Halaman Data Jabatan yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['jabatans'] = Jabatan::onlyTrashed()->get();
        $data['is_trash'] = true;

        return view('referensi.jabatan-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:jabatans,name',
            'divisi' => 'required|string|max:255'
        ], [
            'name.required' => 'Nama jabatan wajib diisi',
            'name.unique' => 'Nama jabatan sudah ada',
            'divisi.required' => 'Divisi wajib diisi'
        ]);

        try {
            $user = Auth::user();
            
            Jabatan::create([
                'name' => $request->name,
                'divisi' => $request->divisi,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data jabatan berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:jabatans,name,' . $id,
            'divisi' => 'required|string|max:255'
        ], [
            'name.required' => 'Nama jabatan wajib diisi',
            'name.unique' => 'Nama jabatan sudah ada',
            'divisi.required' => 'Divisi wajib diisi'
        ]);

        try {
            $user = Auth::user();
            
            $jabatan->update([
                'name' => $request->name,
                'divisi' => $request->divisi,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data jabatan berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $jabatan = Jabatan::findOrFail($id);
            
            $user = Auth::user();
            $jabatan->update(['deleted_by' => $user->id]);
            $jabatan->delete();

            Alert::success('Berhasil', 'Data jabatan berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $jabatan = Jabatan::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $jabatan->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $jabatan->restore();

            Alert::success('Berhasil', 'Data jabatan berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}