<?php

namespace App\Models\Referensi;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// use App\Traits\HasLogAktivitas;
// USE MODELS
use App\Models\User;

class GolonganDarah extends Model
{
    // use SoftDeletes, HasLogAktivitas;

    protected $table = 'golongan_darahs';
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class, 'golongan_darah_id');
    }
}
