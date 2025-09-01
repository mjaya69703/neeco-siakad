<?php

namespace App\Http\Controllers\Master\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Transaksi\RiwayatPerbaikan;
use App\Models\Transaksi\PengajuanPerbaikan;
use App\Models\Inventaris\BarangInventaris;
use App\Models\User;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;
use Carbon\Carbon;

class RiwayatPerbaikanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Transaksi Riwayat Perbaikan';
        $data['pages'] = "Halaman Data Riwayat Perbaikan";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['riwayat'] = RiwayatPerbaikan::with(['pengajuan', 'barangInventaris.barang'])->orderBy('tanggal_service', 'desc')->get();
        $data['pengajuan_list'] = PengajuanPerbaikan::with(['barangInventaris.barang'])->orderBy('tanggal_pengajuan', 'desc')->get();
        $data['barang_inventaris'] = BarangInventaris::with('barang')->where('is_active', true)->orderBy('nomor_inventaris')->get();
        $data['is_trash'] = false;

        return view('master.transaksi-barang.riwayat-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Transaksi Riwayat Perbaikan';
        $data['pages'] = "Halaman Data Riwayat Perbaikan yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['riwayat'] = RiwayatPerbaikan::onlyTrashed()->with(['pengajuan', 'barangInventaris.barang'])->get();
        $data['pengajuan_list'] = PengajuanPerbaikan::with(['barangInventaris.barang'])->orderBy('tanggal_pengajuan', 'desc')->get();
        $data['barang_inventaris'] = BarangInventaris::with('barang')->where('is_active', true)->orderBy('nomor_inventaris')->get();
        $data['is_trash'] = true;

        return view('master.transaksi-barang.riwayat-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pengajuan_id' => 'nullable|exists:pengajuan_perbaikan,id',
            'barang_inventaris_id' => 'required|exists:barang_inventaris,id',
            'tanggal_service' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_service',
            'tempat_service' => 'nullable|string|max:255',
            'biaya' => 'nullable|numeric|min:0',
            'hasil' => 'required|in:Baik,Rusak Ringan,Rusak Berat,Tidak Bisa Diperbaiki',
            'catatan' => 'nullable|string'
        ], [
            'pengajuan_id.exists' => 'Pengajuan tidak valid',
            'barang_inventaris_id.required' => 'Barang inventaris wajib dipilih',
            'barang_inventaris_id.exists' => 'Barang inventaris tidak valid',
            'tanggal_service.required' => 'Tanggal service wajib diisi',
            'tanggal_service.date' => 'Tanggal service tidak valid',
            'tanggal_selesai.date' => 'Tanggal selesai tidak valid',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal service',
            'tempat_service.string' => 'Tempat service harus berupa teks',
            'biaya.numeric' => 'Biaya harus berupa angka',
            'biaya.min' => 'Biaya tidak boleh negatif',
            'hasil.required' => 'Hasil wajib dipilih',
            'hasil.in' => 'Hasil tidak valid'
        ]);

        try {
            $user = Auth::user();
            
            RiwayatPerbaikan::create([
                'pengajuan_id' => $request->pengajuan_id,
                'barang_inventaris_id' => $request->barang_inventaris_id,
                'tanggal_service' => Carbon::parse($request->tanggal_service),
                'tanggal_selesai' => $request->tanggal_selesai ? Carbon::parse($request->tanggal_selesai) : null,
                'tempat_service' => $request->tempat_service,
                'biaya' => $request->biaya,
                'hasil' => $request->hasil,
                'catatan' => $request->catatan,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data riwayat perbaikan berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $riwayat = RiwayatPerbaikan::findOrFail($id);
        
        $request->validate([
            'pengajuan_id' => 'nullable|exists:pengajuan_perbaikan,id',
            'barang_inventaris_id' => 'required|exists:barang_inventaris,id',
            'tanggal_service' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_service',
            'tempat_service' => 'nullable|string|max:255',
            'biaya' => 'nullable|numeric|min:0',
            'hasil' => 'required|in:Baik,Rusak Ringan,Rusak Berat,Tidak Bisa Diperbaiki',
            'catatan' => 'nullable|string'
        ], [
            'pengajuan_id.exists' => 'Pengajuan tidak valid',
            'barang_inventaris_id.required' => 'Barang inventaris wajib dipilih',
            'barang_inventaris_id.exists' => 'Barang inventaris tidak valid',
            'tanggal_service.required' => 'Tanggal service wajib diisi',
            'tanggal_service.date' => 'Tanggal service tidak valid',
            'tanggal_selesai.date' => 'Tanggal selesai tidak valid',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal service',
            'tempat_service.string' => 'Tempat service harus berupa teks',
            'biaya.numeric' => 'Biaya harus berupa angka',
            'biaya.min' => 'Biaya tidak boleh negatif',
            'hasil.required' => 'Hasil wajib dipilih',
            'hasil.in' => 'Hasil tidak valid'
        ]);

        try {
            $user = Auth::user();
            
            $riwayat->update([
                'pengajuan_id' => $request->pengajuan_id,
                'barang_inventaris_id' => $request->barang_inventaris_id,
                'tanggal_service' => Carbon::parse($request->tanggal_service),
                'tanggal_selesai' => $request->tanggal_selesai ? Carbon::parse($request->tanggal_selesai) : null,
                'tempat_service' => $request->tempat_service,
                'biaya' => $request->biaya,
                'hasil' => $request->hasil,
                'catatan' => $request->catatan,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data riwayat perbaikan berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $riwayat = RiwayatPerbaikan::findOrFail($id);

            $user = Auth::user();
            $riwayat->update(['deleted_by' => $user->id]);
            $riwayat->delete();

            Alert::success('Berhasil', 'Data riwayat perbaikan berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $riwayat = RiwayatPerbaikan::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $riwayat->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $riwayat->restore();

            Alert::success('Berhasil', 'Data riwayat perbaikan berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}