<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uitleen extends Model
{
    protected $table = 'uitleen';

    protected $fillable = [
        'user_id',
        'hardware_id',
        'quantity',
        'borrower_name'
    ];

    public function hardware()
    {
        return $this->belongsTo(Hardware::class);
    }
}
