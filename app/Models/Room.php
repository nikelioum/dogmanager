<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'capacity',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'string', // Ensure enum is treated as string
    ];

    /**
     * Define the relationship with the Booking model.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if the room is currently occupied based on bookings.
     */
    public function isOccupied(): bool
    {
        $today = Carbon::today();
        return $this->bookings()->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->exists();
    }

    /**
     * Get the current status of the room.
     */
    public function getStatusAttribute($value)
    {
        return $this->isOccupied() ? 'occupied' : 'available';
    }
}
