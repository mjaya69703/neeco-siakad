<?php

namespace App\Models\Akademik;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// USE MODELS
use App\Models\User;
use App\Models\Akademik\ProgramStudi;
use App\Models\Akademik\TahunAkademik;
use App\Models\Akademik\KurikulumMataKuliah;

class Kurikulum extends Model
{
    use SoftDeletes;

    protected $table = 'kurikulum';
    protected $guarded = [];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    public function tahunAkademikAwal()
    {
        return $this->belongsTo(TahunAkademik::class, 'awal_tahun_akademik_id');
    }

    public function tahunAkademikAkhir()
    {
        return $this->belongsTo(TahunAkademik::class, 'akhir_tahun_akademik_id');
    }

    public function kurikulumMataKuliah()
    {
        return $this->hasMany(KurikulumMataKuliah::class, 'kurikulum_id');
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