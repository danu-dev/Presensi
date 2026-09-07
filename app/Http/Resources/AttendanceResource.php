<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'user'      => new UserResource($this->whenLoaded('user')),
            'location'  => $this->whenLoaded('location', fn () => [
                'id'   => $this->location->id,
                'name' => $this->location->name,
            ]),
            'room'      => $this->whenLoaded('room', fn () => [
                'id'   => $this->room->id,
                'name' => $this->room->name,
            ]),
            'check_in'  => $this->check_in?->toIso8601String(),
            'check_out' => $this->check_out?->toIso8601String(),
            'status'    => $this->status,
        ];
    }
}
