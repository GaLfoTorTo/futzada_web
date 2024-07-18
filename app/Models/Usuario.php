<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Jogador;
use App\Models\Tecnico;

class Usuario extends Authenticatable implements Auditable, JWTSubject
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'usuarios';
    protected $fillable = [
        'uuid',
        'nome',
        'sobrenome',
        'user_name',
        'email',
        'password',
        'telefone',
        'data_nascimento',
        'visibilidade',
        'foto',
    ];
    protected $auditInclude = [
        'uuid',
        'nome',
        'sobrenome',
        'user_name',
        'email',
        'password',
        'telefone',
        'data_nascimento',
        'visibilidade',
        'foto',
    ];
    
    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function jogador(){
        return $this->hasOne(Jogador::class, 'usuario_id', 'id');
    }
    
    public function tecnico(){
        return $this->hasOne(Jogador::class, 'usuario_id', 'id');
    }
}
