<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCartItem extends Model
{
    protected $fillable = ['user_cart_id', 'item_id', 'amount'];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(UserCart::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
