<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBarang extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_barangs';
    protected $primaryKey = 'pengajuan_id';
    protected $guarded = ['pengajuan_id'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'barang_id');
    }

    public function perjalanan()
    {
        return $this->hasOne(PerjalananBarang::class, 'pengajuan_id', 'pengajuan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function scopeMine($query)
    {
        return $query->where('user_id', auth()->user()->user_id);
    }
}