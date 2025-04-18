<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'description' => $this->resource->description,
            'price' => $this->resource->price,
            'price_with_vat' => $this->resource->price_with_vat,
            'vat_value' => $this->resource->vat_value,
            'sku' => $this->resource->sku,
            'slug' => $this->resource->slug,
            'images' => $this->whenLoaded('images', StorageFileResource::collection($this->resource->images)),
            'meta' => $this->whenPivotLoaded('cart_product', new CartProductResource($this->resource->pivot)),
        ];
    }
}
