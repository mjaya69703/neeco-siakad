<?php

namespace App\Http\Controllers\Master\Infra\Inventaris;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Inventaris\KategoriBarang;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class KategoriBarangController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Kategori Barang';
        $data['pages'] = "Halaman Data Kategori Barang";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['kategori_barangs'] = KategoriBarang::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('master.infra.inventaris.kategori-barang-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Kategori Barang';
        $data['pages'] = "Halaman Data Kategori Barang yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['kategori_barangs'] = KategoriBarang::onlyTrashed()->get();
        $data['is_trash'] = true;

        return view('master.infra.inventaris.kategori-barang-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:kategori_barang,code',
        ], [
            'name.required' => 'Nama kategori barang wajib diisi',
            'code.required' => 'Kode kategori barang wajib diisi',
            'code.unique' => 'Kode kategori barang sudah ada',
        ]);

        try {
            $user = Auth::user();
            
            KategoriBarang::create([
                'name' => $request->name,
                'code' => $request->code,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data kategori barang berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $kategori_barang = KategoriBarang::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:kategori_barang,code,' . $id,
        ], [
            'name.required' => 'Nama kategori barang wajib diisi',
            'code.required' => 'Kode kategori barang wajib diisi',
            'code.unique' => 'Kode kategori barang sudah ada',
        ]);

        try {
            $user = Auth::user();
            
            $kategori_barang->update([
                'name' => $request->name,
                'code' => $request->code,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data kategori barang berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $kategori_barang = KategoriBarang::findOrFail($id);
            
            // Check if kategori_barang is being used by barangs
            if ($kategori_barang->barangs()->count() > 0) {
                Alert::warning('Peringatan', 'Data kategori barang tidak dapat dihapus karena masih digunakan oleh barang');
                return redirect()->back();
            }

            $user = Auth::user();
            $kategori_barang->update(['deleted_by' => $user->id]);
            $kategori_barang->delete();

            Alert::success('Berhasil', 'Data kategori barang berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $kategori_barang = KategoriBarang::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $kategori_barang->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $kategori_barang->restore();

            Alert::success('Berhasil', 'Data kategori barang berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}