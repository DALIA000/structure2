<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\DeveloperShortResource;
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
            'id' => $this->id,
            'title' => $this->title ?? null,
            "image" => $this->getFirstMedia('images')? new MediaResource($this->getFirstMedia('images')) : null,
            "brochure" => $this->getFirstMedia('brochure') ? new MediaResource($this->getFirstMedia('brochure')) : null,
            'address' => $this->address ?? null,
            'price' => $this->price ?? null,
            'size' =>[
                'min' => $this->Details->min_size ?? null,
                'max' => $this->Details->max_size ?? null,
            ],
            'developer' => new DeveloperShortResource ($this->Developer) ?? null,
            'category' => new CategoryResource($this->Category),
        ];
        return $data;
    }
}
