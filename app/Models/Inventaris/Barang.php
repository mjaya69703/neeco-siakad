<?php

namespace App\Models\Inventaris;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// USE MODELS
use App\Models\User;
use App\Models\Inventaris\KategoriBarang;
use App\Models\Inventaris\BarangInventaris;

class Barang extends Model
{
    use SoftDeletes;

    protected $table = 'barang';
    protected $guarded = [];


    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }

    public function barangInventaris()
    {
        return $this->hasMany(BarangInventaris::class, 'barang_id');
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