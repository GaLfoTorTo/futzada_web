<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Pelada;
use App\Models\Equipe;

class Resultado extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'resultados';
    protected $fillable = [
        'pelada_id',
        'equipe_1_id',
        'equipe_2_id',
        'equipe_1',
        'equipe_2',
        'tempo',
    ];
    protected $auditInclude = [
        'pelada_id',
        'equipe_1_id',
        'equipe_2_id',
        'equipe_1',
        'equipe_2',
        'tempo',
    ];

    public function pelada(){
        return $this->belongsTo(Pelada::class, 'id','pelada_id');
    }

    public function equipes(){
        return $this->hasMany(Equipe::class);
    }
}
