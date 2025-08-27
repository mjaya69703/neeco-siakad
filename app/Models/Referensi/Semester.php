<?php

namespace App\Models\Referensi;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// use App\Traits\HasLogAktivitas;
// USE MODELS

class Semester extends Model
{
    use SoftDeletes;

    protected $table = 'semesters';
    protected $guarded = [];


}
