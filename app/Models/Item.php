<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['item_category_id', 'supplier_id', 'name', 'description', 'image', 'price', 'stock'];

    protected $appends = ['image_url'];

    public function item_category(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return null;
        }

        // theoretically we dont need to check for the image url here, but for demo purposes in conjunction with db:seed, we add support for hardcoded image urls...
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        } elseif (Storage::disk('public')->exists($this->image)) {
            return asset('storage/'.$this->image);
        }

        return null;
    }
}
