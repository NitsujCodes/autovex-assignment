<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CartProduct extends Pivot
{
    protected $fillable = [
        'quantity',
    ];

    /** Relations */
    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function cart() : BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }
    /** End Relations */

    public function casts() : array
    {
        return [
            'quantity' => 'integer',
        ];
    }
}
