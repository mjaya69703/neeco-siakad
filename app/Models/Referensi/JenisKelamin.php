<?php

namespace App\Models\Referensi;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// use App\Traits\HasLogAktivitas;
// USE MODELS
use App\Models\User;

class JenisKelamin extends Model
{
    // use SoftDeletes, HasLogAktivitas;

    protected $table = 'jenis_kelamins';
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class, 'jenis_kelamin_id');
    }
}
