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

    public function getAppFaviconAttribute($value)
    {
        return $value == 'default.jpg' ? asset('storage/images/logo/logo-vertikal.jpg') : asset('storage/images/logo/' . $value);
    }
    public function getAppLogoVertikalAttribute($value)
    {
        return $value == 'default.jpg' ? asset('storage/images/logo/logo-vertikal.jpg') : asset('storage/images/logo/' . $value);
    }
    public function getAppLogoHorizontalAttribute($value)
    {
        return $value == 'default.jpg' ? asset('storage/images/logo/logo-horizontal.jpg') : asset('storage/images/logo/' . $value);
    }
    
}
