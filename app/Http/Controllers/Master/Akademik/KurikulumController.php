<?php

namespace App\Http\Controllers\Master\Akademik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Akademik\Kurikulum;
use App\Models\Akademik\ProgramStudi;
use App\Models\Akademik\TahunAkademik;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class KurikulumController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Akademik Kurikulum';
        $data['pages'] = "Halaman Data Kurikulum";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['kurikulums'] = Kurikulum::with(['programStudi', 'tahunAkademikAwal', 'tahunAkademikAkhir'])->orderBy('name')->get();
        $data['programStudi'] = ProgramStudi::where('is_active', true)->orderBy('name')->get();
        $data['tahunAkademik'] = TahunAkademik::orderBy('created_at', 'desc')->get();
        $data['is_trash'] = false;

        return view('master.akademik.kurikulum-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Akademik Kurikulum';
        $data['pages'] = "Halaman Data Kurikulum yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['kurikulums'] = Kurikulum::onlyTrashed()->with(['programStudi', 'tahunAkademikAwal', 'tahunAkademikAkhir'])->get();
        $data['programStudi'] = ProgramStudi::where('is_active', true)->orderBy('name')->get();
        $data['tahunAkademik'] = TahunAkademik::orderBy('created_at', 'desc')->get();
        $data['is_trash'] = true;

        return view('master.akademik.kurikulum-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_studi_id' => 'required|exists:program_studi,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:kurikulum,code',
            'deskripsi' => 'nullable|string',
            'tahun_berlaku' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'tahun_berakhir' => 'nullable|integer|min:tahun_berlaku|max:' . (date('Y') + 10),
            'awal_tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'akhir_tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'total_sks_lulus' => 'required|integer|min:1|max:300',
            'sks_wajib' => 'required|integer|min:0',
            'sks_pilihan' => 'required|integer|min:0',
            'semester_normal' => 'required|integer|min:1|max:14',
            'ipk_minimal' => 'required|numeric|min:0|max:4',
            'sk_penetapan' => 'nullable|string|max:255',
            'tanggal_sk' => 'nullable|date',
            'status' => 'required|in:Masih Berlaku,Tidak Berlaku'
        ], [
            'program_studi_id.required' => 'Program studi wajib dipilih',
            'program_studi_id.exists' => 'Program studi tidak valid',
            'name.required' => 'Nama kurikulum wajib diisi',
            'code.required' => 'Kode kurikulum wajib diisi',
            'code.unique' => 'Kode kurikulum sudah ada',
            'tahun_berlaku.required' => 'Tahun berlaku wajib diisi',
            'tahun_berlaku.integer' => 'Tahun berlaku harus berupa angka',
            'awal_tahun_akademik_id.required' => 'Tahun akademik awal wajib dipilih',
            'awal_tahun_akademik_id.exists' => 'Tahun akademik awal tidak valid',
            'akhir_tahun_akademik_id.required' => 'Tahun akademik akhir wajib dipilih',
            'akhir_tahun_akademik_id.exists' => 'Tahun akademik akhir tidak valid',
            'total_sks_lulus.required' => 'Total SKS lulus wajib diisi',
            'total_sks_lulus.integer' => 'Total SKS lulus harus berupa angka',
            'semester_normal.required' => 'Semester normal wajib diisi',
            'semester_normal.integer' => 'Semester normal harus berupa angka',
            'ipk_minimal.required' => 'IPK minimal wajib diisi',
            'ipk_minimal.numeric' => 'IPK minimal harus berupa angka',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid'
        ]);

        try {
            $user = Auth::user();
            
            Kurikulum::create([
                'program_studi_id' => $request->program_studi_id,
                'name' => $request->name,
                'code' => $request->code,
                'deskripsi' => $request->deskripsi,
                'tahun_berlaku' => $request->tahun_berlaku,
                'tahun_berakhir' => $request->tahun_berakhir,
                'awal_tahun_akademik_id' => $request->awal_tahun_akademik_id,
                'akhir_tahun_akademik_id' => $request->akhir_tahun_akademik_id,
                'total_sks_lulus' => $request->total_sks_lulus,
                'sks_wajib' => $request->sks_wajib,
                'sks_pilihan' => $request->sks_pilihan,
                'semester_normal' => $request->semester_normal,
                'ipk_minimal' => $request->ipk_minimal,
                'sk_penetapan' => $request->sk_penetapan,
                'tanggal_sk' => $request->tanggal_sk,
                'status' => $request->status,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data kurikulum berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $kurikulum = Kurikulum::findOrFail($id);
        
        $request->validate([
            'program_studi_id' => 'required|exists:program_studi,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:kurikulum,code,' . $id,
            'deskripsi' => 'nullable|string',
            'tahun_berlaku' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'tahun_berakhir' => 'nullable|integer|min:tahun_berlaku|max:' . (date('Y') + 10),
            'awal_tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'akhir_tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'total_sks_lulus' => 'required|integer|min:1|max:300',
            'sks_wajib' => 'required|integer|min:0',
            'sks_pilihan' => 'required|integer|min:0',
            'semester_normal' => 'required|integer|min:1|max:14',
            'ipk_minimal' => 'required|numeric|min:0|max:4',
            'sk_penetapan' => 'nullable|string|max:255',
            'tanggal_sk' => 'nullable|date',
            'status' => 'required|in:Masih Berlaku,Tidak Berlaku'
        ], [
            'program_studi_id.required' => 'Program studi wajib dipilih',
            'program_studi_id.exists' => 'Program studi tidak valid',
            'name.required' => 'Nama kurikulum wajib diisi',
            'code.required' => 'Kode kurikulum wajib diisi',
            'code.unique' => 'Kode kurikulum sudah ada',
            'tahun_berlaku.required' => 'Tahun berlaku wajib diisi',
            'tahun_berlaku.integer' => 'Tahun berlaku harus berupa angka',
            'awal_tahun_akademik_id.required' => 'Tahun akademik awal wajib dipilih',
            'awal_tahun_akademik_id.exists' => 'Tahun akademik awal tidak valid',
            'akhir_tahun_akademik_id.required' => 'Tahun akademik akhir wajib dipilih',
            'akhir_tahun_akademik_id.exists' => 'Tahun akademik akhir tidak valid',
            'total_sks_lulus.required' => 'Total SKS lulus wajib diisi',
            'total_sks_lulus.integer' => 'Total SKS lulus harus berupa angka',
            'semester_normal.required' => 'Semester normal wajib diisi',
            'semester_normal.integer' => 'Semester normal harus berupa angka',
            'ipk_minimal.required' => 'IPK minimal wajib diisi',
            'ipk_minimal.numeric' => 'IPK minimal harus berupa angka',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid'
        ]);

        try {
            $user = Auth::user();
            
            $kurikulum->update([
                'program_studi_id' => $request->program_studi_id,
                'name' => $request->name,
                'code' => $request->code,
                'deskripsi' => $request->deskripsi,
                'tahun_berlaku' => $request->tahun_berlaku,
                'tahun_berakhir' => $request->tahun_berakhir,
                'awal_tahun_akademik_id' => $request->awal_tahun_akademik_id,
                'akhir_tahun_akademik_id' => $request->akhir_tahun_akademik_id,
                'total_sks_lulus' => $request->total_sks_lulus,
                'sks_wajib' => $request->sks_wajib,
                'sks_pilihan' => $request->sks_pilihan,
                'semester_normal' => $request->semester_normal,
                'ipk_minimal' => $request->ipk_minimal,
                'sk_penetapan' => $request->sk_penetapan,
                'tanggal_sk' => $request->tanggal_sk,
                'status' => $request->status,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data kurikulum berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $kurikulum = Kurikulum::findOrFail($id);

            $user = Auth::user();
            $kurikulum->update(['deleted_by' => $user->id]);
            $kurikulum->delete();

            Alert::success('Berhasil', 'Data kurikulum berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $kurikulum = Kurikulum::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $kurikulum->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $kurikulum->restore();

            Alert::success('Berhasil', 'Data kurikulum berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}