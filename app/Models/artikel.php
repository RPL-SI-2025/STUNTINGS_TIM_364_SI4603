<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'views',
        'artikel_kategori_id'
    ];

    public function kategori()
    {
        return $this->belongsTo(ArtikelKategori::class, 'artikel_kategori_id');
    }
}
