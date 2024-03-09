<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'min_bathroom' => $this->min_bathroom ?? null,
            'max_bathroom' => $this->max_bathroom ?? null,
            'min_bedroom' => $this->min_bedroom ?? null,
            'max_bedroom' => $this->max_bedroom ?? null,
            'min_size' => $this->min_size ?? null,
            'max_size' => $this->max_size ?? null,
        ];
        return $data;
    }
}
