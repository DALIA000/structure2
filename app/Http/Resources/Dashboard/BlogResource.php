<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'slug' => $this->slug,
            'locales' => $this->localize() ?? null,
            'date' => $this->created_at,
            'hashtags' => $this->hashtags,
            'views' => $this->views ? count($this->views) : 0,
            // 'likes' => $this->likes,
            // 'unlikes' => $this->unlikes,
            'image' => $this->getFirstMedia('images') ? new MediaResource($this->getFirstMedia('images')) : null,

        ];
        return $data;
    }
}
