<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'social' => $this->resource->info ?? null,
            'contacts' => $this->contacts->info ?? null,
            // 'location' => $this->location->info ?? null,
            'location' => [
                "lat" => (float) $this->location->info["lat"] ?? null,
                "long" => (float) $this->location->info["long"] ?? null,
            ],
            'locales' => $this->address->localize() ?? null,
        ];
    }

    public function __construct($resource, $contacts, $location, $address)
    {
        parent::__construct($resource);
        $this->contacts = $contacts;
        $this->location = $location;
        $this->address = $address;
    }
}
