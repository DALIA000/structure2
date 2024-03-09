<?php

namespace App\Http\Resources\Website;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WhyUsResource extends JsonResource
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
            'title' => $this->title,
            "images" => $this->getMedia('images') ? MediaResource::collection($this->getMedia('images')) : null,
        ];
        return $data;
    }
}
