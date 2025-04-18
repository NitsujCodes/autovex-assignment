<?php

namespace App\Models;

use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory,HasImages;

    protected $fillable = [
        'title',
        'sku',
        'price',
        'description',
        'slug',
    ];

    protected $appends = [
        'price_with_vat',
        'vat_value',
    ];

    /** Relations */
    public function carts() : BelongsToMany
    {
        return $this->belongsToMany(Cart::class);
    }
    /** End Relations */

    /** Dynamic Attributes */
    protected function price() : Attribute
    {
        return Attribute::make(
            // If price is being updated as a float then it is human readable and needs converting to integer
            set: fn(mixed $value) => is_float($value) ? intval(number_format($value * 100)) : intval($value)
        );
    }

    protected function vatValue() : Attribute
    {
        return Attribute::make(
            get: fn() => $this->price * Cart::$vat
        );
    }

    protected function priceWithVat() : Attribute
    {
        return Attribute::make(
            get: fn() => $this->vat_value + $this->price
        );
    }
    /** End Dynamic Attributes */

    public function casts() : array
    {
        return [
            'price' => 'integer',
        ];
    }
}
