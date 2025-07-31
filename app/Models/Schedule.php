<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleFactory> */
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'pet_id',
        'address_id',
        'service_id',
        'scheduled_at',
        'week_start_date',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'week_start_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
