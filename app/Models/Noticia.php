<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Pelada;

class Noticia extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'noticias';
    protected $fillable = [
        'pelada_id',
        'titulo',
        'tipo',
        'descricao'
    ];
    protected $auditInclude = [
        'pelada_id',
        'titulo',
        'tipo',
        'descricao'
    ];

    public function pelada(){
        return $this->belongsTo(Pelada::class, 'id','pelada_id');
    }
}
