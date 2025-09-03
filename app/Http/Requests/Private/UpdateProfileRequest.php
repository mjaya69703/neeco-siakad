<?php

namespace App\Http\Requests\Private;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = Auth::user() ?: Auth::guard('mahasiswa')->user();
        return (bool) ($user);
    }

    public function rules(): array
    {
        $user = Auth::user() ?: Auth::guard('mahasiswa')->user();
        $table = $user->getTable();

        return [
            'name'     => 'required|string|max:255',
            'email'    => "required|email|unique:{$table},email,{$user->id}",
            'phone'    => "required|string|unique:{$table},phone,{$user->id}",
            'username' => "nullable|string|unique:{$table},username,{$user->id}",
            'photo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'tinggi_badan' => 'nullable|numeric',
            'berat_badan' => 'nullable|numeric',

            'link_fb' => 'nullable|string',
            'link_ig' => 'nullable|string',
            'link_in' => 'nullable|string',


            // referensi
            'agama_id'            => 'nullable|exists:agamas,id',
            'golongan_darah_id'   => 'nullable|exists:golongan_darahs,id',
            'jenis_kelamin_id'    => 'nullable|exists:jenis_kelamins,id',
            'kewarganegaraan_id'  => 'nullable|exists:kewarganegaraans,id',

            // identitas
            'nomor_kk'   => "nullable|numeric|digits:16|unique:{$table},nomor_kk,{$user->id}",
            'nomor_ktp'  => "nullable|numeric|digits:16|unique:{$table},nomor_ktp,{$user->id}",
            'nomor_npwp' => "nullable|numeric|digits:16|unique:{$table},nomor_npwp,{$user->id}",

            // password
            'current_password' => 'nullable|required_with:new_password',
            'new_password'     => 'nullable|min:8|confirmed',

            // pendidikan
            'pendidikan.*.jenjang'        => 'required|string',
            'pendidikan.*.nama_institusi' => 'required|string',
            'pendidikan.*.jurusan'        => 'nullable|string',
            'pendidikan.*.tahun_masuk'    => 'nullable|integer|min:1950|max:'.date('Y'),
            'pendidikan.*.tahun_lulus'    => 'nullable|integer|min:1950|max:'.(date('Y')+10),
            'pendidikan.*.ipk'            => 'nullable|string',
            'pendidikan.*.alamat'         => 'nullable|string',

            // keluarga
            'keluarga.*.hubungan'     => 'required|string',
            'keluarga.*.nama'         => 'required|string',
            'keluarga.*.pekerjaan'    => 'nullable|string',
            'keluarga.*.telepon'      => 'nullable|string',
            'keluarga.*.tempat_lahir' => 'nullable|string',
            'keluarga.*.tanggal_lahir'=> 'nullable|date',
            'keluarga.*.penghasilan'  => 'nullable|integer',
            'keluarga.*.alamat'       => 'nullable|string',

            // alamat
            'alamat_ktp.alamat_lengkap'         => 'nullable|string',
            'alamat_ktp.kelurahan'              => 'nullable|string',
            'alamat_ktp.kecamatan'              => 'nullable|string',
            'alamat_ktp.kota_kabupaten'         => 'nullable|string',
            'alamat_ktp.provinsi'               => 'nullable|string',
            'alamat_ktp.kode_pos'               => 'nullable|string|max:10',
            'alamat_ktp.rt'                     => 'nullable|string|max:5',
            'alamat_ktp.rw'                     => 'nullable|string|max:5',

            'alamat_domisili.alamat_lengkap'    => 'nullable|string',
            'alamat_domisili.kelurahan'         => 'nullable|string',
            'alamat_domisili.kecamatan'         => 'nullable|string',
            'alamat_domisili.kota_kabupaten'    => 'nullable|string',
            'alamat_domisili.provinsi'          => 'nullable|string',
            'alamat_domisili.kode_pos'          => 'nullable|string|max:10',
            'alamat_domisili.rt'                => 'nullable|string|max:5',
            'alamat_domisili.rw'                => 'nullable|string|max:5',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function($v){
            $ktp = $this->input('alamat_ktp', []);
            $adaFieldLain = !empty(array_filter(Arr::except($ktp, ['id','tipe','alamat_lengkap'])));
            if ($adaFieldLain && empty($ktp['alamat_lengkap'])) {
                $v->errors()->add('alamat_ktp.alamat_lengkap', 'Alamat lengkap KTP wajib diisi jika data KTP lain diisi.');
            }
        });
    }
    
    public function prepareForValidation()
    {
        // Clean up empty arrays
        if ($this->pendidikan && is_array($this->pendidikan)) {
            $this->pendidikan = array_filter($this->pendidikan, function($item) {
                return !empty(array_filter($item));
            });
        }
        
        if ($this->keluarga && is_array($this->keluarga)) {
            $this->keluarga = array_filter($this->keluarga, function($item) {
                return !empty(array_filter($item));
            });
        }
    }
}