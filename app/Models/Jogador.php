<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Usuario;
use App\Http\Traits\UsuarioTrait;

class Jogador extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    public $timestamps = false; 
    protected $table = 'jogadors';
    protected $fillable = [
        'usuario_id',
        'melhor_pe',
        'arquetipo',
    ];
    protected $auditInclude = [
        'usuario_id',
        'melhor_pe',
        'arquetipo',
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }

    public function posicoes(){
        return $this->beLongsToMany(Posicao::class, 'jogador_posicaos','usuario_id','posicao_id');
    }
}
