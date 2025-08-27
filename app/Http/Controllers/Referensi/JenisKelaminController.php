<?php

namespace App\Http\Controllers\Referensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Referensi\JenisKelamin;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class JenisKelaminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Jenis Kelamin';
        $data['pages'] = "Halaman Data Jenis Kelamin";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['jenis_kelamins'] = JenisKelamin::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('referensi.jenis-kelamin-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Jenis Kelamin';
        $data['pages'] = "Halaman Data Jenis Kelamin yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['jenis_kelamins'] = JenisKelamin::onlyTrashed()->get();
        $data['is_trash'] = true;

        return view('referensi.jenis-kelamin-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:jenis_kelamins,name'
        ], [
            'name.required' => 'Nama jenis kelamin wajib diisi',
            'name.unique' => 'Nama jenis kelamin sudah ada'
        ]);

        try {
            $user = Auth::user();
            
            JenisKelamin::create([
                'name' => $request->name,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data jenis kelamin berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $jenis_kelamin = JenisKelamin::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:jenis_kelamins,name,' . $id
        ], [
            'name.required' => 'Nama jenis kelamin wajib diisi',
            'name.unique' => 'Nama jenis kelamin sudah ada'
        ]);

        try {
            $user = Auth::user();
            
            $jenis_kelamin->update([
                'name' => $request->name,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data jenis kelamin berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $jenis_kelamin = JenisKelamin::findOrFail($id);
            
            // Check if jenis kelamin is being used by users
            if ($jenis_kelamin->users()->count() > 0) {
                Alert::warning('Peringatan', 'Data jenis kelamin tidak dapat dihapus karena masih digunakan oleh pengguna');
                return redirect()->back();
            }

            $user = Auth::user();
            $jenis_kelamin->update(['deleted_by' => $user->id]);
            $jenis_kelamin->delete();

            Alert::success('Berhasil', 'Data jenis kelamin berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $jenis_kelamin = JenisKelamin::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $jenis_kelamin->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $jenis_kelamin->restore();

            Alert::success('Berhasil', 'Data jenis kelamin berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}