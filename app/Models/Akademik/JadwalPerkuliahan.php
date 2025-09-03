<?php

namespace App\Models\Akademik;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// USE MODELS
use App\Models\User;
use App\Models\Akademik\TahunAkademik;
use App\Models\Akademik\MataKuliah;
use App\Models\User as Dosen;
use App\Models\Infra\Ruangan;
use App\Models\Akademik\JadwalKelas;
use App\Models\Akademik\JadwalPertemuan;

class JadwalPerkuliahan extends Model
{
    use SoftDeletes;

    protected $table = 'jadwal_perkuliahan';
    protected $guarded = [];

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruang_id');
    }

    public function jadwalKelas()
    {
        return $this->hasMany(JadwalKelas::class, 'jadwal_id');
    }

    public function jadwalPertemuan()
    {
        return $this->hasMany(JadwalPertemuan::class, 'jadwal_id');
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