<?php

namespace App\Http\Controllers\Referensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Referensi\Alamat;
use App\Models\User;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class AlamatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Alamat';
        $data['pages'] = "Halaman Data Alamat";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['alamats'] = Alamat::with(['owner'])->orderBy('created_at', 'desc')->get();
        $data['users'] = User::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('referensi.alamat-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Alamat';
        $data['pages'] = "Halaman Data Alamat yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['alamats'] = Alamat::onlyTrashed()->with(['owner'])->get();
        $data['users'] = User::orderBy('name')->get();
        $data['is_trash'] = true;

        return view('referensi.alamat-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:ktp,domisili',
            'alamat_lengkap' => 'required|string',
            // 'owner_type' => 'required|string',
            'owner_id' => 'required|integer',
            'kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kota_kabupaten' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10'
        ], [
            'tipe.required' => 'Tipe alamat wajib dipilih',
            'tipe.in' => 'Tipe alamat harus KTP atau Domisili',
            'alamat_lengkap.required' => 'Alamat lengkap wajib diisi',
            'owner_type.required' => 'Tipe pemilik wajib dipilih',
            'owner_id.required' => 'Pemilik alamat wajib dipilih'
        ]);

        try {
            $user = Auth::user();
            $checkUser = User::where('id', $request->owner_id)->first() ?: Mahasiswa::where('id', $request->owner_id)->first();
            
            Alamat::create([
                'tipe' => $request->tipe,
                'alamat_lengkap' => $request->alamat_lengkap,
                'owner_type' => get_class($checkUser),
                'owner_id' => $request->owner_id,
                'kelurahan' => $request->kelurahan,
                'kecamatan' => $request->kecamatan,
                'kota_kabupaten' => $request->kota_kabupaten,
                'provinsi' => $request->provinsi,
                'kode_pos' => $request->kode_pos,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data alamat berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $alamat = Alamat::findOrFail($id);
        
        $request->validate([
            'tipe' => 'required|in:ktp,domisili',
            'alamat_lengkap' => 'required|string',
            // 'owner_type' => 'required|string',
            'owner_id' => 'required|integer',
            'kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kota_kabupaten' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10'
        ], [
            'tipe.required' => 'Tipe alamat wajib dipilih',
            'tipe.in' => 'Tipe alamat harus KTP atau Domisili',
            'alamat_lengkap.required' => 'Alamat lengkap wajib diisi',
            'owner_type.required' => 'Tipe pemilik wajib dipilih',
            'owner_id.required' => 'Pemilik alamat wajib dipilih'
        ]);

        try {
            $user = Auth::user();
            $checkUser = User::where('id', $request->owner_id)->first() ?: Mahasiswa::where('id', $request->owner_id)->first();

            $alamat->update([
                'tipe' => $request->tipe,
                'alamat_lengkap' => $request->alamat_lengkap,
                'owner_type' => get_class($checkUser),
                'owner_id' => $request->owner_id,
                'kelurahan' => $request->kelurahan,
                'kecamatan' => $request->kecamatan,
                'kota_kabupaten' => $request->kota_kabupaten,
                'provinsi' => $request->provinsi,
                'kode_pos' => $request->kode_pos,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data alamat berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $alamat = Alamat::findOrFail($id);

            $user = Auth::user();
            $alamat->update(['deleted_by' => $user->id]);
            $alamat->delete();

            Alert::success('Berhasil', 'Data alamat berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $alamat = Alamat::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $alamat->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $alamat->restore();

            Alert::success('Berhasil', 'Data alamat berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}