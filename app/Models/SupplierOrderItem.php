<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierOrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['supplier_order_id', 'item_id'];
    public function order(): BelongsTo {
        return $this->belongsTo(SupplierOrder::class);
    }

    public function item(): BelongsTo {
        return $this->belongsTo(Item::class);
    }
}
