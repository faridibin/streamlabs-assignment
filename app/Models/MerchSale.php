<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MerchSale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'item_name',
        'quantity',
        'amount',
        'currency',
        'buyer_type',
        'buyer_id',
        'user_id',
    ];

    /**
     * Get the buyer that owns the merch sale.
     *
     * @return BelongsTo
     */
    public function buyer(): BelongsTo
    {
        return match ($this->buyer_type) {
            'follower' => $this->belongsTo(Follower::class),
            'subscriber' => $this->belongsTo(Subscriber::class),
        };
    }

    /**
     * Get the user that owns the merch sale.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
