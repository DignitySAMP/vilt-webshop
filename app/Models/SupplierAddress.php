<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierAddress extends Model
{
    use HasFactory;
    protected $fillable = ['supplier_id', 'name', 'street', 'number', 'city', 'postal', 'area', 'country'];

    public function supplier(): BelongsTo {
        return $this->belongsTo(Supplier::class);
    }
}
