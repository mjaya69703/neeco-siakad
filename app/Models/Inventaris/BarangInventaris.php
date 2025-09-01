<?php

namespace App\Models\Inventaris;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// USE MODELS
use App\Models\User;
use App\Models\Inventaris\Barang;
use App\Models\Infra\Ruangan;
use App\Models\User as UserModel;

class BarangInventaris extends Model
{
    use SoftDeletes;

    protected $table = 'barang_inventaris';
    protected $guarded = [];


    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    public function pengguna()
    {
        return $this->belongsTo(UserModel::class, 'pengguna_id');
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