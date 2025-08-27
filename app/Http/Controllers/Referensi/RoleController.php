<?php

namespace App\Http\Controllers\Referensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
// Use Models
use App\Models\Referensi\Role;
use App\Models\Pengaturan\System;
use App\Models\Pengaturan\Kampus;

class RoleController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Role';
        $data['pages'] = "Halaman Data Role";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['roles'] = Role::orderBy('name')->get();
        $data['is_trash'] = false;

        return view('referensi.role-index', $data, compact('user'));
    }

    public function trash()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = 'Referensi Role';
        $data['pages'] = "Halaman Data Role yang Dihapus";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();
        $data['roles'] = Role::onlyTrashed()->get();
        $data['is_trash'] = true;

        return view('referensi.role-index', $data, compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'slug' => 'required|string|max:255|unique:roles,slug',
            'prefix' => 'required|string|max:10|unique:roles,prefix'
        ], [
            'name.required' => 'Nama role wajib diisi',
            'name.unique' => 'Nama role sudah ada',
            'slug.required' => 'Slug wajib diisi',
            'slug.unique' => 'Slug sudah ada',
            'prefix.required' => 'Prefix wajib diisi',
            'prefix.unique' => 'Prefix sudah ada'
        ]);

        try {
            $user = Auth::user();
            
            Role::create([
                'name' => $request->name,
                'slug' => Str::slug($request->slug),
                'prefix' => strtoupper($request->prefix),
                'created_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data role berhasil ditambahkan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'slug' => 'required|string|max:255|unique:roles,slug,' . $id,
            'prefix' => 'required|string|max:10|unique:roles,prefix,' . $id
        ], [
            'name.required' => 'Nama role wajib diisi',
            'name.unique' => 'Nama role sudah ada',
            'slug.required' => 'Slug wajib diisi',
            'slug.unique' => 'Slug sudah ada',
            'prefix.required' => 'Prefix wajib diisi',
            'prefix.unique' => 'Prefix sudah ada'
        ]);

        try {
            $user = Auth::user();
            
            $role->update([
                'name' => $request->name,
                'slug' => Str::slug($request->slug),
                'prefix' => strtoupper($request->prefix),
                'updated_by' => $user->id
            ]);

            Alert::success('Berhasil', 'Data role berhasil diperbarui');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            
            $user = Auth::user();
            $role->update(['deleted_by' => $user->id]);
            $role->delete();

            Alert::success('Berhasil', 'Data role berhasil dihapus');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $role = Role::onlyTrashed()->findOrFail($id);

            $user = Auth::user();
            $role->update(['updated_by' => $user->id, 'deleted_by' => null]);
            $role->restore();

            Alert::success('Berhasil', 'Data role berhasil dikembalikan');
            return redirect()->back();

        } catch (\Throwable $th) {
            Alert::error('Error', 'Terjadi kesalahan: ' . $th->getMessage());
            return redirect()->back();
        }
    }
}