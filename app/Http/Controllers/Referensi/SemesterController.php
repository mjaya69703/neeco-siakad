<?php

namespace App\Http\Controllers\Referensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// Use Models
use App\Models\Referensi\Semester;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class SemesterController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Semester';
        $data['pages'] = "Halaman Data Semester";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['semesters'] = Semester::all();
        $data['is_trash'] = false;

        return view('referensi.semester-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Semester';
        $data['pages'] = "Halaman Data Semester yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['semesters'] = Semester::onlyTrashed()->get();
        $data['is_trash'] = true;

        return view('referensi.semester-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:semesters,name'
        ], [
            'name.required' => 'Nama semester wajib diisi',
            'name.unique' => 'Nama semester sudah ada'
        ]);

        try {
            $user = Auth::user();
            
            Semester::create([
                'name' => $request->name,
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data semester berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $semester = Semester::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:semesters,name,' . $id
        ], [
            'name.required' => 'Nama semester wajib diisi',
            'name.unique' => 'Nama semester sudah ada'
        ]);

        try {
            $user = Auth::user();
            
            $semester->update([
                'name' => $request->name,
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data semester berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $semester = Semester::findOrFail($id);
            
            $user = Auth::user();
            $semester->update(['deleted_by' => $user->id]);
            $semester->delete();

            Alert::success('Berhasil', 'Data semester berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $semester = Semester::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $semester->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $semester->restore();

            Alert::success('Berhasil', 'Data semester berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}