<?php

namespace App\Http\Resources\Website;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'description' => $this->text ?? null,
            'image' => $this->getFirstMedia('images') ? new MediaResource($this->getFirstMedia('images')) :null,
        ];
        return $data;
    }
}
