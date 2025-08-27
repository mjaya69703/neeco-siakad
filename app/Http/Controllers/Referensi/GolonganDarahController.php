<?php

namespace App\Http\Controllers\Referensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Referensi\GolonganDarah;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class GolonganDarahController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Golongan Darah';
        $data['pages'] = "Halaman Data Golongan Darah";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['golongan_darahs'] = GolonganDarah::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('referensi.golongan-darah-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Golongan Darah';
        $data['pages'] = "Halaman Data Golongan Darah yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['golongan_darahs'] = GolonganDarah::onlyTrashed()->get();
        $data['is_trash'] = true;

        return view('referensi.golongan-darah-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:golongan_darahs,name'
        ], [
            'name.required' => 'Nama golongan darah wajib diisi',
            'name.unique' => 'Nama golongan darah sudah ada'
        ]);

        try {
            $user = Auth::user();
            
            GolonganDarah::create([
                'name' => $request->name,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data golongan darah berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $golongan_darah = GolonganDarah::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:golongan_darahs,name,' . $id
        ], [
            'name.required' => 'Nama golongan darah wajib diisi',
            'name.unique' => 'Nama golongan darah sudah ada'
        ]);

        try {
            $user = Auth::user();
            
            $golongan_darah->update([
                'name' => $request->name,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data golongan darah berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $golongan_darah = GolonganDarah::findOrFail($id);
            
            // Check if golongan darah is being used by users
            if ($golongan_darah->users()->count() > 0) {
                Alert::warning('Peringatan', 'Data golongan darah tidak dapat dihapus karena masih digunakan oleh pengguna');
                return redirect()->back();
            }

            $user = Auth::user();
            $golongan_darah->update(['deleted_by' => $user->id]);
            $golongan_darah->delete();

            Alert::success('Berhasil', 'Data golongan darah berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $golongan_darah = GolonganDarah::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $golongan_darah->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $golongan_darah->restore();

            Alert::success('Berhasil', 'Data golongan darah berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}