<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Participante;

class Pelada extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'peladas';
    protected $fillable = [
        'tipo',
        'nome',
        'bio',
        'visibilidade',
        'foto',
        'local_fixo',
        'endereco',
        'dia_hora_fixo',
        'dia_semana',
        'data',
        'hora',
        'tipo_campo',
        'qtd_jogadores',
        'levar_bola',
        'levar_bola',
        'arbitro',
        'status_colaborador',
    ];
    protected $auditInclude = [
        'tipo',
        'nome',
        'bio',
        'visibilidade',
        'foto',
        'local_fixo',
        'endereco',
        'dia_hora_fixo',
        'dia_semana',
        'data',
        'hora',
        'tipo_campo',
        'qtd_jogadores',
        'levar_bola',
        'levar_bola',
        'arbitro',
        'status_colaborador',
    ];

    public function participantes(){
        return $this->hasMany(Participante::class);
    }
    
    public function arbitros(){
        return $this->hasMany(Participante::class)->where('arbitro',true);
    }

    public function colaboradores(){
        return $this->hasMany(Participante::class)->where('colaboradores',true);
    }
    
    public function jogadores(){
        return $this->hasMany(Participante::class)->where('jogador',true);
    }

    public function tecnicos(){
        return $this->hasMany(Participante::class)->where('tecnico',true);
    }
    
    public function organizador(){
        return $this->hasOne(Participante::class, 'id','pelada_id')->where('organizador',true);
    }
}
