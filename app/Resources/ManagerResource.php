<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Resources\EscalationResource;
use App\Resources\EconomyResource;
use App\Resources\RatingResource;

class ManagerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'userId'      => $this->user_id,
            'team'        => $this->team,
            'alias'       => $this->alias,
            'primary'     => $this->primary,
            'secondary'   => $this->secondary,
            'emblem'      => $this->emblem_url,
            'uniform'     => $this->uniform_url,
            'escalations' => $this->whenLoaded('escalations', fn() => EscalationResource::collection($this->escalations)),
            'economies'   => $this->whenLoaded('economies', fn() => EconomyResource::collection($this->economies)),
            'ratings'     => $this->whenLoaded('ratings', fn() => RatingResource::collection($this->ratings)),
            'createdAt'   => $this->created_at?->toIso8601String(),
            'updatedAt'   => $this->updated_at?->toIso8601String(),
            'deletedAt'   => $this->deleted_at?->toIso8601String(),
        ];
    }
}