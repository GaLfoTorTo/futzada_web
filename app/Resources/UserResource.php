<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Resources\AchievementResource;
use App\Resources\LevelResource;
use App\Resources\ManagerResource;
use App\Resources\PlayerResource;
use App\Resources\ParticipantResource;
use App\Resources\TaskResource;
use App\Resources\UserConfigResource;
use App\Enums\Privacy;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'uuid'         => $this->uuid,
            'firstName'    => $this->first_name,
            'lastName'     => $this->last_name,
            'userName'     => $this->user_name,
            'email'        => $this->email,
            'bornDate'     => $this->born_date?->toDateString(),
            'phone'        => $this->phone,
            'photo'        => $this->photo,
            'privacy'      => Privacy::fromBool((bool) $this->privacy)->value,
            'config'       => $this->whenLoaded('config', fn() => UserConfigResource::make($this->config) ?? null),
            'level'        => $this->whenLoaded('level', fn() => LevelResource::make($this->level?->first()) ?? null),
            'player'       => $this->whenLoaded('player', fn() => $this->player ? PlayerResource::make($this->player) : null),
            'manager'      => $this->whenLoaded('manager', fn() => $this->manager ? ManagerResource::make($this->manager) : null),
            'participants' => $this->setParticipant(),
            'achievements' => $this->whenLoaded('achievements', fn() => AchievementResource::collection($this->achievements) ?? []),
            'tasks'        => $this->whenLoaded('tasks', fn() => TaskResource::collection($this->tasks)),
            'createdAt'    => $this->created_at?->toIso8601String(),
            'updatedAt'    => $this->updated_at?->toIso8601String(),
            'deletedAt'    => $this->deleted_at?->toIso8601String(),
        ];
    }

    private function setParticipant(){
        return $this->pivot
            ? [ParticipantResource::make($this->pivot)]
            : $this->whenLoaded('participants', fn() => ParticipantResource::collection($this->participants));
    }
}
