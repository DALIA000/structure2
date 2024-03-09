<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\AgentShortResource;
use App\Http\Resources\AmenitiesShortResource;
use App\Http\Resources\Dashboard\AmenitiesResource;
use App\Http\Resources\Dashboard\CategoryResource;
use App\Http\Resources\Dashboard\CommunityResource;
use App\Http\Resources\Dashboard\TypeResource;
use App\Http\Resources\DeveloperShortResource;
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
            'id' => $this->id,
            "locales" => $this->localize(),
            "images" => $this->getMedia('images') ? MediaResource::collection($this->getMedia('images')) : null,
            "brochure" => $this->getFirstMedia('brochure') ? new MediaResource($this->getFirstMedia('brochure')) : null,
            'price' => $this->price ?? null,
            'location' => $this->location ?? null,
            'agent' => new AgentShortResource($this->Agent) ?? null,
            'amenities' => AmenitiesShortResource::collection($this->Amenities) ?? null,
            'developer' => new DeveloperShortResource($this->Developer) ?? null,
            'category' => [
                'id' => $this->Category->id ?? null,
                'name' => $this->Category->name ?? null,
            ],
            'type' => $type ?? null,
            'community' => [
                'id' => $this->Community->id ?? null,
                'name' => $this->Community->name ?? null,
            ],
            'status' => $this->status ?? null,
            'details' => new ProductDetailsResource($this->Details) ?? null,
            'is_furnishing' => $this->furnishing ?? null,
            'handover_date' => $this->handover_date ?? null,
            'rental_period' => [
                'id' => $this->period->id ?? null,
                'period' => $this->period->period ?? null,
            ],
        ];
        return $data;
    }
}
