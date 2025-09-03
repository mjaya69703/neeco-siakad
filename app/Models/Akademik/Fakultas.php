<?php

namespace App\Models\Akademik;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// USE MODELS
use App\Models\User;
use App\Models\Akademik\ProgramStudi;

class Fakultas extends Model
{
    use SoftDeletes;

    protected $table = 'fakultas';
    protected $guarded = [];

    public function programStudi()
    {
        return $this->hasMany(ProgramStudi::class, 'fakultas_id');
    }

    public function dekan()
    {
        return $this->belongsTo(User::class, 'dekan_id');
    }

    public function sekretaris()
    {
        return $this->belongsTo(User::class, 'sekretaris_id');
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