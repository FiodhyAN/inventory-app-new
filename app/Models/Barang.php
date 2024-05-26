<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';
    protected $primaryKey = 'barang_id';
    protected $keyType = 'string';
    protected $guarded = [];

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id', 'kategori_id');
    }

    public function pengajuan()
    {
        return $this->hasMany(PengajuanBarang::class, 'barang_id', 'barang_id');
    }

    public function perjalanan()
    {
        return $this->hasMany(PerjalananBarang::class, 'barang_id', 'barang_id');
    }

    public function scopeIsFree($query)
    {
        return $query->where('is_free', true);
    }
}