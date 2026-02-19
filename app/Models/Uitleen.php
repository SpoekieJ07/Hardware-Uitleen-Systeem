<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uitleen extends Model
{
    protected $fillable = [
        'hardware_id',
        'user_id',
        'quantity',
        'lent_at',
        'returned_at',
    ];

    public function hardware()
    {
        return $this->belongsTo(Hardware::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
