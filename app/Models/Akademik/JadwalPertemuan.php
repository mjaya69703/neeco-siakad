<?php

namespace App\Models\Akademik;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// USE MODELS
use App\Models\User;
use App\Models\Akademik\JadwalPerkuliahan;
use App\Models\User as Dosen;
use App\Models\Infra\Ruangan;

class JadwalPertemuan extends Model
{
    use SoftDeletes;

    protected $table = 'jadwal_pertemuan';
    protected $guarded = [];

    public function jadwal()
    {
        return $this->belongsTo(JadwalPerkuliahan::class, 'jadwal_id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruang_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
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