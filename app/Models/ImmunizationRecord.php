<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImmunizationRecord extends Model
{
    protected $fillable = ['user_id', 'immunization_id', 'immunized_at', 'status'];

    public function immunization()
    {
        return $this->belongsTo(Immunization::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

