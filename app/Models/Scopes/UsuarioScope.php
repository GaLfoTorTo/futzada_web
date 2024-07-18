<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use App\Managers\UsuarioManager;

class UsuarioScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $usuario_id = app(UsuarioManager::class)->getUsuarioId();
        $builder->where('usuario_id', $usuario_id);
    }
}
