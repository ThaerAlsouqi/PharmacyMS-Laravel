<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Make sure this table name is correct
    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'date_of_birth',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
    ];

    // Relationships
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function getFullAddressAttribute()
    {
        return $this->address ?: 'No address provided';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeWithReservations($query)
    {
        return $query->with('reservations');
    }
}