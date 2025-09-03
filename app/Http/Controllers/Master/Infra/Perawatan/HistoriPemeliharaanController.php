<?php

namespace App\Http\Controllers\Master\Infra\Perawatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Perawatan\HistoriPemeliharaan;
use App\Models\Perawatan\JadwalPemeliharaan;
use App\Models\Inventaris\BarangInventaris;
use App\Models\User;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;
use Carbon\Carbon;

class HistoriPemeliharaanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Perawatan Histori Pemeliharaan';
        $data['pages'] = "Halaman Data Histori Pemeliharaan";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['histori'] = HistoriPemeliharaan::with(['barangInventaris.barang', 'petugas', 'jadwal'])->orderBy('tanggal_pelaksanaan', 'desc')->get();
        $data['barang_inventaris'] = BarangInventaris::with('barang')->where('is_active', true)->orderBy('nomor_inventaris')->get();
        $data['jadwal_list'] = JadwalPemeliharaan::with('barangInventaris.barang')->orderBy('tanggal_mulai', 'desc')->get();
        $data['users'] = User::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('master.infra.perawatan.histori-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Perawatan Histori Pemeliharaan';
        $data['pages'] = "Halaman Data Histori Pemeliharaan yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['histori'] = HistoriPemeliharaan::onlyTrashed()->with(['barangInventaris.barang', 'petugas', 'jadwal'])->get();
        $data['barang_inventaris'] = BarangInventaris::with('barang')->where('is_active', true)->orderBy('nomor_inventaris')->get();
        $data['jadwal_list'] = JadwalPemeliharaan::with('barangInventaris.barang')->orderBy('tanggal_mulai', 'desc')->get();
        $data['users'] = User::orderBy('name')->get();
        $data['is_trash'] = true;

        return view('master.infra.perawatan.histori-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'nullable|exists:jadwal_pemeliharaan,id',
            'barang_inventaris_id' => 'required|exists:barang_inventaris,id',
            'petugas_id' => 'required|exists:users,id',
            'tanggal_pelaksanaan' => 'required|date',
            'hasil_kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat,Hilang',
            'catatan' => 'nullable|string'
        ], [
            'jadwal_id.exists' => 'Jadwal tidak valid',
            'barang_inventaris_id.required' => 'Barang inventaris wajib dipilih',
            'barang_inventaris_id.exists' => 'Barang inventaris tidak valid',
            'petugas_id.required' => 'Petugas wajib dipilih',
            'petugas_id.exists' => 'Petugas tidak valid',
            'tanggal_pelaksanaan.required' => 'Tanggal pelaksanaan wajib diisi',
            'tanggal_pelaksanaan.date' => 'Tanggal pelaksanaan tidak valid',
            'hasil_kondisi.required' => 'Hasil kondisi wajib dipilih',
            'hasil_kondisi.in' => 'Hasil kondisi tidak valid'
        ]);

        try {
            $user = Auth::user();
            
            HistoriPemeliharaan::create([
                'jadwal_id' => $request->jadwal_id,
                'barang_inventaris_id' => $request->barang_inventaris_id,
                'petugas_id' => $request->petugas_id,
                'tanggal_pelaksanaan' => Carbon::parse($request->tanggal_pelaksanaan),
                'hasil_kondisi' => $request->hasil_kondisi,
                'catatan' => $request->catatan,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data histori pemeliharaan berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $histori = HistoriPemeliharaan::findOrFail($id);
        
        $request->validate([
            'jadwal_id' => 'nullable|exists:jadwal_pemeliharaan,id',
            'barang_inventaris_id' => 'required|exists:barang_inventaris,id',
            'petugas_id' => 'required|exists:users,id',
            'tanggal_pelaksanaan' => 'required|date',
            'hasil_kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat,Hilang',
            'catatan' => 'nullable|string'
        ], [
            'jadwal_id.exists' => 'Jadwal tidak valid',
            'barang_inventaris_id.required' => 'Barang inventaris wajib dipilih',
            'barang_inventaris_id.exists' => 'Barang inventaris tidak valid',
            'petugas_id.required' => 'Petugas wajib dipilih',
            'petugas_id.exists' => 'Petugas tidak valid',
            'tanggal_pelaksanaan.required' => 'Tanggal pelaksanaan wajib diisi',
            'tanggal_pelaksanaan.date' => 'Tanggal pelaksanaan tidak valid',
            'hasil_kondisi.required' => 'Hasil kondisi wajib dipilih',
            'hasil_kondisi.in' => 'Hasil kondisi tidak valid'
        ]);

        try {
            $user = Auth::user();
            
            $histori->update([
                'jadwal_id' => $request->jadwal_id,
                'barang_inventaris_id' => $request->barang_inventaris_id,
                'petugas_id' => $request->petugas_id,
                'tanggal_pelaksanaan' => Carbon::parse($request->tanggal_pelaksanaan),
                'hasil_kondisi' => $request->hasil_kondisi,
                'catatan' => $request->catatan,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data histori pemeliharaan berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $histori = HistoriPemeliharaan::findOrFail($id);

            $user = Auth::user();
            $histori->update(['deleted_by' => $user->id]);
            $histori->delete();

            Alert::success('Berhasil', 'Data histori pemeliharaan berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $histori = HistoriPemeliharaan::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $histori->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $histori->restore();

            Alert::success('Berhasil', 'Data histori pemeliharaan berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}