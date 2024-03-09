<?php

namespace App\Http\Resources\Website;

use App\Http\Resources\MediaResource;
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
        $type = $this->Type instanceof \Illuminate\Database\Eloquent\Collection
            ? $this->Type->map(function ($type) {
                return (object) [
                    'id'   => $type->id,
                    'name' => $type->name,
                ];
            })->toArray()
            : (optional($this->Type)->name ? [(object)['id' => $this->Type->id, 'name' => $this->Type->name]] : null);
        $data = [
            'slug' => $this->slug,
            'title' => $this->title ?? null,
            'description' => $this->description ?? null,
            "images" => $this->getMedia('images') ? MediaResource::collection($this->getMedia('images')) : null,
            "brochure" => $this->getFirstMedia('brochure') ? new MediaResource($this->getFirstMedia('brochure')) : null,
            'price' => $this->price ?? null,
            'category' => $this->Category->name ?? null,
            'community' => $this->Community->name ?? null,
            'address' => $this->address ?? null,
            'location' => [
                "lat" => (double) $this->location["lat"] ?? null,
                "long" => (double) $this->location["long"] ?? null,
            ],
            'agent' => new AgentShortResource($this->Agent) ?? null,
            'developer' => new DeveloperShortResource($this->Developer) ?? null,
            'amenities' => AmenitiesShortResource::collection($this->Amenities) ?? null,
            'type' => $type ?? null,
            'status' => $this->status ?? null,
            'details' => new ProductDetailsResource($this->Details) ?? null,
            'badge' => $this->badge ?? null,
            'is_furnishing' => $this->furnishing?? null,
            'handover_date' => $this->handover_date ?? null,
            'rental_period' => [
                'slug' => $this->period->slug ?? null,
                'period' => $this->period->period ?? null,
            ],
        ];
        return $data;
    }
}
