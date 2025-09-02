<?php

namespace App\Http\Controllers\Master\Infra\Inventaris;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Inventaris\Barang;
use App\Models\Inventaris\KategoriBarang;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class BarangController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Barang';
        $data['pages'] = "Halaman Data Barang";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['barangs'] = Barang::with('kategori')->orderBy('name')->get();
        $data['kategori_barangs'] = KategoriBarang::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('master.infra.inventaris.barang-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Barang';
        $data['pages'] = "Halaman Data Barang yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['barangs'] = Barang::onlyTrashed()->with('kategori')->get();
        $data['kategori_barangs'] = KategoriBarang::orderBy('name')->get();
        $data['is_trash'] = true;

        return view('master.infra.inventaris.barang-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_barang,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:barang,code',
            'merk' => 'required|string|max:255',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'is_active' => 'boolean'
        ], [
            'kategori_id.required' => 'Kategori barang wajib dipilih',
            'kategori_id.exists' => 'Kategori barang tidak valid',
            'name.required' => 'Nama barang wajib diisi',
            'code.required' => 'Kode barang wajib diisi',
            'code.unique' => 'Kode barang sudah ada',
            'merk.required' => 'Merk barang wajib diisi',
            'kondisi.required' => 'Kondisi barang wajib dipilih',
            'kondisi.in' => 'Kondisi barang tidak valid',
        ]);

        try {
            $user = Auth::user();
            
            Barang::create([
                'kategori_id' => $request->kategori_id,
                'name' => $request->name,
                'code' => $request->code,
                'merk' => $request->merk,
                'kondisi' => $request->kondisi,
                'is_active' => $request->has('is_active') ? $request->is_active : false,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data barang berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        
        $request->validate([
            'kategori_id' => 'required|exists:kategori_barang,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:barang,code,' . $id,
            'merk' => 'required|string|max:255',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'is_active' => 'boolean'
        ], [
            'kategori_id.required' => 'Kategori barang wajib dipilih',
            'kategori_id.exists' => 'Kategori barang tidak valid',
            'name.required' => 'Nama barang wajib diisi',
            'code.required' => 'Kode barang wajib diisi',
            'code.unique' => 'Kode barang sudah ada',
            'merk.required' => 'Merk barang wajib diisi',
            'kondisi.required' => 'Kondisi barang wajib dipilih',
            'kondisi.in' => 'Kondisi barang tidak valid',
        ]);

        try {
            $user = Auth::user();
            
            $barang->update([
                'kategori_id' => $request->kategori_id,
                'name' => $request->name,
                'code' => $request->code,
                'merk' => $request->merk,
                'kondisi' => $request->kondisi,
                'is_active' => $request->has('is_active') ? $request->is_active : false,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data barang berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $barang = Barang::findOrFail($id);

            $user = Auth::user();
            $barang->update(['deleted_by' => $user->id]);
            $barang->delete();

            Alert::success('Berhasil', 'Data barang berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $barang = Barang::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $barang->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $barang->restore();

            Alert::success('Berhasil', 'Data barang berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}