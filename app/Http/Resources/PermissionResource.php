<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'description'  => $this->description,
            'date'         => $this->date?->format('Y-m-d'),
            'status'       => $this->status,
            'proof_image'  => $this->proof_image ? asset('storage/' . $this->proof_image) : null,
            'user'         => new UserResource($this->whenLoaded('user')),
        ];
    }
}
