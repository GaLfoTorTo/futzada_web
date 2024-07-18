<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Partida;
use App\Models\Participante;
use App\Models\Tecnico;

class Escalacao extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'equipes';
    protected $fillable = [
        'tecnico_id',
        'partida_id',
        'formacao',
        'capitao_id',
        'j1_id','j2_id','j3_id','j4_id','j5_id','j6_id','j7_id','j8_id',
        'j9_id','j10_id','j11_id','r1_id','r2_id','r3_id','r4_id','r5_id',
    ];
    protected $auditInclude = [
        'tecnico_id',
        'partida_id',
        'formacao',
        'capitao_id',
        'j1_id','j2_id','j3_id','j4_id','j5_id','j6_id','j7_id','j8_id',
        'j9_id','j10_id','j11_id','r1_id','r2_id','r3_id','r4_id','r5_id',
    ];

    public function partida(){
        return $this->belongsTo(Partida::class, 'id','partida_id');
    }
    
    public function tecnico(){
        return $this->belongsTo(Tecnico::class, 'id','tecnico_id');
    }
}
