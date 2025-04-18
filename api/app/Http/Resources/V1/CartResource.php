<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'products' => $this->whenLoaded(
                'products',
                ProductResource::collection($this->resource->products), []
            ),
            'products_count' => $this->whenLoaded('products', $this->resource->products->sum(function ($product) {
                return $product->pivot->quantity;
            })),
            'vat' => $this->resource->vat * 100,
            'total_value' => $this->resource->total_value,
            'vat_value' => $this->resource->vat_value,
            'total_value_with_vat' => $this->resource->total_value_with_vat,
        ];
    }
}
