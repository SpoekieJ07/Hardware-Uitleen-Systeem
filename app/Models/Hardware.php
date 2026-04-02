<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    protected $fillable = [
        'name',
        'total',
        'price',
        'status',
        'loan_duration_days',
    ];

    public function uitleningen()
    {
        return $this->hasMany(Uitleen::class, 'hardware_id');
    }
}
