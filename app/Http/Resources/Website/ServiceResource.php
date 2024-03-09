<?php

namespace App\Http\Resources\Website;

use App\Http\Resources\MediaResource;
use App\Models\Agent;
use App\Rules\MediaRule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'slug' => $this->slug ?? null,
            'name' => $this->name ?? null,
            "image" => $this->getFirstMedia('images')? new MediaResource($this->getFirstMedia('images')) : null,
            "agent" => new AgentResource(Agent::find($this->agent)) ?? null,
        ];
        return $data;
    }
}
