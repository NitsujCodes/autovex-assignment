<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StorageFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $metaData = [];
        if ($this->hasPivotLoaded('imageables')) {
            $metaData = new ImageableResource($this->resource->pivot);
        } else if ($this->hasPivotLoaded('documentables')) {
            // TODO: Implement documentables pivot
            $metaData = new JsonResource($this->resource->pivot);
        }

        return [
            'name' => "{$this->resource->name}.{$this->resource->extension}",
            'url' => url("/storage/{$this->resource->uuid}"),
            'mime_type' => $this->resource->mime_type,
            'size' => $this->resource->size,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'meta' => $metaData,
        ];
    }
}
