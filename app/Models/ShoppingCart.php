<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShoppingCart extends Model
{
    protected $fillable = ['uuid'];

    public function items(): HasMany
    {
        return $this->hasMany(ShoppingCartItem::class);
    }

    public function uuid() {
        return $this->uuid;
    }

    // TODO: Total items, total price, ... [remove the front end dependency]
}
