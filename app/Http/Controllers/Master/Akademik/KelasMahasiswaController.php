<?php

namespace App\Http\Controllers\Master\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Akademik\KelasMahasiswa;
use App\Models\Akademik\KelasPerkuliahan;
use App\Models\Mahasiswa;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class KelasMahasiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Akademik Kelas Mahasiswa';
        $data['pages'] = "Halaman Data Kelas Mahasiswa";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['kelasMahasiswas'] = KelasMahasiswa::with(['kelas', 'mahasiswa'])->orderBy('created_at', 'desc')->get();
        $data['kelasPerkuliahans'] = KelasPerkuliahan::orderBy('name')->get();
        $data['mahasiswas'] = Mahasiswa::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('master.akademik.kelas-mahasiswa-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Akademik Kelas Mahasiswa';
        $data['pages'] = "Halaman Data Kelas Mahasiswa yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['kelasMahasiswas'] = KelasMahasiswa::onlyTrashed()->with(['kelas', 'mahasiswa'])->get();
        $data['kelasPerkuliahans'] = KelasPerkuliahan::orderBy('name')->get();
        $data['mahasiswas'] = Mahasiswa::orderBy('name')->get();
        $data['is_trash'] = true;

        return view('master.akademik.kelas-mahasiswa-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas_perkuliahan,id',
            'mahasiswa_id' => 'required|exists:mahasiswas,id'
        ], [
            'kelas_id.required' => 'Kelas perkuliahan wajib dipilih',
            'kelas_id.exists' => 'Kelas perkuliahan tidak valid',
            'mahasiswa_id.required' => 'Mahasiswa wajib dipilih',
            'mahasiswa_id.exists' => 'Mahasiswa tidak valid'
        ]);

        // Check if mahasiswa is already in this class
        $existing = KelasMahasiswa::where('kelas_id', $request->kelas_id)
            ->where('mahasiswa_id', $request->mahasiswa_id)
            ->first();
            
        if ($existing) {
            Alert::error('Error', 'Mahasiswa sudah terdaftar di kelas ini');
            return redirect()->back();
        }

        try {
            $user = Auth::user();
            
            KelasMahasiswa::create([
                'kelas_id' => $request->kelas_id,
                'mahasiswa_id' => $request->mahasiswa_id,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data kelas mahasiswa berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $kelasMahasiswa = KelasMahasiswa::findOrFail($id);
        
        $request->validate([
            'kelas_id' => 'required|exists:kelas_perkuliahan,id',
            'mahasiswa_id' => 'required|exists:mahasiswas,id'
        ], [
            'kelas_id.required' => 'Kelas perkuliahan wajib dipilih',
            'kelas_id.exists' => 'Kelas perkuliahan tidak valid',
            'mahasiswa_id.required' => 'Mahasiswa wajib dipilih',
            'mahasiswa_id.exists' => 'Mahasiswa tidak valid'
        ]);

        // Check if mahasiswa is already in this class (excluding current record)
        $existing = KelasMahasiswa::where('kelas_id', $request->kelas_id)
            ->where('mahasiswa_id', $request->mahasiswa_id)
            ->where('id', '!=', $id)
            ->first();
            
        if ($existing) {
            Alert::error('Error', 'Mahasiswa sudah terdaftar di kelas ini');
            return redirect()->back();
        }

        try {
            $user = Auth::user();
            
            $kelasMahasiswa->update([
                'kelas_id' => $request->kelas_id,
                'mahasiswa_id' => $request->mahasiswa_id,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data kelas mahasiswa berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $kelasMahasiswa = KelasMahasiswa::findOrFail($id);

            $user = Auth::user();
            $kelasMahasiswa->update(['deleted_by' => $user->id]);
            $kelasMahasiswa->delete();

            Alert::success('Berhasil', 'Data kelas mahasiswa berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $kelasMahasiswa = KelasMahasiswa::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $kelasMahasiswa->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $kelasMahasiswa->restore();

            Alert::success('Berhasil', 'Data kelas mahasiswa berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}