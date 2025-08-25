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
    // use SoftDeletes, HasLogAktivitas;

    protected $table = 'keluargas';
    protected $guarded = [];

    public function owner() 
    {
        return $this->morphTo(); 
    }
}
