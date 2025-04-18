<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tahapanPerkembangan extends model
{
    use HasFactory;
    protected $fillable = [
        'kategori',
        'tahapan',
        'deskripsi',
    ];
    public function tahapanPerkembanganData()
    {
        return $this->hasMany(tahapanPerkembanganData::class);
    }
    public function getRouteKeyName()
    {
        return 'id';
    }
}
