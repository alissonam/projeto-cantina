<?php

namespace Orders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Items\Item;

class Order extends Model
{
    const STATUS_PENDING   = 'pending';
    const STATUS_CONCLUDED = 'concluded';
    const STATUS_CANCELLED = 'canceled';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'status',
        'amount'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
