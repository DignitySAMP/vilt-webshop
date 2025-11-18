<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function contacts(): HasMany
    {
        return $this->hasMany(SupplierContact::class);
    }
    public function addresses(): HasMany
    {
        return $this->hasMany(SupplierAddress::class);
    } public function orders(): HasMany
    {
        return $this->hasMany(SupplierOrder::class);
    }
    protected $appends = ['pending_orders'];

    public function getPendingOrdersAttribute()
    {
        return $this->orders()->count();
    }
    
}
