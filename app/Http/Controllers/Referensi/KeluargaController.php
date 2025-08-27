<?php

namespace App\Http\Controllers\Referensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Referensi\Keluarga;
use App\Models\User;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class KeluargaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Keluarga';
        $data['pages'] = "Halaman Data Keluarga";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['keluargas'] = Keluarga::with(['owner'])->orderBy('created_at', 'desc')->get();
        $data['users'] = User::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('referensi.keluarga-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Keluarga';
        $data['pages'] = "Halaman Data Keluarga yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['keluargas'] = Keluarga::onlyTrashed()->with(['owner'])->get();
        $data['users'] = User::orderBy('name')->get();
        $data['is_trash'] = true;

        return view('referensi.keluarga-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hubungan' => 'required|in:Ayah,Ibu,Suami,Istri,Anak,Kakak,Adik,Wali',
            'nama' => 'required|string|max:255',
            // 'owner_type' => 'required|string',
            'owner_id' => 'required|integer',
            'pekerjaan' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:15',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'penghasilan' => 'nullable|integer|min:0',
            'alamat' => 'nullable|string'
        ], [
            'hubungan.required' => 'Hubungan keluarga wajib dipilih',
            'hubungan.in' => 'Hubungan keluarga tidak valid',
            'nama.required' => 'Nama keluarga wajib diisi',
            'owner_type.required' => 'Tipe pemilik wajib dipilih',
            'owner_id.required' => 'Pemilik data wajib dipilih',
            'penghasilan.integer' => 'Penghasilan harus berupa angka',
            'penghasilan.min' => 'Penghasilan tidak boleh negatif'
        ]);

        try {
            $user = Auth::user();
            $checkUser = User::where('id', $request->owner_id)->first() ?: Mahasiswa::where('id', $request->owner_id)->first();

            Keluarga::create([
                'hubungan' => $request->hubungan,
                'nama' => $request->nama,
                'owner_type' => get_class($checkUser),
                'owner_id' => $request->owner_id,
                'pekerjaan' => $request->pekerjaan,
                'telepon' => $request->telepon,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'penghasilan' => $request->penghasilan,
                'alamat' => $request->alamat,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data keluarga berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $keluarga = Keluarga::findOrFail($id);
        
        $request->validate([
            'hubungan' => 'required|in:Ayah,Ibu,Suami,Istri,Anak,Kakak,Adik,Wali',
            'nama' => 'required|string|max:255',
            // 'owner_type' => 'required|string',
            'owner_id' => 'required|integer',
            'pekerjaan' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:15',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'penghasilan' => 'nullable|integer|min:0',
            'alamat' => 'nullable|string'
        ], [
            'hubungan.required' => 'Hubungan keluarga wajib dipilih',
            'hubungan.in' => 'Hubungan keluarga tidak valid',
            'nama.required' => 'Nama keluarga wajib diisi',
            'owner_type.required' => 'Tipe pemilik wajib dipilih',
            'owner_id.required' => 'Pemilik data wajib dipilih',
            'penghasilan.integer' => 'Penghasilan harus berupa angka',
            'penghasilan.min' => 'Penghasilan tidak boleh negatif'
        ]);

        try {
            $user = Auth::user();
            $checkUser = User::where('id', $request->owner_id)->first() ?: Mahasiswa::where('id', $request->owner_id)->first();

            $keluarga->update([
                'hubungan' => $request->hubungan,
                'nama' => $request->nama,
                'owner_type' => get_class($checkUser),
                'owner_id' => $request->owner_id,
                'pekerjaan' => $request->pekerjaan,
                'telepon' => $request->telepon,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'penghasilan' => $request->penghasilan,
                'alamat' => $request->alamat,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data keluarga berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $keluarga = Keluarga::findOrFail($id);

            $user = Auth::user();
            $keluarga->update(['deleted_by' => $user->id]);
            $keluarga->delete();

            Alert::success('Berhasil', 'Data keluarga berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $keluarga = Keluarga::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $keluarga->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $keluarga->restore();

            Alert::success('Berhasil', 'Data keluarga berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}