<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArtikelKategori extends Model
{
    use HasFactory;

    protected $table = 'artikel_kategoris'; // pakai snake_case jamak sesuai Laravel convention

    protected $fillable = ['name'];

    public function artikels()
    {
        return $this->hasMany(Artikel::class, 'artikel_kategori_id');
    }
}
