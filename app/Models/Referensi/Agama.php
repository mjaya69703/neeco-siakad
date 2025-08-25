<?php

namespace App\Models\Referensi;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// use App\Traits\HasLogAktivitas;
// USE MODELS
use App\Models\User;

class Agama extends Model
{
    // use SoftDeletes, HasLogAktivitas;

    protected $table = 'agamas';
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class, 'agama_id');
    }

}
