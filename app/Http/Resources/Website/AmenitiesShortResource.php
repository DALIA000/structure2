<?php

namespace App\Http\Resources\Website;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AmenitiesShortResource extends JsonResource
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
            'name' => $this->name ?? null,
            "icon" => $this->getFirstMedia('icons')? new MediaResource($this->getFirstMedia('icons')) : null,
        ];
        return $data;
    }
}
