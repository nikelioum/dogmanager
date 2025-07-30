<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\BookingFactory> */
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'room_id',
        'start_date',
        'end_date',
    ];

    /**
     * Define the relationship with the Pet model.
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    /**
     * Define the relationship with the Room model.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
