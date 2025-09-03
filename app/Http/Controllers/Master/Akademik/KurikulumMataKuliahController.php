<?php

namespace App\Http\Controllers\Master\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Akademik\KurikulumMataKuliah;
use App\Models\Akademik\Kurikulum;
use App\Models\Akademik\MataKuliah;
use App\Models\Referensi\Semester;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class KurikulumMataKuliahController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Akademik Kurikulum Mata Kuliah';
        $data['pages'] = "Halaman Data Kurikulum Mata Kuliah";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['kurikulumMataKuliahs'] = KurikulumMataKuliah::with(['kurikulum', 'mataKuliah', 'semester'])->orderBy('created_at', 'desc')->get();
        $data['kurikulums'] = Kurikulum::orderBy('name')->get();
        $data['mataKuliahs'] = MataKuliah::where('is_active', true)->orderBy('name')->get();
        $data['semesters'] = Semester::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('master.akademik.kurikulum-mata-kuliah-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Akademik Kurikulum Mata Kuliah';
        $data['pages'] = "Halaman Data Kurikulum Mata Kuliah yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['kurikulumMataKuliahs'] = KurikulumMataKuliah::onlyTrashed()->with(['kurikulum', 'mataKuliah', 'semester'])->get();
        $data['kurikulums'] = Kurikulum::orderBy('name')->get();
        $data['mataKuliahs'] = MataKuliah::where('is_active', true)->orderBy('name')->get();
        $data['semesters'] = Semester::orderBy('name')->get();
        $data['is_trash'] = true;

        return view('master.akademik.kurikulum-mata-kuliah-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kurikulum_id' => 'required|exists:kurikulum,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'semester_id' => 'required|exists:semesters,id',
            'is_wajib' => 'required|boolean',
            'urutan' => 'required|integer|min:0',
            'sks_override' => 'nullable|integer|min:0|max:10',
            'catatan' => 'nullable|string'
        ], [
            'kurikulum_id.required' => 'Kurikulum wajib dipilih',
            'kurikulum_id.exists' => 'Kurikulum tidak valid',
            'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih',
            'mata_kuliah_id.exists' => 'Mata kuliah tidak valid',
            'semester_id.required' => 'Semester wajib dipilih',
            'semester_id.exists' => 'Semester tidak valid',
            'is_wajib.required' => 'Status wajib wajib dipilih',
            'urutan.required' => 'Urutan wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
            'sks_override.integer' => 'SKS override harus berupa angka',
            'sks_override.max' => 'SKS override maksimal 10'
        ]);

        // Check if mata kuliah is already in this kurikulum
        $existing = KurikulumMataKuliah::where('kurikulum_id', $request->kurikulum_id)
            ->where('mata_kuliah_id', $request->mata_kuliah_id)
            ->first();
            
        if ($existing) {
            Alert::error('Error', 'Mata kuliah sudah terdaftar di kurikulum ini');
            return redirect()->back();
        }

        try {
            $user = Auth::user();
            
            KurikulumMataKuliah::create([
                'kurikulum_id' => $request->kurikulum_id,
                'mata_kuliah_id' => $request->mata_kuliah_id,
                'semester_id' => $request->semester_id,
                'is_wajib' => $request->is_wajib,
                'urutan' => $request->urutan,
                'sks_override' => $request->sks_override,
                'catatan' => $request->catatan,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data kurikulum mata kuliah berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $kurikulumMataKuliah = KurikulumMataKuliah::findOrFail($id);
        
        $request->validate([
            'kurikulum_id' => 'required|exists:kurikulum,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'semester_id' => 'required|exists:semesters,id',
            'is_wajib' => 'required|boolean',
            'urutan' => 'required|integer|min:0',
            'sks_override' => 'nullable|integer|min:0|max:10',
            'catatan' => 'nullable|string'
        ], [
            'kurikulum_id.required' => 'Kurikulum wajib dipilih',
            'kurikulum_id.exists' => 'Kurikulum tidak valid',
            'mata_kuliah_id.required' => 'Mata kuliah wajib dipilih',
            'mata_kuliah_id.exists' => 'Mata kuliah tidak valid',
            'semester_id.required' => 'Semester wajib dipilih',
            'semester_id.exists' => 'Semester tidak valid',
            'is_wajib.required' => 'Status wajib wajib dipilih',
            'urutan.required' => 'Urutan wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
            'sks_override.integer' => 'SKS override harus berupa angka',
            'sks_override.max' => 'SKS override maksimal 10'
        ]);

        // Check if mata kuliah is already in this kurikulum (excluding current record)
        $existing = KurikulumMataKuliah::where('kurikulum_id', $request->kurikulum_id)
            ->where('mata_kuliah_id', $request->mata_kuliah_id)
            ->where('id', '!=', $id)
            ->first();
            
        if ($existing) {
            Alert::error('Error', 'Mata kuliah sudah terdaftar di kurikulum ini');
            return redirect()->back();
        }

        try {
            $user = Auth::user();
            
            $kurikulumMataKuliah->update([
                'kurikulum_id' => $request->kurikulum_id,
                'mata_kuliah_id' => $request->mata_kuliah_id,
                'semester_id' => $request->semester_id,
                'is_wajib' => $request->is_wajib,
                'urutan' => $request->urutan,
                'sks_override' => $request->sks_override,
                'catatan' => $request->catatan,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data kurikulum mata kuliah berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $kurikulumMataKuliah = KurikulumMataKuliah::findOrFail($id);

            $user = Auth::user();
            $kurikulumMataKuliah->update(['deleted_by' => $user->id]);
            $kurikulumMataKuliah->delete();

            Alert::success('Berhasil', 'Data kurikulum mata kuliah berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $kurikulumMataKuliah = KurikulumMataKuliah::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $kurikulumMataKuliah->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $kurikulumMataKuliah->restore();

            Alert::success('Berhasil', 'Data kurikulum mata kuliah berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}