<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detection extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'umur',
        'jenis_kelamin',
        'berat_badan',
        'tinggi_badan',
        'z_score',
        'status',
    ];
}
