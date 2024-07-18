<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Partida;
use App\Models\Participante;
use App\Models\Equipe;
use App\Models\Acao;

class Atuacao extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'atuacaos';
    protected $fillable = [
        'partida_id',
        'jogador_id',
        'equipe_id',
        'acao_id'
    ];
    protected $auditInclude = [
        'partida_id',
        'jogador_id',
        'equipe_id',
        'acao_id'
    ];

    public function partida(){
        return $this->belongsTo(Partida::class, 'id','partida_id');
    }
    
    public function jogador(){
        return $this->belongsTo(Participante::class, 'id','jogador_id');
    }
    
    public function equipe(){
        return $this->belongsTo(Equipe::class, 'id','equipe_id');
    }
    
    public function acao(){
        return $this->belongsTo(Acao::class, 'id','acao_id');
    }
}
