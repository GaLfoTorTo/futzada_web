<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Pelada;
use App\Models\Equipe;
use App\Models\Resultado;

class Partida extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'partidas';
    protected $fillable = [
        'numero',
        'pelada_id',
        'duracao',
        'tempos',
        'limite_gols'
    ];
    protected $auditInclude = [
        'numero',
        'pelada_id',
        'duracao',
        'tempos',
        'limite_gols'
    ];

    public function pelada(){
        return $this->belongsTo(Pelada::class, 'id','pelada_id');
    }
    
    public function resultado(){
        return $this->hasOne(Resultado::class);
    }
   
    public function equipes(){
        return $this->hasMany(Equipe::class);
    }
}
