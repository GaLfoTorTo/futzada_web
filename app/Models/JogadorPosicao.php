<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Usuario;
use App\Models\Posicao;

class JogadorPosicao extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $timestamps = false; 
    protected $table = 'jogador_posicaos';
    protected $fillable = [
        'usuario_id',
        'posicao_id',
        'principal',
    ];
    protected $auditInclude = [
        'usuario_id',
        'posicao_id',
        'principal',
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }

    public function posicoes(){
        return $this->beLongsTo(Posicao::class);
    }
}
