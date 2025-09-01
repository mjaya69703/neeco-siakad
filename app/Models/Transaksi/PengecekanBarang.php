<?php

namespace App\Models\Transaksi;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// USE MODELS
use App\Models\User;
use App\Models\Inventaris\BarangInventaris;

class PengecekanBarang extends Model
{
    use SoftDeletes;

    protected $table = 'pengecekan_barang';
    protected $guarded = [];

    protected $casts = [
        'tanggal_cek' => 'date',
    ];

    public function barangInventaris()
    {
        return $this->belongsTo(BarangInventaris::class, 'barang_inventaris_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
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