<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Immunization extends Model
{
    protected $fillable = ['name'];

    public function records()
    {
        return $this->hasMany(ImmunizationRecord::class);
    }
}


