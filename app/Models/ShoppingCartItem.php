<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShoppingCartItem extends Model
{
    protected $fillable = ['shopping_cart_id', 'item_id', 'quantity'];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(ShoppingCart::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
