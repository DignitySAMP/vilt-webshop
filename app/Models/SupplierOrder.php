<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierOrder extends Model
{
    use HasFactory;
    protected $fillable = ['supplier_location_id'];
    public function supplier(): BelongsTo {
        return $this->belongsTo(Supplier::class);
    }
}
