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
    // use SoftDeletes, HasLogAktivitas;

    protected $table = 'pendidikans';
    protected $guarded = [];

    public function owner() 
    {
        return $this->morphTo(); 
    }
}
