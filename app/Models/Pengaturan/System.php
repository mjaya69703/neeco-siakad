<?php

namespace App\Models\Pengaturan;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// use App\Traits\HasLogAktivitas;
// USE MODELS
use App\Models\User;

class System extends Model
{
    // use SoftDeletes, HasLogAktivitas;

    protected $table = 'systems';
    protected $guarded = [];


    
}
