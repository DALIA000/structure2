<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddListFormSingleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address ?? null,
            'message' => $this->message ?? null,
            'language' => $this->language ?? null,
            'status' => $this->status,
            'availability' => $this->availability->name ?? null,
            'type' => $this->type->name ?? null,
            'date' => $this->created_at,
            "images" => $this->getMedia('images') ? MediaResource::collection($this->getMedia('images')) : null,
        ];
        return $data;
    }
}
