<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentShortResource extends JsonResource
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
            "first_name" => $this->first_name ?? null,
            "last_name" => $this->last_name ?? null,
            'position' => $this->position ?? null,
            "image" => $this->getFirstMedia('images') ? new MediaResource($this->getFirstMedia('images')) : null,
        ];
        return $data;
    }
}
