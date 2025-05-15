<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArtikelKategori extends Model
{
    use HasFactory;

    protected $table = 'artikel_kategoris'; // tetap benar, karena table utama kategori

    protected $fillable = ['name'];

    public function artikels()
    {
        return $this->belongsToMany(Artikel::class, 'artikel_artikel_kategori');
    }
}
