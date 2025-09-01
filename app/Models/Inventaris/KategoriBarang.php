<?php

namespace App\Models\Inventaris;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// USE MODELS
use App\Models\User;
use App\Models\Inventaris\Barang;

class KategoriBarang extends Model
{
    use SoftDeletes;

    protected $table = 'kategori_barang';
    protected $guarded = [];


    public function barangs()
    {
        return $this->hasMany(Barang::class, 'kategori_id');
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