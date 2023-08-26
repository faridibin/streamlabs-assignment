<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message',
        'eventable_type',
        'eventable_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'details' => AsArrayObject::class,
    ];

    /**
     * Scope a query to only include users of a given type.
     */
    public function scopeForUser(Builder $query, mixed $user): void
    {
        $id = $user instanceof User ? $user->id : $user;

        $query->where('user_id', $id);
    }

    /**
     * Get the eventable that owns the event.
     *
     * @return BelongsTo
     */
    public function eventable(): BelongsTo
    {
        return match ($this->eventable_type) {
            'subscription' => $this->belongsTo(Subscription::class),
            'follower' => $this->belongsTo(Follower::class),
            'donation' => $this->belongsTo(Donation::class),
            'sale' => $this->belongsTo(MerchSale::class),
        };
    }

    /**
     * Get the user that owns the donation.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
