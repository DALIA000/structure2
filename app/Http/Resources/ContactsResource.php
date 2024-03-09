<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'social' => $this->resource->info ?? null,
            'contacts' => $this->contacts->info ?? null,
            'location' => [
                'lat' => $this->location ? (float) $this->location->info['lat'] : null,
                'long' => $this->location ? (float) $this->location->info['long'] : null,
            ],
            'address' => $this->address->text ?? null,
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
