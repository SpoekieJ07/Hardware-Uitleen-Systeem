<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LoanRequest;

class Hardware extends Model
{
    protected $fillable = ['name', 'total', 'price', 'loan_duration_days'];

    public function loanRequests()
    {
        return $this->hasMany(LoanRequest::class);
    }
}
