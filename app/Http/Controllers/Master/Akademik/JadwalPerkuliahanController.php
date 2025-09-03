<?php

namespace App\Http\Controllers\Master\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Akademik\JadwalPerkuliahan;
use App\Models\Akademik\TahunAkademik;
use App\Models\Akademik\MataKuliah;
use App\Models\User;
use App\Models\Infra\Ruangan;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class JadwalPerkuliahanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Akademik Jadwal Perkuliahan';
        $data['pages'] = "Halaman Data Jadwal Perkuliahan";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['jadwalPerkuliahans'] = JadwalPerkuliahan::with(['tahunAkademik', 'mataKuliah', 'dosen', 'ruangan'])->orderBy('created_at', 'desc')->get();
        $data['tahunAkademiks'] = TahunAkademik::where('is_active', true)->orderBy('created_at', 'desc')->get();
        $data['mataKuliahs'] = MataKuliah::where('is_active', true)->orderBy('name')->get();
        $data['dosens'] = User::all();
        $data['ruangans'] = Ruangan::where('is_active', true)->orderBy('name')->get();
        $data['is_trash'] = false;

        return view('master.akademik.jadwal-perkuliahan-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Akademik Jadwal Perkuliahan';
        $data['pages'] = "Halaman Data Jadwal Perkuliahan yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['jadwalPerkuliahans'] = JadwalPerkuliahan::onlyTrashed()->with(['tahunAkademik', 'mataKuliah', 'dosen', 'ruangan'])->get();
        $data['tahunAkademiks'] = TahunAkademik::where('is_active', true)->orderBy('created_at', 'desc')->get();
        $data['mataKuliahs'] = MataKuliah::where('is_active', true)->orderBy('name')->get();
        $data['dosens'] = User::all();
        $data['ruangans'] = Ruangan::where('is_active', true)->orderBy('name')->get();
        $data['is_trash'] = true;

        return view('master.akademik.jadwal-perkuliahan-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'dosen_id' => 'required|exists:users,id',
            'ruang_id' => 'nullable|exists:ruangan,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'metode' => 'required|in:Tatap Muka,Teleconference,Hybrid',
            'status' => 'required|in:Terjadwal,Terlaksana,Ditunda,Dibatalkan',
            'code' => 'required|string|unique:jadwal_perkuliahan,code'
        ], [
            'tahun_akademik_id.required' => 'Tahun akademik wajib dipilih',
            'tahun_akademik_id.exists' => 'Tahun akademik tidak valid',
            'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih',
            'mata_kuliah_id.exists' => 'Mata kuliah tidak valid',
            'dosen_id.required' => 'Dosen wajib dipilih',
            'dosen_id.exists' => 'Dosen tidak valid',
            'ruang_id.exists' => 'Ruangan tidak valid',
            'hari.required' => 'Hari wajib dipilih',
            'hari.in' => 'Hari tidak valid',
            'jam_mulai.required' => 'Jam mulai wajib diisi',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid',
            'jam_selesai.required' => 'Jam selesai wajib diisi',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai',
            'metode.required' => 'Metode perkuliahan wajib dipilih',
            'metode.in' => 'Metode perkuliahan tidak valid',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
            'code.required' => 'Kode jadwal wajib diisi',
            'code.unique' => 'Kode jadwal sudah ada'
        ]);

        try {
            $user = Auth::user();
            
            JadwalPerkuliahan::create([
                'tahun_akademik_id' => $request->tahun_akademik_id,
                'mata_kuliah_id' => $request->mata_kuliah_id,
                'dosen_id' => $request->dosen_id,
                'ruang_id' => $request->ruang_id,
                'hari' => $request->hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'metode' => $request->metode,
                'status' => $request->status,
                'code' => $request->code,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data jadwal perkuliahan berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $jadwalPerkuliahan = JadwalPerkuliahan::findOrFail($id);
        
        $request->validate([
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'dosen_id' => 'required|exists:users,id',
            'ruang_id' => 'nullable|exists:ruangan,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'metode' => 'required|in:Tatap Muka,Teleconference,Hybrid',
            'status' => 'required|in:Terjadwal,Terlaksana,Ditunda,Dibatalkan',
            'code' => 'required|string|unique:jadwal_perkuliahan,code,' . $id
        ], [
            'tahun_akademik_id.required' => 'Tahun akademik wajib dipilih',
            'tahun_akademik_id.exists' => 'Tahun akademik tidak valid',
            'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih',
            'mata_kuliah_id.exists' => 'Mata kuliah tidak valid',
            'dosen_id.required' => 'Dosen wajib dipilih',
            'dosen_id.exists' => 'Dosen tidak valid',
            'ruang_id.exists' => 'Ruangan tidak valid',
            'hari.required' => 'Hari wajib dipilih',
            'hari.in' => 'Hari tidak valid',
            'jam_mulai.required' => 'Jam mulai wajib diisi',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid',
            'jam_selesai.required' => 'Jam selesai wajib diisi',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai',
            'metode.required' => 'Metode perkuliahan wajib dipilih',
            'metode.in' => 'Metode perkuliahan tidak valid',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
            'code.required' => 'Kode jadwal wajib diisi',
            'code.unique' => 'Kode jadwal sudah ada'
        ]);

        try {
            $user = Auth::user();
            
            $jadwalPerkuliahan->update([
                'tahun_akademik_id' => $request->tahun_akademik_id,
                'mata_kuliah_id' => $request->mata_kuliah_id,
                'dosen_id' => $request->dosen_id,
                'ruang_id' => $request->ruang_id,
                'hari' => $request->hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'metode' => $request->metode,
                'status' => $request->status,
                'code' => $request->code,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data jadwal perkuliahan berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $jadwalPerkuliahan = JadwalPerkuliahan::findOrFail($id);

            $user = Auth::user();
            $jadwalPerkuliahan->update(['deleted_by' => $user->id]);
            $jadwalPerkuliahan->delete();

            Alert::success('Berhasil', 'Data jadwal perkuliahan berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $jadwalPerkuliahan = JadwalPerkuliahan::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $jadwalPerkuliahan->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $jadwalPerkuliahan->restore();

            Alert::success('Berhasil', 'Data jadwal perkuliahan berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}