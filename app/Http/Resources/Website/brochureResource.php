<?php

namespace App\Http\Resources\Website;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class brochureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'pdf' => $this->getFirstMedia('files')? new MediaResource($this->getFirstMedia('files')): null,
        ];
    }
}
