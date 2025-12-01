<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShoppingCart extends Model
{
    protected $fillable = ['uuid'];

    public function items(): HasMany
    {
        return $this->hasMany(ShoppingCartItem::class);
    }

    public function getTotalCost(): float|int
    {
        $cost = 0;
        foreach ($this->items as $item) {
            $cost += $item->getCost();
        }

        return $cost;
    }

    public function mergeItemsFrom(ShoppingCart $otherCart): void
    {
        foreach ($otherCart->items as $item) {

            // item with same item_id?
            $existing = $this->items->firstWhere('item_id', $item->item_id);

            if (! $existing) {
                // sync otherCart into this cart
                $this->items()->create([
                    'item_id' => $item->item_id,
                    'quantity' => $item->quantity,
                ]);
            } else {
                // item already exists, only merge quantities
                $existing->quantity += $item->quantity;
                $existing->save();
            }
        }
    }
}
