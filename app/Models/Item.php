<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'supplier_id', 'name', 'description', 'image', 'price', 'stock'];

    public function category(): BelongsTo {
        return $this->belongsTo(ItemCategory::class);
    }
    public function supplier(): BelongsTo {
        return $this->belongsTo(Supplier::class);
    }
}
