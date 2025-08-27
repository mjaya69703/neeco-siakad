<?php

namespace App\Http\Controllers\Referensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Referensi\Agama;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class AgamaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Agama';
        $data['pages'] = "Halaman Data Agama";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['agamas'] = Agama::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('referensi.agama-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Agama';
        $data['pages'] = "Halaman Data Agama yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['agamas'] = Agama::onlyTrashed()->get();
        $data['is_trash'] = true;

        return view('referensi.agama-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:agamas,name'
        ], [
            'name.required' => 'Nama agama wajib diisi',
            'name.unique' => 'Nama agama sudah ada'
        ]);

        try {
            $user = Auth::user();
            
            Agama::create([
                'name' => $request->name,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data agama berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $agama = Agama::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:agamas,name,' . $id
        ], [
            'name.required' => 'Nama agama wajib diisi',
            'name.unique' => 'Nama agama sudah ada'
        ]);

        try {
            $user = Auth::user();
            
            $agama->update([
                'name' => $request->name,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data agama berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $agama = Agama::findOrFail($id);
            
            // Check if agama is being used by users
            if ($agama->users()->count() > 0) {
                Alert::warning('Peringatan', 'Data agama tidak dapat dihapus karena masih digunakan oleh pengguna');
                return redirect()->back();
            }

            $user = Auth::user();
            $agama->update(['deleted_by' => $user->id]);
            $agama->delete();

            Alert::success('Berhasil', 'Data agama berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $agama = Agama::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $agama->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $agama->restore();

            Alert::success('Berhasil', 'Data agama berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}
