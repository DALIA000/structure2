<?php

namespace App\Http\Resources\Website;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AmenitiesListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id ?? null,
            'name' => $this->name ?? null,
            "icon" => $this->getFirstMedia('icons')? new MediaResource($this->getFirstMedia('icons')) : null,
        ];
        return $data;
    }
}
