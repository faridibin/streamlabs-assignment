<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the events for the user.
     *
     * @return HasMany
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get the followers for the user.
     *
     * @return HasMany
     */
    public function followers(): HasMany
    {
        return $this->hasMany(Follower::class);
    }

    /**
     * Get the subscribers for the user.
     *
     * @return HasMany
     */
    public function subscribers(): HasMany
    {
        return $this->hasMany(Subscriber::class);
    }

    /**
     * Get the donations for the user.
     *
     * @return HasMany
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get the merch sales for the user.
     *
     * @return HasMany
     */
    public function merchSales(): HasMany
    {
        return $this->hasMany(MerchSale::class);
    }
}
