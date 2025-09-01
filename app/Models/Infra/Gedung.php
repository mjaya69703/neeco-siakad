<?php

namespace App\Models\Infra;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// USE MODELS
use App\Models\User;
use App\Models\Infra\Ruangan;

class Gedung extends Model
{
    use SoftDeletes;

    protected $table = 'gedung';
    protected $guarded = [];

    public function ruangans()
    {
        return $this->hasMany(Ruangan::class, 'gedung_id');
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