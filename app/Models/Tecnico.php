<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Usuario;
use App\Models\Escalacao;
use App\Http\Traits\UsuarioTrait;

class Tecnico extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'tecnicos';
    protected $fillable = [
        'usuario_id',
        'equipe',
        'sigla',
        'emblema',
        'uniforme',
        'primaria',
        'secundaria',
    ];
    protected $auditInclude = [
        'usuario_id',
        'equipe',
        'sigla',
        'emblema',
        'uniforme',
        'primaria',
        'secundaria',
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }
    
    public function escalacao(){
        return $this->hasMany(Escalacao::class);
    }
}
