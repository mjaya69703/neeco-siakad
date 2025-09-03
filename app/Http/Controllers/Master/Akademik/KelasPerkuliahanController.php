<?php

namespace App\Http\Controllers\Master\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Akademik\KelasPerkuliahan;
use App\Models\Akademik\TahunAkademik;
use App\Models\Akademik\ProgramStudi;
use App\Models\Akademik\MataKuliah;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class KelasPerkuliahanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Akademik Kelas Perkuliahan';
        $data['pages'] = "Halaman Data Kelas Perkuliahan";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['kelasPerkuliahans'] = KelasPerkuliahan::with(['tahunAkademik', 'programStudi', 'mataKuliah'])->orderBy('name')->get();
        $data['tahunAkademiks'] = TahunAkademik::where('is_active', true)->orderBy('created_at', 'desc')->get();
        $data['programStudis'] = ProgramStudi::where('is_active', true)->orderBy('name')->get();
        $data['mataKuliahs'] = MataKuliah::where('is_active', true)->orderBy('name')->get();
        $data['is_trash'] = false;

        return view('master.akademik.kelas-perkuliahan-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Akademik Kelas Perkuliahan';
        $data['pages'] = "Halaman Data Kelas Perkuliahan yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['kelasPerkuliahans'] = KelasPerkuliahan::onlyTrashed()->with(['tahunAkademik', 'programStudi', 'mataKuliah'])->get();
        $data['tahunAkademiks'] = TahunAkademik::where('is_active', true)->orderBy('created_at', 'desc')->get();
        $data['programStudis'] = ProgramStudi::where('is_active', true)->orderBy('name')->get();
        $data['mataKuliahs'] = MataKuliah::where('is_active', true)->orderBy('name')->get();
        $data['is_trash'] = true;

        return view('master.akademik.kelas-perkuliahan-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'program_studi_id' => 'required|exists:program_studi,id',
            'mata_kuliah_id' => 'nullable|exists:mata_kuliah,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:kelas_perkuliahan,code',
            'kapasitas' => 'nullable|integer|min:1|max:1000'
        ], [
            'tahun_akademik_id.required' => 'Tahun akademik wajib dipilih',
            'tahun_akademik_id.exists' => 'Tahun akademik tidak valid',
            'program_studi_id.required' => 'Program studi wajib dipilih',
            'program_studi_id.exists' => 'Program studi tidak valid',
            'mata_kuliah_id.exists' => 'Mata kuliah tidak valid',
            'name.required' => 'Nama kelas wajib diisi',
            'code.required' => 'Kode kelas wajib diisi',
            'code.unique' => 'Kode kelas sudah ada',
            'kapasitas.integer' => 'Kapasitas harus berupa angka'
        ]);

        try {
            $user = Auth::user();
            
            KelasPerkuliahan::create([
                'tahun_akademik_id' => $request->tahun_akademik_id,
                'program_studi_id' => $request->program_studi_id,
                'mata_kuliah_id' => $request->mata_kuliah_id,
                'name' => $request->name,
                'code' => $request->code,
                'kapasitas' => $request->kapasitas,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data kelas perkuliahan berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $kelasPerkuliahan = KelasPerkuliahan::findOrFail($id);
        
        $request->validate([
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'program_studi_id' => 'required|exists:program_studi,id',
            'mata_kuliah_id' => 'nullable|exists:mata_kuliah,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:kelas_perkuliahan,code,' . $id,
            'kapasitas' => 'nullable|integer|min:1|max:1000'
        ], [
            'tahun_akademik_id.required' => 'Tahun akademik wajib dipilih',
            'tahun_akademik_id.exists' => 'Tahun akademik tidak valid',
            'program_studi_id.required' => 'Program studi wajib dipilih',
            'program_studi_id.exists' => 'Program studi tidak valid',
            'mata_kuliah_id.exists' => 'Mata kuliah tidak valid',
            'name.required' => 'Nama kelas wajib diisi',
            'code.required' => 'Kode kelas wajib diisi',
            'code.unique' => 'Kode kelas sudah ada',
            'kapasitas.integer' => 'Kapasitas harus berupa angka'
        ]);

        try {
            $user = Auth::user();
            
            $kelasPerkuliahan->update([
                'tahun_akademik_id' => $request->tahun_akademik_id,
                'program_studi_id' => $request->program_studi_id,
                'mata_kuliah_id' => $request->mata_kuliah_id,
                'name' => $request->name,
                'code' => $request->code,
                'kapasitas' => $request->kapasitas,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data kelas perkuliahan berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $kelasPerkuliahan = KelasPerkuliahan::findOrFail($id);

            $user = Auth::user();
            $kelasPerkuliahan->update(['deleted_by' => $user->id]);
            $kelasPerkuliahan->delete();

            Alert::success('Berhasil', 'Data kelas perkuliahan berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $kelasPerkuliahan = KelasPerkuliahan::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $kelasPerkuliahan->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $kelasPerkuliahan->restore();

            Alert::success('Berhasil', 'Data kelas perkuliahan berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}