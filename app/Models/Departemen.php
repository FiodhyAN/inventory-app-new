<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    protected $table = 'departemens';
    protected $primaryKey = 'departemen_id';
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class, 'departemen_id', 'departemen_id');
    }
}
