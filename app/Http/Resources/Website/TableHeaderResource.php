<?php

namespace App\Http\Resources\Website;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TableHeaderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'first' => $this->first ?? null,
            'second' => $this->second ?? null,
            'third' => $this->third ?? null,
            'fourth' => $this->fourth ?? null,
        ];
        return $data;
    }
}
