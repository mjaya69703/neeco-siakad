<?php

namespace App\Models\Referensi;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// use App\Traits\HasLogAktivitas;
// USE MODELS
use App\Models\User;

class Pendidikan extends Model
{
    use SoftDeletes;

    protected $table = 'pendidikans';
    protected $guarded = [];

    protected $casts = [
        'tahun_masuk' => 'integer',
        'tahun_lulus' => 'integer'
    ];

    public function owner()
    {
        return $this->morphTo();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function getOwnerNameAttribute()
    {
        if ($this->owner) {
            return $this->owner->name ?? 'Tidak diketahui';
        }
        return 'Tidak diketahui';
    }

    public function getOwnerTypeDisplayAttribute()
    {
        $type = class_basename($this->owner_type);
        
        switch ($type) {
            case 'User':
                return 'Pengguna';
            case 'Mahasiswa':
                return 'Mahasiswa';
            case 'Dosen':
                return 'Dosen';
            case 'Staff':
                return 'Staff';
            default:
                return ucfirst($type);
        }
    }

    public function getJenjangDisplayAttribute()
    {
        return $this->jenjang;
    }

    public function getPeriodeAttribute()
    {
        if ($this->tahun_masuk && $this->tahun_lulus) {
            return $this->tahun_masuk . ' - ' . $this->tahun_lulus;
        } elseif ($this->tahun_masuk) {
            return $this->tahun_masuk . ' - Sekarang';
        }
        return '-';
    }

    public function getJenjangBadgeClassAttribute()
    {
        switch ($this->jenjang) {
            case 'Paket C':
            case 'SMA':
            case 'SMK':
                return 'bg-secondary';
            case 'D3':
                return 'bg-info';
            case 'S1':
                return 'bg-primary';
            case 'S2':
                return 'bg-success';
            case 'S3':
                return 'bg-warning';
            default:
                return 'bg-light';
        }
    }
}