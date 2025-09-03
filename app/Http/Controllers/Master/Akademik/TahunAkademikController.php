<?php

namespace App\Http\Controllers\Master\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Akademik\TahunAkademik;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class TahunAkademikController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Akademik Tahun Akademik';
        $data['pages'] = "Halaman Data Tahun Akademik";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['tahunAkademiks'] = TahunAkademik::orderBy('created_at', 'desc')->get();
        $data['is_trash'] = false;

        return view('master.akademik.tahun-akademik-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Akademik Tahun Akademik';
        $data['pages'] = "Halaman Data Tahun Akademik yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['tahunAkademiks'] = TahunAkademik::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        $data['is_trash'] = true;

        return view('master.akademik.tahun-akademik-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:tahun_akademik,code',
            'semester' => 'required|in:Ganjil,Genap,Pendek',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'is_active' => 'required|boolean'
        ], [
            'name.required' => 'Nama tahun akademik wajib diisi',
            'code.required' => 'Kode tahun akademik wajib diisi',
            'code.unique' => 'Kode tahun akademik sudah ada',
            'semester.required' => 'Semester wajib dipilih',
            'semester.in' => 'Semester tidak valid',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_mulai.date' => 'Tanggal mulai tidak valid',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.date' => 'Tanggal selesai tidak valid',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai',
            'is_active.required' => 'Status aktif wajib dipilih'
        ]);

        try {
            $user = Auth::user();
            
            TahunAkademik::create([
                'name' => $request->name,
                'code' => $request->code,
                'semester' => $request->semester,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'is_active' => $request->is_active,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data tahun akademik berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $tahunAkademik = TahunAkademik::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:tahun_akademik,code,' . $id,
            'semester' => 'required|in:Ganjil,Genap,Pendek',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'is_active' => 'required|boolean'
        ], [
            'name.required' => 'Nama tahun akademik wajib diisi',
            'code.required' => 'Kode tahun akademik wajib diisi',
            'code.unique' => 'Kode tahun akademik sudah ada',
            'semester.required' => 'Semester wajib dipilih',
            'semester.in' => 'Semester tidak valid',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_mulai.date' => 'Tanggal mulai tidak valid',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.date' => 'Tanggal selesai tidak valid',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai',
            'is_active.required' => 'Status aktif wajib dipilih'
        ]);

        try {
            $user = Auth::user();
            
            $tahunAkademik->update([
                'name' => $request->name,
                'code' => $request->code,
                'semester' => $request->semester,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'is_active' => $request->is_active,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data tahun akademik berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $tahunAkademik = TahunAkademik::findOrFail($id);

            $user = Auth::user();
            $tahunAkademik->update(['deleted_by' => $user->id]);
            $tahunAkademik->delete();

            Alert::success('Berhasil', 'Data tahun akademik berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $tahunAkademik = TahunAkademik::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $tahunAkademik->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $tahunAkademik->restore();

            Alert::success('Berhasil', 'Data tahun akademik berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}