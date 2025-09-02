<?php

namespace App\Http\Controllers\Master\Infra\Inventaris;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Perawatan\JadwalPemeliharaan;
use App\Models\Inventaris\BarangInventaris;
use App\Models\User;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;
use Carbon\Carbon;

class JadwalPemeliharaanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Perawatan Jadwal Pemeliharaan';
        $data['pages'] = "Halaman Data Jadwal Pemeliharaan";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['jadwal'] = JadwalPemeliharaan::with(['barangInventaris.barang'])->orderBy('tanggal_mulai', 'desc')->get();
        $data['barang_inventaris'] = BarangInventaris::with('barang')->where('is_active', true)->orderBy('nomor_inventaris')->get();
        $data['is_trash'] = false;

        return view('master.infra.perawatan.jadwal-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Perawatan Jadwal Pemeliharaan';
        $data['pages'] = "Halaman Data Jadwal Pemeliharaan yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['jadwal'] = JadwalPemeliharaan::onlyTrashed()->with(['barangInventaris.barang'])->get();
        $data['barang_inventaris'] = BarangInventaris::with('barang')->where('is_active', true)->orderBy('nomor_inventaris')->get();
        $data['is_trash'] = true;

        return view('master.infra.perawatan.jadwal-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_inventaris_id' => 'required|exists:barang_inventaris,id',
            'jenis' => 'required|in:Harian,Mingguan,Bulanan,Tahunan',
            'interval_hari' => 'nullable|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_berikutnya' => 'nullable|date|after:tanggal_mulai',
            'keterangan' => 'nullable|string'
        ], [
            'barang_inventaris_id.required' => 'Barang inventaris wajib dipilih',
            'barang_inventaris_id.exists' => 'Barang inventaris tidak valid',
            'jenis.required' => 'Jenis jadwal wajib dipilih',
            'jenis.in' => 'Jenis jadwal tidak valid',
            'interval_hari.integer' => 'Interval hari harus berupa angka',
            'interval_hari.min' => 'Interval hari minimal 1',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_mulai.date' => 'Tanggal mulai tidak valid',
            'tanggal_berikutnya.date' => 'Tanggal berikutnya tidak valid',
            'tanggal_berikutnya.after' => 'Tanggal berikutnya harus setelah tanggal mulai'
        ]);

        try {
            $user = Auth::user();
            
            JadwalPemeliharaan::create([
                'barang_inventaris_id' => $request->barang_inventaris_id,
                'jenis' => $request->jenis,
                'interval_hari' => $request->interval_hari,
                'tanggal_mulai' => Carbon::parse($request->tanggal_mulai),
                'tanggal_berikutnya' => $request->tanggal_berikutnya ? Carbon::parse($request->tanggal_berikutnya) : null,
                'keterangan' => $request->keterangan,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data jadwal pemeliharaan berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalPemeliharaan::findOrFail($id);
        
        $request->validate([
            'barang_inventaris_id' => 'required|exists:barang_inventaris,id',
            'jenis' => 'required|in:Harian,Mingguan,Bulanan,Tahunan',
            'interval_hari' => 'nullable|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_berikutnya' => 'nullable|date|after:tanggal_mulai',
            'keterangan' => 'nullable|string'
        ], [
            'barang_inventaris_id.required' => 'Barang inventaris wajib dipilih',
            'barang_inventaris_id.exists' => 'Barang inventaris tidak valid',
            'jenis.required' => 'Jenis jadwal wajib dipilih',
            'jenis.in' => 'Jenis jadwal tidak valid',
            'interval_hari.integer' => 'Interval hari harus berupa angka',
            'interval_hari.min' => 'Interval hari minimal 1',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_mulai.date' => 'Tanggal mulai tidak valid',
            'tanggal_berikutnya.date' => 'Tanggal berikutnya tidak valid',
            'tanggal_berikutnya.after' => 'Tanggal berikutnya harus setelah tanggal mulai'
        ]);

        try {
            $user = Auth::user();
            
            $jadwal->update([
                'barang_inventaris_id' => $request->barang_inventaris_id,
                'jenis' => $request->jenis,
                'interval_hari' => $request->interval_hari,
                'tanggal_mulai' => Carbon::parse($request->tanggal_mulai),
                'tanggal_berikutnya' => $request->tanggal_berikutnya ? Carbon::parse($request->tanggal_berikutnya) : null,
                'keterangan' => $request->keterangan,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data jadwal pemeliharaan berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $jadwal = JadwalPemeliharaan::findOrFail($id);

            $user = Auth::user();
            $jadwal->update(['deleted_by' => $user->id]);
            $jadwal->delete();

            Alert::success('Berhasil', 'Data jadwal pemeliharaan berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $jadwal = JadwalPemeliharaan::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $jadwal->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $jadwal->restore();

            Alert::success('Berhasil', 'Data jadwal pemeliharaan berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}