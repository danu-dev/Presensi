<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'urgency'     => $this->urgency,
            'expires_at'  => $this->expires_at?->format('Y-m-d'),
            'room'        => $this->whenLoaded('room', fn () => [
                'id'   => $this->room->id,
                'name' => $this->room->name,
            ]),
            'creator'     => new UserResource($this->whenLoaded('creator')),
        ];
    }
}
