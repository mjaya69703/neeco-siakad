<?php

namespace App\Http\Controllers\Master\Infra\Inventaris;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Inventaris\BarangInventaris;
use App\Models\Inventaris\Barang;
use App\Models\Infra\Ruangan;
use App\Models\User;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class BarangInventarisController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Barang Inventaris';
        $data['pages'] = "Halaman Data Barang Inventaris";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['barang_inventaris'] = BarangInventaris::with(['barang', 'ruangan', 'pengguna'])->orderBy('nomor_inventaris')->get();
        $data['barangs'] = Barang::where('is_active', true)->orderBy('name')->get();
        $data['ruangans'] = Ruangan::where('is_active', true)->orderBy('name')->get();
        $data['users'] = User::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('master.infra.inventaris.barang-inventaris-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Barang Inventaris';
        $data['pages'] = "Halaman Data Barang Inventaris yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['barang_inventaris'] = BarangInventaris::onlyTrashed()->with(['barang', 'ruangan', 'pengguna'])->get();
        $data['barangs'] = Barang::where('is_active', true)->orderBy('name')->get();
        $data['ruangans'] = Ruangan::where('is_active', true)->orderBy('name')->get();
        $data['users'] = User::orderBy('name')->get();
        $data['is_trash'] = true;

        return view('master.infra.inventaris.barang-inventaris-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'ruangan_id' => 'nullable|exists:ruangan,id',
            'pengguna_id' => 'nullable|exists:users,id',
            'nomor_inventaris' => 'required|string|unique:barang_inventaris,nomor_inventaris',
            'serial_number' => 'nullable|string|unique:barang_inventaris,serial_number',
            'tanggal_pembelian' => 'nullable|date',
            'tanggal_pendataan' => 'nullable|date',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'is_active' => 'boolean'
        ], [
            'barang_id.required' => 'Barang wajib dipilih',
            'barang_id.exists' => 'Barang tidak valid',
            'ruangan_id.exists' => 'Ruangan tidak valid',
            'pengguna_id.exists' => 'Pengguna tidak valid',
            'nomor_inventaris.required' => 'Nomor inventaris wajib diisi',
            'nomor_inventaris.unique' => 'Nomor inventaris sudah ada',
            'serial_number.unique' => 'Serial number sudah ada',
            'tanggal_pembelian.date' => 'Tanggal pembelian tidak valid',
            'tanggal_pendataan.date' => 'Tanggal pendataan tidak valid',
            'kondisi.required' => 'Kondisi barang wajib dipilih',
            'kondisi.in' => 'Kondisi barang tidak valid',
        ]);

        try {
            $user = Auth::user();
            
            BarangInventaris::create([
                'barang_id' => $request->barang_id,
                'ruangan_id' => $request->ruangan_id,
                'pengguna_id' => $request->pengguna_id,
                'nomor_inventaris' => $request->nomor_inventaris,
                'serial_number' => $request->serial_number,
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'tanggal_pendataan' => $request->tanggal_pendataan,
                'kondisi' => $request->kondisi,
                'is_active' => $request->has('is_active') ? $request->is_active : false,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data barang inventaris berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $barang_inventaris = BarangInventaris::findOrFail($id);
        
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'ruangan_id' => 'nullable|exists:ruangan,id',
            'pengguna_id' => 'nullable|exists:users,id',
            'nomor_inventaris' => 'required|string|unique:barang_inventaris,nomor_inventaris,' . $id,
            'serial_number' => 'nullable|string|unique:barang_inventaris,serial_number,' . $id,
            'tanggal_pembelian' => 'nullable|date',
            'tanggal_pendataan' => 'nullable|date',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'is_active' => 'boolean'
        ], [
            'barang_id.required' => 'Barang wajib dipilih',
            'barang_id.exists' => 'Barang tidak valid',
            'ruangan_id.exists' => 'Ruangan tidak valid',
            'pengguna_id.exists' => 'Pengguna tidak valid',
            'nomor_inventaris.required' => 'Nomor inventaris wajib diisi',
            'nomor_inventaris.unique' => 'Nomor inventaris sudah ada',
            'serial_number.unique' => 'Serial number sudah ada',
            'tanggal_pembelian.date' => 'Tanggal pembelian tidak valid',
            'tanggal_pendataan.date' => 'Tanggal pendataan tidak valid',
            'kondisi.required' => 'Kondisi barang wajib dipilih',
            'kondisi.in' => 'Kondisi barang tidak valid',
        ]);

        try {
            $user = Auth::user();
            
            $barang_inventaris->update([
                'barang_id' => $request->barang_id,
                'ruangan_id' => $request->ruangan_id,
                'pengguna_id' => $request->pengguna_id,
                'nomor_inventaris' => $request->nomor_inventaris,
                'serial_number' => $request->serial_number,
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'tanggal_pendataan' => $request->tanggal_pendataan,
                'kondisi' => $request->kondisi,
                'is_active' => $request->has('is_active') ? $request->is_active : false,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data barang inventaris berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $barang_inventaris = BarangInventaris::findOrFail($id);

            $user = Auth::user();
            $barang_inventaris->update(['deleted_by' => $user->id]);
            $barang_inventaris->delete();

            Alert::success('Berhasil', 'Data barang inventaris berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $barang_inventaris = BarangInventaris::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $barang_inventaris->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $barang_inventaris->restore();

            Alert::success('Berhasil', 'Data barang inventaris berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}