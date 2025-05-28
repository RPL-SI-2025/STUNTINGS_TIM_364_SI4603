<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArtikelKategori extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'artikel_kategoris';

    protected $fillable = ['name'];

    public function artikels()
    {
        return $this->belongsToMany(Artikel::class, 'artikel_artikel_kategori');
    }
}
