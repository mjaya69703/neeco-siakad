<?php

namespace App\Models\Akademik;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// USE MODELS
use App\Models\User;
use App\Models\Referensi\Semester;
use App\Models\Akademik\KurikulumMataKuliah;
use App\Models\Akademik\KelasPerkuliahan;
use App\Models\Akademik\JadwalPerkuliahan;

class MataKuliah extends Model
{
    use SoftDeletes;

    protected $table = 'mata_kuliah';
    protected $guarded = [];

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function kurikulumMataKuliah()
    {
        return $this->hasMany(KurikulumMataKuliah::class, 'mata_kuliah_id');
    }

    public function kelasPerkuliahan()
    {
        return $this->hasMany(KelasPerkuliahan::class, 'mata_kuliah_id');
    }

    public function jadwalPerkuliahan()
    {
        return $this->hasMany(JadwalPerkuliahan::class, 'mata_kuliah_id');
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