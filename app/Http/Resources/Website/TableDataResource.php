<?php

namespace App\Http\Resources\Website;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TableDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'type' => $this->type ?? null,
            'price' => $this->price ?? null,
            'percent'=> $this->percent ?? null,
            'year'=> $this->year ?? null
        ];
        return $data;
    }
}
