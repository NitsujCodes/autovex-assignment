<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cart extends Model
{
    use HasFactory;

    public static float $vat = 0.255;

    protected $fillable = [
        'total_value',
    ];

    protected $appends = [
        'vat',
        'vat_value',
        'total_value_with_vat',
    ];

    /** Relations */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->with('images')
            ->withPivot('quantity')
            ->withTimestamps();
    }
    /** End Relations */

    /** Dynamic Attributes */
    public function vatValue(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->total_value * self::$vat
        );
    }

    public function totalValueWithVat(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->total_value + $this->vat_value
        );
    }
    /** End Dynamic Attributes */

    public function casts() : array
    {
        return [
            'total_value' => 'integer',
        ];
    }
}
