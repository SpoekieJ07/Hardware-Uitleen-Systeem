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
        'borrower_name',
        'status',
        'start_date',
        'end_date',
        'reminder_sent_at',
    ];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'reminder_sent_at' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hardware()
    {
        return $this->belongsTo(Hardware::class);
    }
}
