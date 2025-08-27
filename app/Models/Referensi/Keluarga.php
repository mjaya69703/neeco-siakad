<?php

namespace App\Models\Referensi;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// use App\Traits\HasLogAktivitas;
// USE MODELS
use App\Models\User;

class Keluarga extends Model
{
    use SoftDeletes;

    protected $table = 'keluargas';
    protected $guarded = [];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'penghasilan' => 'integer'
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
            return $this->owner->name ?? $this->owner->nama ?? 'Tidak diketahui';
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

    public function getHubunganDisplayAttribute()
    {
        return $this->hubungan;
    }

    public function getPenghasilanFormattedAttribute()
    {
        if ($this->penghasilan) {
            return 'Rp ' . number_format($this->penghasilan, 0, ',', '.');
        }
        return '-';
    }

    public function getUmurAttribute()
    {
        if ($this->tanggal_lahir) {
            return $this->tanggal_lahir->age . ' tahun';
        }
        return '-';
    }
}