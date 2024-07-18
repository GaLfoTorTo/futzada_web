<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Pelada;
use App\Models\Participante;

class Equipe extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'equipes';
    protected $fillable = [
        'pelada_id','equipe',
        'j1_id','j2_id','j3_id','j4_id','j5_id','j6_id','j7_id','j8_id',
        'j9_id','j10_id','j11_id','r1_id','r2_id','r3_id','r4_id','r5_id',
    ];
    protected $auditInclude = [
        'pelada_id','equipe',
        'j1_id','j2_id','j3_id','j4_id','j5_id','j6_id','j7_id','j8_id',
        'j9_id','j10_id','j11_id','r1_id','r2_id','r3_id','r4_id','r5_id',
    ];
    
    public function pelada(){
        return $this->belongsTo(Pelada::class, 'id','pelada_id');
    }
}
