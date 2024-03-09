<?php

namespace App\Http\Resources;

use App\Http\Resources\Dashboard\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =[
            'id' => $this->id,
            'name' => $this->name ?? null,
            'email' => $this->email ?? null,
            'phone' => $this->phone ?? null,
            'message' => $this->message ?? null,
            'product' => new ProductResource($this->product) ?? null
        ];
        return $data;
    }
}
