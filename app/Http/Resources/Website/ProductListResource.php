<?php

namespace App\Http\Resources\Website;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'slug' => $this->slug,
            'title' => $this->title ?? null,
            "image" => $this->getFirstMedia('images') ? new MediaResource($this->getFirstMedia('images')) : null,
            "brochure" => $this->getFirstMedia('brochure') ? new MediaResource($this->getFirstMedia('brochure')) : null,
            'address' => $this->address ?? null,
            'size' => [
                'min' => $this->Details->min_size ?? null,
                'max' => $this->Details->max_size ?? null,
            ],
            'price' => $this->price ?? null,
            'developer' => new DeveloperShortResource($this->Developer) ?? null,
            'badge' => $this->badge ?? null,
            'location' => [
                "lat" => (double) $this->location["lat"] ?? null,
                "long" => (double) $this->location["long"] ?? null,
            ],
            'handover_date' => $this->handover_date ?? null,
            'rental_period' => [
                'slug' => $this->period->slug ?? null,
                'period' => $this->period->period ?? null,
            ],
        ];
        return $data;
    }
}
