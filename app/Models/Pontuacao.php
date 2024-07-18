<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Pelada;
use App\Models\Participante;

class Pontuacao extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'pontuacaos';
    protected $fillable = [
        'pelada_id',
        'participante_id',
        'modalidade',
        'pontos',
        'media',
        'valorizacao',
        'preco',
    ];
    protected $auditInclude = [
        'pelada_id',
        'participante_id',
        'modalidade',
        'pontos',
        'media',
        'valorizacao',
        'preco',
    ];

    public function pelada(){
        return $this->belongsTo(Pelada::class, 'id','pelada_id');
    }
    
    public function participante(){
        return $this->belongsTo(Participante::class, 'id','participante_id');
    }
}
