<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AmenitiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'locales' => $this->localize() ?? null,
            "icon" => $this->getFirstMedia('icons')? new MediaResource($this->getFirstMedia('icons')) : null,
        ];
        return $data;
    }
}
