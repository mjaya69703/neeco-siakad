<?php

namespace App\Models\Transaksi;

// USE SYSTEM
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// USE MODELS
use App\Models\User;
use App\Models\Inventaris\BarangInventaris;

class PengajuanPerbaikan extends Model
{
    use SoftDeletes;

    protected $table = 'pengajuan_perbaikan';
    protected $guarded = [];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
    ];

    public function barangInventaris()
    {
        return $this->belongsTo(BarangInventaris::class, 'barang_inventaris_id');
    }

    public function pengaju()
    {
        return $this->belongsTo(User::class, 'pengaju_id');
    }

    public function disetujuiOleh()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
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