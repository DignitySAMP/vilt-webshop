<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'type', 'identifier', 'code'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $appends = ['identifier'];

    public function getSafeIdentifierAttribute()
    {

        // TODO: Obfuscate the default identifier, if it's an email, show first few letters untl the @, then first few letters of the dns
        // If it's a card number, show only the last 3 digits.
    }
}
