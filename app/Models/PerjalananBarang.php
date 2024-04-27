<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerjalananBarang extends Model
{
    use HasFactory;

    protected $table = 'perjalanan_barangs';
    protected $primaryKey = 'perjalanan_id';
    protected $guarded = [];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanBarang::class, 'pengajuan_id', 'pengajuan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
