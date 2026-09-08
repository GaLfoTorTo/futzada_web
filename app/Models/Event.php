<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Address;
use App\Models\Avaliation;
use App\Models\Room;
use App\Models\GameConfig;
use App\Models\User;
use App\Models\Rule;
use App\Models\Participant;

class Event extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'events';
    protected $fillable = [
        'uuid',
        'title',
        'bio',
        'date',
        'start_time',
        'end_time',
        'modality',
        'collaborators',
        'photo',
        'privacy',
    ];
    protected $auditInclude = [
        'uuid',
        'title',
        'bio',
        'date',
        'start_time',
        'end_time',
        'modality',
        'collaborators',
        'photo',
        'privacy',
    ];

    protected $casts = [
        'date'          => 'array',
        'collaborators' => 'boolean',
        'privacy'       => 'boolean',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
        'deleted_at'    => 'datetime',
    ];

    // ─── Boot ────────────────────────────────────────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Event $event) {
            if (empty($event->uuid)) {
                $event->uuid = (string) Str::uuid();
            }
        });
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function address()
    {
        return $this->belongsToMany(Address::class, 'event_address', 'event_id', 'address_id');
    }

    public function gameConfig()
    {
        return $this->hasOne(GameConfig::class);
    }

    public function avaliations()
    {
        return $this->hasMany(Avaliation::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'participants')
                    ->withPivot(['id', 'roles', 'permissions', 'status'])
                    ->withTimestamps();
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }
    
    public function room()
    {
        return $this->hasOne(Room::class);
    }
}
