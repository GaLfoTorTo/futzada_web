<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Posicao extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'posicaos';
    protected $fillable = [
        'posicao',
        'sigla',
    ];
    protected $auditInclude = [
        'posicao',
        'sigla',
    ];
}
