<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    /** @use HasFactory<\Database\Factories\PetFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'name',
        'species',
        'breed',
    ];

    /**
     * Define the relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define the relationship with the Address model.
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Define the relationship with the Booking model.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
