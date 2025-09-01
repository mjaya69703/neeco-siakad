<?php

namespace App\Models\Transaksi;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// USE MODELS
use App\Models\User;
use App\Models\Inventaris\BarangInventaris;
use App\Models\Transaksi\PengajuanPerbaikan;

class RiwayatPerbaikan extends Model
{
    use SoftDeletes;

    protected $table = 'riwayat_perbaikan';
    protected $guarded = [];

    protected $casts = [
        'tanggal_service' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanPerbaikan::class, 'pengajuan_id');
    }

    public function barangInventaris()
    {
        return $this->belongsTo(BarangInventaris::class, 'barang_inventaris_id');
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