<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\Privacy;
use App\Resources\UserResource;
use App\Resources\AddressResource;
use App\Resources\GameConfigResource;
use App\Resources\AvaliationResource;
use App\Resources\ParticipantResource;
use App\Resources\RuleResource;
use App\Resources\NewsResource;
use App\Resources\GameResource;

class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'uuid'          => $this->uuid,
            'title'         => $this->title,
            'bio'           => $this->bio,
            'date'          => $this->date ?? [],
            'startTime'     => $this->start_time,
            'endTime'       => $this->end_time,
            'modality'      => $this->modality,
            'collaborators' => $this->collaborators,
            'photo'         => $this->photo_url,
            'privacy'       => Privacy::fromBool((bool) $this->privacy)->value,
            'address'       => $this->whenLoaded('address', fn() => AddressResource::make($this->address->first())),
            'gameConfig'    => $this->whenLoaded('gameConfig', fn() => GameConfigResource::make($this->gameConfig)),
            'avaliations'   => $this->whenLoaded('avaliations', fn() => AvaliationResource::collection($this->avaliations)),
            'participants'  => $this->whenLoaded('users', function () {
                $eventId  = $this->id;
                $modality = $this->modality;

                $this->users->each(function ($user) use ($eventId, $modality) {
                    if ($player = $user->player) {
                        $player->setRelation('ratings',   $player->ratings->where('event_id', $eventId)->values())->latest();
                        $player->setRelation('positions', $player->positions->where('modality', $modality)->values());
                    }
                    if ($manager = $user->manager) {
                        $manager->setRelation('economies',   $manager->economies->where('event_id', $eventId)->values())->latest();
                    }
                });

                return UserResource::collection($this->users);
            }),
            'rules'         => $this->whenLoaded('rules', fn() => RuleResource::collection($this->rules)),
            'news'          => $this->whenLoaded('news', fn() => NewsResource::collection($this->news)),
            'games'         => $this->whenLoaded('games', fn() => GameResource::collection($this->games)),
            'createdAt'     => $this->created_at?->toIso8601String(),
            'updatedAt'     => $this->updated_at?->toIso8601String(),
            'deletedAt'     => $this->deleted_at?->toIso8601String(),
        ];
    }
}