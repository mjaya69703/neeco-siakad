<?php

namespace App\Http\Controllers\Master\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Transaksi\PengajuanPerbaikan;
use App\Models\Inventaris\BarangInventaris;
use App\Models\User;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;
use Carbon\Carbon;

class PengajuanPerbaikanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Transaksi Pengajuan Perbaikan';
        $data['pages'] = "Halaman Data Pengajuan Perbaikan";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['pengajuan'] = PengajuanPerbaikan::with(['barangInventaris.barang', 'pengaju', 'disetujuiOleh'])->orderBy('tanggal_pengajuan', 'desc')->get();
        $data['barang_inventaris'] = BarangInventaris::with('barang')->where('is_active', true)->orderBy('nomor_inventaris')->get();
        $data['users'] = User::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('master.transaksi-barang.pengajuan-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Transaksi Pengajuan Perbaikan';
        $data['pages'] = "Halaman Data Pengajuan Perbaikan yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['pengajuan'] = PengajuanPerbaikan::onlyTrashed()->with(['barangInventaris.barang', 'pengaju', 'disetujuiOleh'])->get();
        $data['barang_inventaris'] = BarangInventaris::with('barang')->where('is_active', true)->orderBy('nomor_inventaris')->get();
        $data['users'] = User::orderBy('name')->get();
        $data['is_trash'] = true;

        return view('master.transaksi-barang.pengajuan-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_inventaris_id' => 'required|exists:barang_inventaris,id',
            'pengaju_id' => 'required|exists:users,id',
            'disetujui_oleh' => 'nullable|exists:users,id',
            'tanggal_pengajuan' => 'required|date',
            'status' => 'required|in:Diajukan,Disetujui,Ditolak,Diproses,Selesai',
            'deskripsi_kerusakan' => 'nullable|string'
        ], [
            'barang_inventaris_id.required' => 'Barang inventaris wajib dipilih',
            'barang_inventaris_id.exists' => 'Barang inventaris tidak valid',
            'pengaju_id.required' => 'Pengaju wajib dipilih',
            'pengaju_id.exists' => 'Pengaju tidak valid',
            'disetujui_oleh.exists' => 'User yang menyetujui tidak valid',
            'tanggal_pengajuan.required' => 'Tanggal pengajuan wajib diisi',
            'tanggal_pengajuan.date' => 'Tanggal pengajuan tidak valid',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid'
        ]);

        try {
            $user = Auth::user();
            
            PengajuanPerbaikan::create([
                'barang_inventaris_id' => $request->barang_inventaris_id,
                'pengaju_id' => $request->pengaju_id,
                'disetujui_oleh' => $request->disetujui_oleh,
                'tanggal_pengajuan' => Carbon::parse($request->tanggal_pengajuan),
                'status' => $request->status,
                'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data pengajuan perbaikan berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $pengajuan = PengajuanPerbaikan::findOrFail($id);
        
        $request->validate([
            'barang_inventaris_id' => 'required|exists:barang_inventaris,id',
            'pengaju_id' => 'required|exists:users,id',
            'disetujui_oleh' => 'nullable|exists:users,id',
            'tanggal_pengajuan' => 'required|date',
            'status' => 'required|in:Diajukan,Disetujui,Ditolak,Diproses,Selesai',
            'deskripsi_kerusakan' => 'nullable|string'
        ], [
            'barang_inventaris_id.required' => 'Barang inventaris wajib dipilih',
            'barang_inventaris_id.exists' => 'Barang inventaris tidak valid',
            'pengaju_id.required' => 'Pengaju wajib dipilih',
            'pengaju_id.exists' => 'Pengaju tidak valid',
            'disetujui_oleh.exists' => 'User yang menyetujui tidak valid',
            'tanggal_pengajuan.required' => 'Tanggal pengajuan wajib diisi',
            'tanggal_pengajuan.date' => 'Tanggal pengajuan tidak valid',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid'
        ]);

        try {
            $user = Auth::user();
            
            $pengajuan->update([
                'barang_inventaris_id' => $request->barang_inventaris_id,
                'pengaju_id' => $request->pengaju_id,
                'disetujui_oleh' => $request->disetujui_oleh,
                'tanggal_pengajuan' => Carbon::parse($request->tanggal_pengajuan),
                'status' => $request->status,
                'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data pengajuan perbaikan berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $pengajuan = PengajuanPerbaikan::findOrFail($id);

            $user = Auth::user();
            $pengajuan->update(['deleted_by' => $user->id]);
            $pengajuan->delete();

            Alert::success('Berhasil', 'Data pengajuan perbaikan berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $pengajuan = PengajuanPerbaikan::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $pengajuan->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $pengajuan->restore();

            Alert::success('Berhasil', 'Data pengajuan perbaikan berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}