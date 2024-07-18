<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Usuario;
use App\Models\Pelada;
use App\Models\Pontuacao;
use App\Models\Atuacao;

class Participante extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'participantes';
    protected $fillable = [
        'pelada_id',
        'usuario_id',
        'jogador',
        'tecnico',
        'arbitro',
        'organizador',
        'colaborador',
        'permissoes',
        'status'
    ];
    protected $auditInclude = [
        'pelada_id',
        'usuario_id',
        'jogador',
        'tecnico',
        'arbitro',
        'organizador',
        'colaborador',
        'permissoes',
        'status'
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class, 'id','usuario_id');
    }
    
    public function pelada(){
        return $this->belongsTo(Pelada::class, 'id','pelada_id');
    }
    
    public function pontuacoes(){
        return $this->hasMany(Pontuacao::class);
    }
   
    public function atuacoes(){
        return $this->hasMany(Atuacao::class);
    }
}