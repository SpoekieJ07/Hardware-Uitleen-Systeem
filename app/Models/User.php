<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function isUser(): bool
    {
        return $this->hasRole('user');
    }

    public function isDeveloper(): bool
    {
        return $this->hasRole('developer');
    }

    public function isOwner(): bool
    {
        return $this->hasRole('owner');
    }
    public function loanRequests()
    {
        return $this->hasMany(LoanRequest::class);
    }
}
