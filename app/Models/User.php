<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['nama_anak', 'nik_anak', 'password', 'role'];

    protected $hidden = ['password'];
    ####
    public function bmi()
    {
        return $this->hasMany(Bmi::class);
    }
}
