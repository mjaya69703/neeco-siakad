<?php

namespace App\Http\Controllers\Referensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Referensi\Kewarganegaraan;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class KewarganegaraanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Kewarganegaraan';
        $data['pages'] = "Halaman Data Kewarganegaraan";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['kewarganegaraans'] = Kewarganegaraan::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('referensi.kewarganegaraan-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Kewarganegaraan';
        $data['pages'] = "Halaman Data Kewarganegaraan yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['kewarganegaraans'] = Kewarganegaraan::onlyTrashed()->get();
        $data['is_trash'] = true;

        return view('referensi.kewarganegaraan-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:kewarganegaraans,name'
        ], [
            'name.required' => 'Nama kewarganegaraan wajib diisi',
            'name.unique' => 'Nama kewarganegaraan sudah ada'
        ]);

        try {
            $user = Auth::user();
            
            Kewarganegaraan::create([
                'name' => $request->name,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data kewarganegaraan berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $kewarganegaraan = Kewarganegaraan::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:kewarganegaraans,name,' . $id
        ], [
            'name.required' => 'Nama kewarganegaraan wajib diisi',
            'name.unique' => 'Nama kewarganegaraan sudah ada'
        ]);

        try {
            $user = Auth::user();
            
            $kewarganegaraan->update([
                'name' => $request->name,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data kewarganegaraan berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $kewarganegaraan = Kewarganegaraan::findOrFail($id);
            
            // Check if kewarganegaraan is being used by users
            if ($kewarganegaraan->users()->count() > 0) {
                Alert::warning('Peringatan', 'Data kewarganegaraan tidak dapat dihapus karena masih digunakan oleh pengguna');
                return redirect()->back();
            }

            $user = Auth::user();
            $kewarganegaraan->update(['deleted_by' => $user->id]);
            $kewarganegaraan->delete();

            Alert::success('Berhasil', 'Data kewarganegaraan berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $kewarganegaraan = Kewarganegaraan::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $kewarganegaraan->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $kewarganegaraan->restore();

            Alert::success('Berhasil', 'Data kewarganegaraan berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}