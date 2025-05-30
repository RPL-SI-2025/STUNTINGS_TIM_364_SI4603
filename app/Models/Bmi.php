<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bmi extends Model
{
    use HasFactory;

    protected $table = 'bmi';

    protected $fillable = [
        'user_id',
        'tanggal',
        'tinggi',
        'berat',
        'bmi',
        'status',
        'gender',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
