<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahapanPerkembanganData extends Model
{
    use HasFactory;

    protected $table = 'tahapan_perkembangan_data';

    protected $fillable = [
        'user_id',
        'tahapan_perkembangan_id',
        'tanggal_pencapaian',
        'status',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tahapanPerkembangan()
    {
        return $this->belongsTo(TahapanPerkembangan::class);
    }
}
