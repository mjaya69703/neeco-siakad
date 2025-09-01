<?php

namespace App\Http\Controllers\Master\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Transaksi\PeminjamanBarang;
use App\Models\Inventaris\BarangInventaris;
use App\Models\User;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;
use Carbon\Carbon;

class PeminjamanBarangController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Transaksi Peminjaman Barang';
        $data['pages'] = "Halaman Data Peminjaman Barang";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['peminjaman'] = PeminjamanBarang::with(['barangInventaris.barang', 'peminjam', 'petugas'])->orderBy('tanggal_pinjam', 'desc')->get();
        $data['barang_inventaris'] = BarangInventaris::with('barang')->where('is_active', true)->orderBy('nomor_inventaris')->get();
        $data['users'] = User::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('master.transaksi-barang.peminjaman-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Transaksi Peminjaman Barang';
        $data['pages'] = "Halaman Data Peminjaman Barang yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['peminjaman'] = PeminjamanBarang::onlyTrashed()->with(['barangInventaris.barang', 'peminjam', 'petugas'])->get();
        $data['barang_inventaris'] = BarangInventaris::with('barang')->where('is_active', true)->orderBy('nomor_inventaris')->get();
        $data['users'] = User::orderBy('name')->get();
        $data['is_trash'] = true;

        return view('master.transaksi-barang.peminjaman-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_inventaris_id' => 'required|exists:barang_inventaris,id',
            'peminjam_id' => 'required|exists:users,id',
            'petugas_id' => 'required|exists:users,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after:tanggal_pinjam',
            'tanggal_dikembalikan' => 'nullable|date|after:tanggal_pinjam',
            'status' => 'required|in:Dipinjam,Dikembalikan,Hilang,Rusak',
            'keterangan' => 'nullable|string'
        ], [
            'barang_inventaris_id.required' => 'Barang inventaris wajib dipilih',
            'barang_inventaris_id.exists' => 'Barang inventaris tidak valid',
            'peminjam_id.required' => 'Peminjam wajib dipilih',
            'peminjam_id.exists' => 'Peminjam tidak valid',
            'petugas_id.required' => 'Petugas wajib dipilih',
            'petugas_id.exists' => 'Petugas tidak valid',
            'tanggal_pinjam.required' => 'Tanggal pinjam wajib diisi',
            'tanggal_pinjam.date' => 'Tanggal pinjam tidak valid',
            'tanggal_kembali.date' => 'Tanggal kembali tidak valid',
            'tanggal_kembali.after' => 'Tanggal kembali harus setelah tanggal pinjam',
            'tanggal_dikembalikan.date' => 'Tanggal dikembalikan tidak valid',
            'tanggal_dikembalikan.after' => 'Tanggal dikembalikan harus setelah tanggal pinjam',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid'
        ]);

        try {
            $user = Auth::user();
            
            PeminjamanBarang::create([
                'barang_inventaris_id' => $request->barang_inventaris_id,
                'peminjam_id' => $request->peminjam_id,
                'petugas_id' => $request->petugas_id,
                'tanggal_pinjam' => Carbon::parse($request->tanggal_pinjam),
                'tanggal_kembali' => $request->tanggal_kembali ? Carbon::parse($request->tanggal_kembali) : null,
                'tanggal_dikembalikan' => $request->tanggal_dikembalikan ? Carbon::parse($request->tanggal_dikembalikan) : null,
                'status' => $request->status,
                'keterangan' => $request->keterangan,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data peminjaman barang berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $peminjaman = PeminjamanBarang::findOrFail($id);
        
        $request->validate([
            'barang_inventaris_id' => 'required|exists:barang_inventaris,id',
            'peminjam_id' => 'required|exists:users,id',
            'petugas_id' => 'required|exists:users,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after:tanggal_pinjam',
            'tanggal_dikembalikan' => 'nullable|date|after:tanggal_pinjam',
            'status' => 'required|in:Dipinjam,Dikembalikan,Hilang,Rusak',
            'keterangan' => 'nullable|string'
        ], [
            'barang_inventaris_id.required' => 'Barang inventaris wajib dipilih',
            'barang_inventaris_id.exists' => 'Barang inventaris tidak valid',
            'peminjam_id.required' => 'Peminjam wajib dipilih',
            'peminjam_id.exists' => 'Peminjam tidak valid',
            'petugas_id.required' => 'Petugas wajib dipilih',
            'petugas_id.exists' => 'Petugas tidak valid',
            'tanggal_pinjam.required' => 'Tanggal pinjam wajib diisi',
            'tanggal_pinjam.date' => 'Tanggal pinjam tidak valid',
            'tanggal_kembali.date' => 'Tanggal kembali tidak valid',
            'tanggal_kembali.after' => 'Tanggal kembali harus setelah tanggal pinjam',
            'tanggal_dikembalikan.date' => 'Tanggal dikembalikan tidak valid',
            'tanggal_dikembalikan.after' => 'Tanggal dikembalikan harus setelah tanggal pinjam',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid'
        ]);

        try {
            $user = Auth::user();
            
            $peminjaman->update([
                'barang_inventaris_id' => $request->barang_inventaris_id,
                'peminjam_id' => $request->peminjam_id,
                'petugas_id' => $request->petugas_id,
                'tanggal_pinjam' => Carbon::parse($request->tanggal_pinjam),
                'tanggal_kembali' => $request->tanggal_kembali ? Carbon::parse($request->tanggal_kembali) : null,
                'tanggal_dikembalikan' => $request->tanggal_dikembalikan ? Carbon::parse($request->tanggal_dikembalikan) : null,
                'status' => $request->status,
                'keterangan' => $request->keterangan,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data peminjaman barang berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $peminjaman = PeminjamanBarang::findOrFail($id);

            $user = Auth::user();
            $peminjaman->update(['deleted_by' => $user->id]);
            $peminjaman->delete();

            Alert::success('Berhasil', 'Data peminjaman barang berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $peminjaman = PeminjamanBarang::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $peminjaman->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $peminjaman->restore();

            Alert::success('Berhasil', 'Data peminjaman barang berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}