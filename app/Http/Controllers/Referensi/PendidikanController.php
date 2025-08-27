<?php

namespace App\Http\Controllers\Referensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\User;
use App\Models\Referensi\Pendidikan;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class PendidikanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Pendidikan';
        $data['pages'] = "Halaman Data Pendidikan";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['pendidikans'] = Pendidikan::with(['owner'])->orderBy('created_at', 'desc')->get(); 
        $data['users'] = User::all();
        $data['is_trash'] = false;

        return view('referensi.pendidikan-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Pendidikan';
        $data['pages'] = "Halaman Data Pendidikan yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['pendidikans'] = Pendidikan::onlyTrashed()->with(['owner'])->get();
        $data['users'] = User::orderBy('name')->get();
        $data['is_trash'] = true;

        return view('referensi.pendidikan-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenjang' => 'required|in:Paket C,SMA,SMK,D3,S1,S2,S3',
            'nama_institusi' => 'required|string|max:255',
            // 'owner_type' => 'required|string',
            'owner_id' => 'required|integer',
            'jurusan' => 'nullable|string|max:255',
            'tahun_masuk' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'tahun_lulus' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),
            'ipk' => 'nullable|string|max:10',
            'alamat' => 'nullable|string'
        ], [
            'jenjang.required' => 'Jenjang pendidikan wajib dipilih',
            'jenjang.in' => 'Jenjang pendidikan tidak valid',
            'nama_institusi.required' => 'Nama institusi wajib diisi',
            'owner_type.required' => 'Tipe pemilik wajib dipilih',
            'owner_id.required' => 'Pemilik data wajib dipilih',
            'tahun_masuk.min' => 'Tahun masuk tidak valid',
            'tahun_masuk.max' => 'Tahun masuk tidak valid',
            'tahun_lulus.min' => 'Tahun lulus tidak valid',
            'tahun_lulus.max' => 'Tahun lulus tidak valid'
        ]);

        try {
            $user = Auth::user();
            $checkUser = User::where('id', $request->owner_id)->first();

            if (!$checkUser) {
                Alert::error('Error', 'Pemilik data tidak ditemukan');
                return redirect()->back();
            }

            Pendidikan::create([
                'jenjang' => $request->jenjang,
                'nama_institusi' => $request->nama_institusi,
                'owner_type' => get_class($checkUser),
                'owner_id' => $request->owner_id,
                'jurusan' => $request->jurusan,
                'tahun_masuk' => $request->tahun_masuk,
                'tahun_lulus' => $request->tahun_lulus,
                'ipk' => $request->ipk,
                'alamat' => $request->alamat,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data pendidikan berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $pendidikan = Pendidikan::findOrFail($id);
        
        $request->validate([
            'jenjang' => 'required|in:Paket C,SMA,SMK,D3,S1,S2,S3',
            'nama_institusi' => 'required|string|max:255',
            // 'owner_type' => 'required|string',
            'owner_id' => 'required|integer',
            'jurusan' => 'nullable|string|max:255',
            'tahun_masuk' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'tahun_lulus' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),
            'ipk' => 'nullable|string|max:10',
            'alamat' => 'nullable|string'
        ], [
            'jenjang.required' => 'Jenjang pendidikan wajib dipilih',
            'jenjang.in' => 'Jenjang pendidikan tidak valid',
            'nama_institusi.required' => 'Nama institusi wajib diisi',
            'owner_type.required' => 'Tipe pemilik wajib dipilih',
            'owner_id.required' => 'Pemilik data wajib dipilih',
            'tahun_masuk.min' => 'Tahun masuk tidak valid',
            'tahun_masuk.max' => 'Tahun masuk tidak valid',
            'tahun_lulus.min' => 'Tahun lulus tidak valid',
            'tahun_lulus.max' => 'Tahun lulus tidak valid'
        ]);

        try {
            $user = Auth::user();
            $checkUser = User::where('id', $request->owner_id)->first();

            if (!$checkUser) {
                Alert::error('Error', 'Pemilik data tidak ditemukan');
                return redirect()->back();
            }

            $pendidikan->update([
                'jenjang' => $request->jenjang,
                'nama_institusi' => $request->nama_institusi,
                'owner_type' => get_class($checkUser),
                'owner_id' => $request->owner_id,
                'jurusan' => $request->jurusan,
                'tahun_masuk' => $request->tahun_masuk,
                'tahun_lulus' => $request->tahun_lulus,
                'ipk' => $request->ipk,
                'alamat' => $request->alamat,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data pendidikan berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $pendidikan = Pendidikan::findOrFail($id);

            $user = Auth::user();
            $pendidikan->update(['deleted_by' => $user->id]);
            $pendidikan->delete();

            Alert::success('Berhasil', 'Data pendidikan berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $pendidikan = Pendidikan::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $pendidikan->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $pendidikan->restore();

            Alert::success('Berhasil', 'Data pendidikan berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}