<?php

namespace App\Models;

// USE SYSTEM
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// use App\Traits\HasLogAktivitas;
// USE MODELS
use App\Models\Referensi\Agama;
use App\Models\Referensi\Alamat;
use App\Models\Referensi\GolonganDarah;
use App\Models\Referensi\JenisKelamin;
use App\Models\Referensi\Keluarga;
use App\Models\Referensi\Kewarganegaraan;
use App\Models\Referensi\Pendidikan;

class User extends Authenticatable
{
    // use SoftDeletes, HasLogAktivitas;

    protected $table = 'users';
    protected $guarded = [];
    protected $guard_name = 'web';

    public function owner() 
    {
        return $this->morphTo(); 
    }

    // Shortcut

    public function getPhotoAttribute($value)
    {
        return $value == 'default.jpg' ? asset('storage/images/profile/default.jpg') : asset('storage/images/profile/' . $value);
    }

    public function getPrefixAttribute()
    {
        // Return empty string for now - this can be customized based on user roles
        return '';
    }


    // Relations

    public function agama()
    {
        return $this->belongsTo(Agama::class, 'agama_id');
    }

    public function alamats()
    {
        return $this->morphMany(Alamat::class, 'owner');
    }

    public function alamatKtp()
    {
        return $this->morphMany(Alamat::class, 'owner')->where('tipe', 'ktp');
    }
    
    public function alamatDomisili()
    {
        return $this->morphMany(Alamat::class, 'owner')->where('tipe', 'domisili');
    }

    // Single address access methods
    public function getAlamatKtpAttribute()
    {
        return $this->alamats()->where('tipe', 'ktp')->first();
    }

    public function getAlamatDomisiliAttribute()
    {
        return $this->alamats()->where('tipe', 'domisili')->first();
    }

    public function golonganDarah()
    {
        return $this->belongsTo(GolonganDarah::class, 'golongan_darah_id');
    }

    public function jenisKelamin()
    {
        return $this->belongsTo(JenisKelamin::class, 'jenis_kelamin_id');
    }

    public function keluargas()
    {
        return $this->morphMany(Keluarga::class, 'owner');
    }

    public function kewarganegaraan()
    {
        return $this->belongsTo(Kewarganegaraan::class, 'kewarganegaraan_id');
    }

    public function pendidikans()
    {
        return $this->morphMany(Pendidikan::class, 'owner');
    }
}