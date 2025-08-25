<?php

namespace App\Http\Requests\Private;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class profileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = Auth::id() ?? 0;
        
        return [
            // Basic Information
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $userId,
            'email' => 'required|email|unique:users,email,' . $userId,
            'phone' => 'required|string|max:15|unique:users,phone,' . $userId,
            
            // Photo
            'photo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            
            // Personal Data
            'jenis_kelamin_id' => 'nullable|exists:jenis_kelamins,id',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date|before:today',
            'agama_id' => 'nullable|exists:agamas,id',
            'golongan_darah_id' => 'nullable|exists:golongan_darahs,id',
            'kewarganegaraan_id' => 'nullable|exists:kewarganegaraans,id',
            'tinggi_badan' => 'nullable|numeric|min:50|max:300',
            'berat_badan' => 'nullable|numeric|min:20|max:500',
            
            // Social Media
            'link_ig' => 'nullable|string|max:255',
            'link_fb' => 'nullable|string|max:255',
            'link_in' => 'nullable|string|max:255',
            
            // Identity Numbers
            'nomor_kk' => 'nullable|string|size:16|unique:users,nomor_kk,' . $userId,
            'nomor_ktp' => 'nullable|string|size:16|unique:users,nomor_ktp,' . $userId,
            'nomor_npwp' => 'nullable|string|size:15|unique:users,nomor_npwp,' . $userId,
            
            // Address KTP
            'alamat_ktp.alamat_lengkap' => 'nullable|string|max:500',
            'alamat_ktp.rt' => 'nullable|string|max:3',
            'alamat_ktp.rw' => 'nullable|string|max:3',
            'alamat_ktp.kelurahan' => 'nullable|string|max:255',
            'alamat_ktp.kecamatan' => 'nullable|string|max:255',
            'alamat_ktp.kota_kabupaten' => 'nullable|string|max:255',
            'alamat_ktp.provinsi' => 'nullable|string|max:255',
            'alamat_ktp.kode_pos' => 'nullable|string|max:10',
            
            // Address Domisili
            'alamat_domisili.alamat_lengkap' => 'nullable|string|max:500',
            'alamat_domisili.rt' => 'nullable|string|max:3',
            'alamat_domisili.rw' => 'nullable|string|max:3',
            'alamat_domisili.kelurahan' => 'nullable|string|max:255',
            'alamat_domisili.kecamatan' => 'nullable|string|max:255',
            'alamat_domisili.kota_kabupaten' => 'nullable|string|max:255',
            'alamat_domisili.provinsi' => 'nullable|string|max:255',
            'alamat_domisili.kode_pos' => 'nullable|string|max:10',
            
            // Education
            'pendidikan.*.jenjang' => 'required_with:pendidikan|string|in:Paket C,SMA,SMK,D3,S1,S2,S3',
            'pendidikan.*.nama_institusi' => 'required_with:pendidikan|string|max:255',
            'pendidikan.*.jurusan' => 'nullable|string|max:255',
            'pendidikan.*.tahun_masuk' => 'nullable|integer|min:1950|max:' . date('Y'),
            'pendidikan.*.tahun_lulus' => 'nullable|integer|min:1950|max:' . (date('Y') + 10),
            'pendidikan.*.ipk' => 'nullable|string|max:10',
            'pendidikan.*.alamat' => 'nullable|string|max:500',
            
            // Family
            'keluarga.*.hubungan' => 'required_with:keluarga|string|in:Ayah,Ibu,Suami,Istri,Anak,Kakak,Adik,Wali',
            'keluarga.*.nama' => 'required_with:keluarga|string|max:255',
            'keluarga.*.pekerjaan' => 'nullable|string|max:255',
            'keluarga.*.telepon' => 'nullable|string|max:15',
            'keluarga.*.tempat_lahir' => 'nullable|string|max:255',
            'keluarga.*.tanggal_lahir' => 'nullable|date|before:today',
            'keluarga.*.penghasilan' => 'nullable|numeric|min:0',
            'keluarga.*.alamat' => 'nullable|string|max:500',
            
            // Password
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|min:8|confirmed',
            'new_password_confirmation' => 'nullable|required_with:new_password',
            
            // Security Settings
            'fst_setup' => 'nullable|boolean',
            'tfa_setup' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.unique' => 'Nomor telepon sudah digunakan oleh pengguna lain.',
            'username.unique' => 'Username sudah digunakan oleh pengguna lain.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.max' => 'Ukuran file maksimal 2MB.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'nomor_kk.size' => 'Nomor KK harus 16 digit.',
            'nomor_ktp.size' => 'Nomor KTP harus 16 digit.',
            'nomor_npwp.size' => 'Nomor NPWP harus 15 digit.',
            'current_password.current_password' => 'Password lama tidak sesuai.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ];
    }
}
