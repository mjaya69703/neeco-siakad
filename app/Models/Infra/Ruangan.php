<?php

namespace App\Models\Infra;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// USE MODELS
use App\Models\User;
use App\Models\Infra\Gedung;

class Ruangan extends Model
{
    use SoftDeletes;

    protected $table = 'ruangan';
    protected $guarded = [];

    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'gedung_id');
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