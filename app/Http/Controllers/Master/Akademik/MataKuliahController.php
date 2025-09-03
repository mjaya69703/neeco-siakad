<?php

namespace App\Http\Controllers\Master\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Akademik\MataKuliah;
use App\Models\Referensi\Semester;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class MataKuliahController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Akademik Mata Kuliah';
        $data['pages'] = "Halaman Data Mata Kuliah";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['mataKuliahs'] = MataKuliah::with('semester')->orderBy('name')->get();
        $data['semesters'] = Semester::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('master.akademik.mata-kuliah-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Akademik Mata Kuliah';
        $data['pages'] = "Halaman Data Mata Kuliah yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['mataKuliahs'] = MataKuliah::onlyTrashed()->with('semester')->get();
        $data['semesters'] = Semester::orderBy('name')->get();
        $data['is_trash'] = true;

        return view('master.akademik.mata-kuliah-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester_id' => 'required|exists:semesters,id',
            'name' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'code' => 'required|string|unique:mata_kuliah,code',
            'cover' => 'nullable|string|max:255',
            'beban_sks' => 'required|integer|min:1|max:10',
            'sks_teori' => 'required|integer|min:0|max:10',
            'sks_praktik' => 'required|integer|min:0|max:10',
            'sks_lapangan' => 'required|integer|min:0|max:10',
            'jenis' => 'required|in:Wajib,Pilihan,MKWU,MKU',
            'min_semester' => 'required|integer|min:1|max:14',
            'is_active' => 'required|boolean'
        ], [
            'semester_id.required' => 'Semester wajib dipilih',
            'semester_id.exists' => 'Semester tidak valid',
            'name.required' => 'Nama mata kuliah wajib diisi',
            'code.required' => 'Kode mata kuliah wajib diisi',
            'code.unique' => 'Kode mata kuliah sudah ada',
            'beban_sks.required' => 'Beban SKS wajib diisi',
            'beban_sks.integer' => 'Beban SKS harus berupa angka',
            'jenis.required' => 'Jenis mata kuliah wajib dipilih',
            'jenis.in' => 'Jenis mata kuliah tidak valid',
            'min_semester.required' => 'Minimal semester wajib diisi',
            'min_semester.integer' => 'Minimal semester harus berupa angka',
            'is_active.required' => 'Status aktif wajib dipilih'
        ]);

        try {
            $user = Auth::user();
            
            MataKuliah::create([
                'semester_id' => $request->semester_id,
                'name' => $request->name,
                'name_en' => $request->name_en,
                'code' => $request->code,
                'cover' => $request->cover ?? 'default-mk.jpg',
                'beban_sks' => $request->beban_sks,
                'sks_teori' => $request->sks_teori,
                'sks_praktik' => $request->sks_praktik,
                'sks_lapangan' => $request->sks_lapangan,
                'jenis' => $request->jenis,
                'min_semester' => $request->min_semester,
                'is_active' => $request->is_active,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data mata kuliah berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);
        
        $request->validate([
            'semester_id' => 'required|exists:semesters,id',
            'name' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'code' => 'required|string|unique:mata_kuliah,code,' . $id,
            'cover' => 'nullable|string|max:255',
            'beban_sks' => 'required|integer|min:1|max:10',
            'sks_teori' => 'required|integer|min:0|max:10',
            'sks_praktik' => 'required|integer|min:0|max:10',
            'sks_lapangan' => 'required|integer|min:0|max:10',
            'jenis' => 'required|in:Wajib,Pilihan,MKWU,MKU',
            'min_semester' => 'required|integer|min:1|max:14',
            'is_active' => 'required|boolean'
        ], [
            'semester_id.required' => 'Semester wajib dipilih',
            'semester_id.exists' => 'Semester tidak valid',
            'name.required' => 'Nama mata kuliah wajib diisi',
            'code.required' => 'Kode mata kuliah wajib diisi',
            'code.unique' => 'Kode mata kuliah sudah ada',
            'beban_sks.required' => 'Beban SKS wajib diisi',
            'beban_sks.integer' => 'Beban SKS harus berupa angka',
            'jenis.required' => 'Jenis mata kuliah wajib dipilih',
            'jenis.in' => 'Jenis mata kuliah tidak valid',
            'min_semester.required' => 'Minimal semester wajib diisi',
            'min_semester.integer' => 'Minimal semester harus berupa angka',
            'is_active.required' => 'Status aktif wajib dipilih'
        ]);

        try {
            $user = Auth::user();
            
            $mataKuliah->update([
                'semester_id' => $request->semester_id,
                'name' => $request->name,
                'name_en' => $request->name_en,
                'code' => $request->code,
                'cover' => $request->cover ?? 'default-mk.jpg',
                'beban_sks' => $request->beban_sks,
                'sks_teori' => $request->sks_teori,
                'sks_praktik' => $request->sks_praktik,
                'sks_lapangan' => $request->sks_lapangan,
                'jenis' => $request->jenis,
                'min_semester' => $request->min_semester,
                'is_active' => $request->is_active,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data mata kuliah berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $mataKuliah = MataKuliah::findOrFail($id);

            $user = Auth::user();
            $mataKuliah->update(['deleted_by' => $user->id]);
            $mataKuliah->delete();

            Alert::success('Berhasil', 'Data mata kuliah berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $mataKuliah = MataKuliah::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $mataKuliah->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $mataKuliah->restore();

            Alert::success('Berhasil', 'Data mata kuliah berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}