<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Immunization extends Model
{
    protected $fillable = ['name', 'age', 'description'];

    public function records()
    {
        return $this->hasMany(ImmunizationRecord::class);
    }
}


