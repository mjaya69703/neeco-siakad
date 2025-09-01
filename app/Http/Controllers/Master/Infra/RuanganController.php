<?php

namespace App\Http\Controllers\Master\Infra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Infra\Ruangan;
use App\Models\Infra\Gedung;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class RuanganController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Ruangan';
        $data['pages'] = "Halaman Data Ruangan";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['ruangans'] = Ruangan::with('gedung')->orderBy('name')->get();
        $data['gedungs'] = Gedung::where('is_active', true)->orderBy('name')->get();
        $data['is_trash'] = false;

        return view('master.infra.ruangan-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Ruangan';
        $data['pages'] = "Halaman Data Ruangan yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['ruangans'] = Ruangan::onlyTrashed()->with('gedung')->get();
        $data['gedungs'] = Gedung::where('is_active', true)->orderBy('name')->get();
        $data['is_trash'] = true;

        return view('master.infra.ruangan-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gedung_id' => 'required|exists:gedung,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:ruangan,code',
            'jenis' => 'required|in:Kelas,Lab,Auditorium,Kantor,Perpustakaan,Lainnya',
            'kapasitas' => 'required|integer|min:1',
            'lantai' => 'required|integer|min:1',
            'is_ac' => 'boolean',
            'is_proyektor' => 'boolean',
            'is_wifi' => 'boolean',
            'is_sound_system' => 'boolean',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'is_active' => 'required|boolean'
        ], [
            'gedung_id.required' => 'Gedung wajib dipilih',
            'gedung_id.exists' => 'Gedung tidak valid',
            'name.required' => 'Nama ruangan wajib diisi',
            'code.required' => 'Kode ruangan wajib diisi',
            'code.unique' => 'Kode ruangan sudah ada',
            'jenis.required' => 'Jenis ruangan wajib dipilih',
            'jenis.in' => 'Jenis ruangan tidak valid',
            'kapasitas.required' => 'Kapasitas ruangan wajib diisi',
            'kapasitas.integer' => 'Kapasitas harus berupa angka',
            'lantai.required' => 'Lantai wajib diisi',
            'lantai.integer' => 'Lantai harus berupa angka',
            'kondisi.required' => 'Kondisi ruangan wajib dipilih',
            'kondisi.in' => 'Kondisi ruangan tidak valid',
            'is_active.required' => 'Status aktif wajib dipilih'
        ]);

        try {
            $user = Auth::user();
            
            Ruangan::create([
                'gedung_id' => $request->gedung_id,
                'name' => $request->name,
                'code' => $request->code,
                'jenis' => $request->jenis,
                'kapasitas' => $request->kapasitas,
                'lantai' => $request->lantai,
                'is_ac' => $request->has('is_ac') ? $request->is_ac : false,
                'is_proyektor' => $request->has('is_proyektor') ? $request->is_proyektor : false,
                'is_wifi' => $request->has('is_wifi') ? $request->is_wifi : false,
                'is_sound_system' => $request->has('is_sound_system') ? $request->is_sound_system : false,
                'kondisi' => $request->kondisi,
                'is_active' => $request->is_active,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data ruangan berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $ruangan = Ruangan::findOrFail($id);
        
        $request->validate([
            'gedung_id' => 'required|exists:gedung,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:ruangan,code,' . $id,
            'jenis' => 'required|in:Kelas,Lab,Auditorium,Kantor,Perpustakaan,Lainnya',
            'kapasitas' => 'required|integer|min:1',
            'lantai' => 'required|integer|min:1',
            'is_ac' => 'boolean',
            'is_proyektor' => 'boolean',
            'is_wifi' => 'boolean',
            'is_sound_system' => 'boolean',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'is_active' => 'required|boolean'
        ], [
            'gedung_id.required' => 'Gedung wajib dipilih',
            'gedung_id.exists' => 'Gedung tidak valid',
            'name.required' => 'Nama ruangan wajib diisi',
            'code.required' => 'Kode ruangan wajib diisi',
            'code.unique' => 'Kode ruangan sudah ada',
            'jenis.required' => 'Jenis ruangan wajib dipilih',
            'jenis.in' => 'Jenis ruangan tidak valid',
            'kapasitas.required' => 'Kapasitas ruangan wajib diisi',
            'kapasitas.integer' => 'Kapasitas harus berupa angka',
            'lantai.required' => 'Lantai wajib diisi',
            'lantai.integer' => 'Lantai harus berupa angka',
            'kondisi.required' => 'Kondisi ruangan wajib dipilih',
            'kondisi.in' => 'Kondisi ruangan tidak valid',
            'is_active.required' => 'Status aktif wajib dipilih'
        ]);

        try {
            $user = Auth::user();
            
            $ruangan->update([
                'gedung_id' => $request->gedung_id,
                'name' => $request->name,
                'code' => $request->code,
                'jenis' => $request->jenis,
                'kapasitas' => $request->kapasitas,
                'lantai' => $request->lantai,
                'is_ac' => $request->has('is_ac') ? $request->is_ac : false,
                'is_proyektor' => $request->has('is_proyektor') ? $request->is_proyektor : false,
                'is_wifi' => $request->has('is_wifi') ? $request->is_wifi : false,
                'is_sound_system' => $request->has('is_sound_system') ? $request->is_sound_system : false,
                'kondisi' => $request->kondisi,
                'is_active' => $request->is_active,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data ruangan berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $ruangan = Ruangan::findOrFail($id);

            $user = Auth::user();
            $ruangan->update(['deleted_by' => $user->id]);
            $ruangan->delete();

            Alert::success('Berhasil', 'Data ruangan berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $ruangan = Ruangan::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $ruangan->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $ruangan->restore();

            Alert::success('Berhasil', 'Data ruangan berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}