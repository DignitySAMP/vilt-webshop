<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Item;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;
    public $fillable = ['order_id', 'item_id', 'amount', 'price'];


    public function order(): BelongsTo {
        return $this->belongsTo(Order::class);
    }


    public function item(): BelongsTo {
        return $this->belongsTo(Item::class);
    }
}
