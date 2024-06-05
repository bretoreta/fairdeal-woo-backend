<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'store_id' => $this->store_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'unit_price' => $this->unit_price,
            'weight' => $this->weight,
            'weight_unit' => $this->weight_unit,
            'condition' => $this->condition,
        ];
    }
}
