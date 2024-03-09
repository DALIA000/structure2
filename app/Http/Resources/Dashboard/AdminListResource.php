<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $role = $this->roles->first();

        return
            [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'username' => $this->username,
                'role' => [
                    'id' => $role?->id,
                    'name' => $role?->name,
                ],
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];
    }
}