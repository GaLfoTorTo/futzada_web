<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Pelada;

class Regra extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'regras';
    protected $fillable = [
        'pelada_id',
        'titulo',
        'descricao',
    ];
    protected $auditInclude = [
        'pelada_id',
        'titulo',
        'descricao',
    ];

    public function pelada(){
        return $this->belongsTo(Pelada::class, 'id','pelada_id');
    }
}
