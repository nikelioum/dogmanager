<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Define the relationship with the Role model.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

     /**
     * Define the relationship with the Address model, only for customers.
     */
    public function addresses()
    {
        return $this->hasMany(Address::class)->whereHas('user', function ($query) {
            $query->where('role_id', Role::where('name', 'customer')->first()->id ?? 3);
        });
    }

    /**
     * Define the relationship with the Pet model, only for customers.
     */
    public function pets()
    {
        return $this->hasMany(Pet::class)->whereHas('user', function ($query) {
            $query->where('role_id', Role::where('name', 'customer')->first()->id ?? 3);
        });
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'employee_id');
    }

    /**
     * Check if the user can have addresses or pets (must be a customer).
     */
    public function canHaveAddressesOrPets(): bool
    {
        return $this->role_id === Role::where('name', 'customer')->first()->id ?? 3;
    }
}
