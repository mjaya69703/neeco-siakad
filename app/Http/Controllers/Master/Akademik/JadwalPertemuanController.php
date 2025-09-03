<?php

namespace App\Http\Controllers\Master\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Akademik\JadwalPertemuan;
use App\Models\Akademik\JadwalPerkuliahan;
use App\Models\User;
use App\Models\Infra\Ruangan;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class JadwalPertemuanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Akademik Jadwal Pertemuan';
        $data['pages'] = "Halaman Data Jadwal Pertemuan";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['jadwalPertemuans'] = JadwalPertemuan::with(['jadwal', 'ruangan', 'dosen'])->orderBy('pertemuan_ke')->get();
        $data['jadwalPerkuliahans'] = JadwalPerkuliahan::orderBy('code')->get();
        $data['dosens'] = User::all();
        $data['ruangans'] = Ruangan::where('is_active', true)->orderBy('name')->get();
        $data['is_trash'] = false;

        return view('master.akademik.jadwal-pertemuan-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Akademik Jadwal Pertemuan';
        $data['pages'] = "Halaman Data Jadwal Pertemuan yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['jadwalPertemuans'] = JadwalPertemuan::onlyTrashed()->with(['jadwal', 'ruangan', 'dosen'])->get();
        $data['jadwalPerkuliahans'] = JadwalPerkuliahan::orderBy('code')->get();
        $data['dosens'] = User::all();
        $data['ruangans'] = Ruangan::where('is_active', true)->orderBy('name')->get();
        $data['is_trash'] = true;

        return view('master.akademik.jadwal-pertemuan-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_perkuliahan,id',
            'pertemuan_ke' => 'required|integer|min:1|max:16',
            'tanggal' => 'nullable|date',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i|after:jam_mulai',
            'ruang_id' => 'nullable|exists:ruangan,id',
            'dosen_id' => 'nullable|exists:users,id',
            'metode' => 'nullable|in:Tatap Muka,Teleconference,Hybrid',
            'link' => 'nullable|string|max:255',
            'materi' => 'nullable|string',
            'is_realisasi' => 'required|boolean'
        ], [
            'jadwal_id.required' => 'Jadwal perkuliahan wajib dipilih',
            'jadwal_id.exists' => 'Jadwal perkuliahan tidak valid',
            'pertemuan_ke.required' => 'Pertemuan ke wajib diisi',
            'pertemuan_ke.integer' => 'Pertemuan ke harus berupa angka',
            'tanggal.date' => 'Format tanggal tidak valid',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai',
            'ruang_id.exists' => 'Ruangan tidak valid',
            'dosen_id.exists' => 'Dosen tidak valid',
            'metode.in' => 'Metode tidak valid',
            'link.max' => 'Link maksimal 255 karakter',
            'is_realisasi.required' => 'Status realisasi wajib dipilih'
        ]);

        try {
            $user = Auth::user();
            
            JadwalPertemuan::create([
                'jadwal_id' => $request->jadwal_id,
                'pertemuan_ke' => $request->pertemuan_ke,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'ruang_id' => $request->ruang_id,
                'dosen_id' => $request->dosen_id,
                'metode' => $request->metode,
                'link' => $request->link,
                'materi' => $request->materi,
                'is_realisasi' => $request->is_realisasi,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data jadwal pertemuan berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $jadwalPertemuan = JadwalPertemuan::findOrFail($id);
        
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_perkuliahan,id',
            'pertemuan_ke' => 'required|integer|min:1|max:16',
            'tanggal' => 'nullable|date',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i|after:jam_mulai',
            'ruang_id' => 'nullable|exists:ruangan,id',
            'dosen_id' => 'nullable|exists:users,id',
            'metode' => 'nullable|in:Tatap Muka,Teleconference,Hybrid',
            'link' => 'nullable|string|max:255',
            'materi' => 'nullable|string',
            'is_realisasi' => 'required|boolean'
        ], [
            'jadwal_id.required' => 'Jadwal perkuliahan wajib dipilih',
            'jadwal_id.exists' => 'Jadwal perkuliahan tidak valid',
            'pertemuan_ke.required' => 'Pertemuan ke wajib diisi',
            'pertemuan_ke.integer' => 'Pertemuan ke harus berupa angka',
            'tanggal.date' => 'Format tanggal tidak valid',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai',
            'ruang_id.exists' => 'Ruangan tidak valid',
            'dosen_id.exists' => 'Dosen tidak valid',
            'metode.in' => 'Metode tidak valid',
            'link.max' => 'Link maksimal 255 karakter',
            'is_realisasi.required' => 'Status realisasi wajib dipilih'
        ]);

        try {
            $user = Auth::user();
            
            $jadwalPertemuan->update([
                'jadwal_id' => $request->jadwal_id,
                'pertemuan_ke' => $request->pertemuan_ke,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'ruang_id' => $request->ruang_id,
                'dosen_id' => $request->dosen_id,
                'metode' => $request->metode,
                'link' => $request->link,
                'materi' => $request->materi,
                'is_realisasi' => $request->is_realisasi,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data jadwal pertemuan berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $jadwalPertemuan = JadwalPertemuan::findOrFail($id);

            $user = Auth::user();
            $jadwalPertemuan->update(['deleted_by' => $user->id]);
            $jadwalPertemuan->delete();

            Alert::success('Berhasil', 'Data jadwal pertemuan berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $jadwalPertemuan = JadwalPertemuan::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $jadwalPertemuan->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $jadwalPertemuan->restore();

            Alert::success('Berhasil', 'Data jadwal pertemuan berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}