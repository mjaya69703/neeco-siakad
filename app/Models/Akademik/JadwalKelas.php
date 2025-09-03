<?php

namespace App\Models\Akademik;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// USE MODELS
use App\Models\User;
use App\Models\Akademik\JadwalPerkuliahan;
use App\Models\Akademik\KelasPerkuliahan;

class JadwalKelas extends Model
{
    use SoftDeletes;

    protected $table = 'jadwal_kelas';
    protected $guarded = [];

    public function jadwal()
    {
        return $this->belongsTo(JadwalPerkuliahan::class, 'jadwal_id');
    }

    public function kelas()
    {
        return $this->belongsTo(KelasPerkuliahan::class, 'kelas_id');
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
}