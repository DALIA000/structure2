<?php

namespace App\Http\Resources\Website;

use App\Http\Resources\MediaResource;
use App\Http\Resources\ServiceShortResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentResource extends JsonResource
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
            "first_name" => $this->first_name?? null,
            "last_name" => $this->last_name?? null,
            'position' => $this->position ?? null,
            'language' => $this->lang ?? null,
            'service' => $this->Service? ServiceShortResource::collection($this->Service) : null,
            'email' => $this->email ?? null,
            'phone' => $this->phone ?? null,
            'whatsapp' => $this->whatsapp ?? null,
            "image" => $this->getFirstMedia('images')? new MediaResource($this->getFirstMedia('images')) : null,
        ];
        return $data;
    }
}
