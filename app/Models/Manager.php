<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\User;
use App\Models\Escalacao;
use App\Models\Economy;
use App\Models\Rating;

class Manager extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'managers';
    protected $fillable = [
        'user_id',
        'team',
        'alias',
        'primary',
        'secondary',
        'emblem',
        'uniform',
    ];
    protected $auditInclude = [
        'user_id',
        'team',
        'alias',
        'primary',
        'secondary',
        'emblem',
        'uniform',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function escalations()
    {
        return $this->hasMany(Escalation::class);
    }

    public function economies()
    {
        return $this->hasMany(Economy::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'user_id', 'user_id');
    }
}
