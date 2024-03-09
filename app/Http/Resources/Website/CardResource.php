<?php

namespace App\Http\Resources\Website;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            "id" => $this->id ?? null,
            'description' => $this->description ?? null,
            'number'=> $this->number ?? null,
            'Percentage' => $this->Percentage ?? null
        ];
        return $data;
    }
}
