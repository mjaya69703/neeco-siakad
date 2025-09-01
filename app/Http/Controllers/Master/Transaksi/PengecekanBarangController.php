<?php

namespace App\Http\Controllers\Master\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Transaksi\PengecekanBarang;
use App\Models\Inventaris\BarangInventaris;
use App\Models\User;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;
use Carbon\Carbon;

class PengecekanBarangController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Transaksi Pengecekan Barang';
        $data['pages'] = "Halaman Data Pengecekan Barang";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['pengecekan'] = PengecekanBarang::with(['barangInventaris.barang', 'petugas'])->orderBy('tanggal_cek', 'desc')->get();
        $data['barang_inventaris'] = BarangInventaris::with('barang')->where('is_active', true)->orderBy('nomor_inventaris')->get();
        $data['users'] = User::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('master.transaksi-barang.pengecekan-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Transaksi Pengecekan Barang';
        $data['pages'] = "Halaman Data Pengecekan Barang yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['pengecekan'] = PengecekanBarang::onlyTrashed()->with(['barangInventaris.barang', 'petugas'])->get();
        $data['barang_inventaris'] = BarangInventaris::with('barang')->where('is_active', true)->orderBy('nomor_inventaris')->get();
        $data['users'] = User::orderBy('name')->get();
        $data['is_trash'] = true;

        return view('master.transaksi-barang.pengecekan-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_inventaris_id' => 'required|exists:barang_inventaris,id',
            'petugas_id' => 'required|exists:users,id',
            'tanggal_cek' => 'required|date',
            'hasil_kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat,Hilang',
            'catatan' => 'nullable|string'
        ], [
            'barang_inventaris_id.required' => 'Barang inventaris wajib dipilih',
            'barang_inventaris_id.exists' => 'Barang inventaris tidak valid',
            'petugas_id.required' => 'Petugas wajib dipilih',
            'petugas_id.exists' => 'Petugas tidak valid',
            'tanggal_cek.required' => 'Tanggal cek wajib diisi',
            'tanggal_cek.date' => 'Tanggal cek tidak valid',
            'hasil_kondisi.required' => 'Hasil kondisi wajib dipilih',
            'hasil_kondisi.in' => 'Hasil kondisi tidak valid'
        ]);

        try {
            $user = Auth::user();
            
            PengecekanBarang::create([
                'barang_inventaris_id' => $request->barang_inventaris_id,
                'petugas_id' => $request->petugas_id,
                'tanggal_cek' => Carbon::parse($request->tanggal_cek),
                'hasil_kondisi' => $request->hasil_kondisi,
                'catatan' => $request->catatan,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data pengecekan barang berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $pengecekan = PengecekanBarang::findOrFail($id);
        
        $request->validate([
            'barang_inventaris_id' => 'required|exists:barang_inventaris,id',
            'petugas_id' => 'required|exists:users,id',
            'tanggal_cek' => 'required|date',
            'hasil_kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat,Hilang',
            'catatan' => 'nullable|string'
        ], [
            'barang_inventaris_id.required' => 'Barang inventaris wajib dipilih',
            'barang_inventaris_id.exists' => 'Barang inventaris tidak valid',
            'petugas_id.required' => 'Petugas wajib dipilih',
            'petugas_id.exists' => 'Petugas tidak valid',
            'tanggal_cek.required' => 'Tanggal cek wajib diisi',
            'tanggal_cek.date' => 'Tanggal cek tidak valid',
            'hasil_kondisi.required' => 'Hasil kondisi wajib dipilih',
            'hasil_kondisi.in' => 'Hasil kondisi tidak valid'
        ]);

        try {
            $user = Auth::user();
            
            $pengecekan->update([
                'barang_inventaris_id' => $request->barang_inventaris_id,
                'petugas_id' => $request->petugas_id,
                'tanggal_cek' => Carbon::parse($request->tanggal_cek),
                'hasil_kondisi' => $request->hasil_kondisi,
                'catatan' => $request->catatan,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data pengecekan barang berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $pengecekan = PengecekanBarang::findOrFail($id);

            $user = Auth::user();
            $pengecekan->update(['deleted_by' => $user->id]);
            $pengecekan->delete();

            Alert::success('Berhasil', 'Data pengecekan barang berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $pengecekan = PengecekanBarang::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $pengecekan->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $pengecekan->restore();

            Alert::success('Berhasil', 'Data pengecekan barang berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}