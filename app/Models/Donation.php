<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'currency',
        'donation_message',
        'donator_type',
        'donator_id',
        'user_id'
    ];

    /**
     * Get the donator that owns the donation.
     *
     * @return BelongsTo
     */
    public function donator(): BelongsTo
    {
        return match ($this->donator_type) {
            'follower' => $this->belongsTo(Follower::class),
            'subscriber' => $this->belongsTo(Subscriber::class),
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
