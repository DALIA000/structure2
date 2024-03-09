<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\MediaResource;
use App\Models\Agent;
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
            'id' => $this->id,
            'locales' => $this->localize() ?? null,
            "image" => $this->getFirstMedia('images') ? new MediaResource($this->getFirstMedia('images')) : null,
            "agent" => new AgentResource(Agent::find($this->agent))?? null,
        ];
        return $data;
    }
}
