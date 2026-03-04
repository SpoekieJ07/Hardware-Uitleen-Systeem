<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uitleen extends Model
{
    protected $table = 'uitleen';

    protected $fillable = [
        'hardware_id',
        'quantity',
        'borrower_name',
        'status',
        'start_date',
        'end_date',
    ];

    public function hardware()
    {
        return $this->belongsTo(Hardware::class);
    }
}
