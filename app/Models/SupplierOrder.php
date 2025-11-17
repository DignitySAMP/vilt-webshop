<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplierOrder extends Model
{
    use HasFactory;

    protected $fillable = ['supplier_address_id'];

    public function address(): BelongsTo
    {
        return $this->belongsTo(SupplierAddress::class, 'supplier_address_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(SupplierOrderItem::class);
    }
}
