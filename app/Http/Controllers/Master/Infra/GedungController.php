<?php

namespace App\Http\Controllers\Master\Infra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Infra\Gedung;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class GedungController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Gedung';
        $data['pages'] = "Halaman Data Gedung";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['gedungs'] = Gedung::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('master.infra.gedung-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Gedung';
        $data['pages'] = "Halaman Data Gedung yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['gedungs'] = Gedung::onlyTrashed()->get();
        $data['is_trash'] = true;

        return view('master.infra.gedung-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:gedung,code',
            'alamat' => 'nullable|string',
            'jumlah_lantai' => 'required|integer|min:1',
            'tahun_dibangun' => 'nullable|integer|min:1900|max:' . date('Y'),
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'is_active' => 'boolean' // Changed from required|boolean to just boolean
        ], [
            'name.required' => 'Nama gedung wajib diisi',
            'code.required' => 'Kode gedung wajib diisi',
            'code.unique' => 'Kode gedung sudah ada',
            'jumlah_lantai.required' => 'Jumlah lantai wajib diisi',
            'jumlah_lantai.integer' => 'Jumlah lantai harus berupa angka',
            'tahun_dibangun.integer' => 'Tahun dibangun harus berupa angka',
            'tahun_dibangun.min' => 'Tahun dibangun tidak valid',
            'tahun_dibangun.max' => 'Tahun dibangun tidak boleh melebihi tahun sekarang',
            'kondisi.required' => 'Kondisi gedung wajib dipilih',
            'kondisi.in' => 'Kondisi gedung tidak valid'
            // Removed is_active.required error message
        ]);

        try {
            $user = Auth::user();
            
            Gedung::create([
                'name' => $request->name,
                'code' => $request->code,
                'alamat' => $request->alamat,
                'jumlah_lantai' => $request->jumlah_lantai,
                'tahun_dibangun' => $request->tahun_dibangun,
                'kondisi' => $request->kondisi,
                'is_active' => $request->has('is_active') ? $request->is_active : false, // Added proper handling
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data gedung berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $gedung = Gedung::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:gedung,code,' . $id,
            'alamat' => 'nullable|string',
            'jumlah_lantai' => 'required|integer|min:1',
            'tahun_dibangun' => 'nullable|integer|min:1900|max:' . date('Y'),
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'is_active' => 'boolean' // Changed from required|boolean to just boolean
        ], [
            'name.required' => 'Nama gedung wajib diisi',
            'code.required' => 'Kode gedung wajib diisi',
            'code.unique' => 'Kode gedung sudah ada',
            'jumlah_lantai.required' => 'Jumlah lantai wajib diisi',
            'jumlah_lantai.integer' => 'Jumlah lantai harus berupa angka',
            'tahun_dibangun.integer' => 'Tahun dibangun harus berupa angka',
            'tahun_dibangun.min' => 'Tahun dibangun tidak valid',
            'tahun_dibangun.max' => 'Tahun dibangun tidak boleh melebihi tahun sekarang',
            'kondisi.required' => 'Kondisi gedung wajib dipilih',
            'kondisi.in' => 'Kondisi gedung tidak valid'
            // Removed is_active.required error message
        ]);

        try {
            $user = Auth::user();
            
            $gedung->update([
                'name' => $request->name,
                'code' => $request->code,
                'alamat' => $request->alamat,
                'jumlah_lantai' => $request->jumlah_lantai,
                'tahun_dibangun' => $request->tahun_dibangun,
                'kondisi' => $request->kondisi,
                'is_active' => $request->has('is_active') ? $request->is_active : false, // Added proper handling
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data gedung berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $gedung = Gedung::findOrFail($id);
            
            // Check if gedung is being used by ruangans
            if ($gedung->ruangans()->count() > 0) {
                Alert::warning('Peringatan', 'Data gedung tidak dapat dihapus karena masih digunakan oleh ruangan');
                return redirect()->back();
            }

            $user = Auth::user();
            $gedung->update(['deleted_by' => $user->id]);
            $gedung->delete();

            Alert::success('Berhasil', 'Data gedung berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $gedung = Gedung::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $gedung->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $gedung->restore();

            Alert::success('Berhasil', 'Data gedung berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}