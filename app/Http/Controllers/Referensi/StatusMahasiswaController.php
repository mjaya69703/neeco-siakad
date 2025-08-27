<?php

namespace App\Http\Controllers\Referensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Referensi\StatusMahasiswa;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class StatusMahasiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Status Mahasiswa';
        $data['pages'] = "Halaman Data Status Mahasiswa";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['status_mahasiswas'] = StatusMahasiswa::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('referensi.status-mahasiswa-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Status Mahasiswa';
        $data['pages'] = "Halaman Data Status Mahasiswa yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['status_mahasiswas'] = StatusMahasiswa::onlyTrashed()->get();
        $data['is_trash'] = true;

        return view('referensi.status-mahasiswa-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:status_mahasiswas,name'
        ], [
            'name.required' => 'Nama status mahasiswa wajib diisi',
            'name.unique' => 'Nama status mahasiswa sudah ada'
        ]);

        try {
            $user = Auth::user();
            
            StatusMahasiswa::create([
                'name' => $request->name,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data status mahasiswa berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $status_mahasiswa = StatusMahasiswa::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:status_mahasiswas,name,' . $id
        ], [
            'name.required' => 'Nama status mahasiswa wajib diisi',
            'name.unique' => 'Nama status mahasiswa sudah ada'
        ]);

        try {
            $user = Auth::user();
            
            $status_mahasiswa->update([
                'name' => $request->name,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data status mahasiswa berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $status_mahasiswa = StatusMahasiswa::findOrFail($id);
            
            $user = Auth::user();
            $status_mahasiswa->update(['deleted_by' => $user->id]);
            $status_mahasiswa->delete();

            Alert::success('Berhasil', 'Data status mahasiswa berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $status_mahasiswa = StatusMahasiswa::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $status_mahasiswa->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $status_mahasiswa->restore();

            Alert::success('Berhasil', 'Data status mahasiswa berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}