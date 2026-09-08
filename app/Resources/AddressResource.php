<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'eventId'   => $this->pivot->event_id,
            'street'    => $this->street,
            'number'    => $this->number,
            'suburb'    => $this->suburb,
            'borough'   => $this->borough,
            'city'      => $this->city,
            'state'     => $this->state,
            'country'   => $this->country,
            'zipCode'   => $this->zip_code,
            'latitude'  => (float) $this->latitude,
            'longitude' => (float) $this->longitude,
            'photos'    => $this->photos,
            'createdAt' => $this->created_at?->toIso8601String(),
            'updatedAt' => $this->updated_at?->toIso8601String(),
            'deletedAt' => $this->deleted_at?->toIso8601String(),
        ];
    }
}