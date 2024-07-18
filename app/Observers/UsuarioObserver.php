<?php

namespace App\Observers;

use App\Models\Usuario;
use Illuminate\DataBase\Eloquent\Model;
use App\Managers\UsuarioManager;

class UsuarioObserver
{
    /**
     * Handle the Usuario "creating" event.
     */
    public function creating(Model $model): void
    {
        $usuario_id = app(UsuarioManager::class)->getUsuarioId();
        $model->setAttribute('usuario_id', $usuario_id);
    }
    /**
     * Handle the Usuario "created" event.
     */
    public function created(Usuario $usuario): void
    {
        //
    }

    /**
     * Handle the Usuario "updated" event.
     */
    public function updated(Usuario $usuario): void
    {
        //
    }

    /**
     * Handle the Usuario "deleted" event.
     */
    public function deleted(Usuario $usuario): void
    {
        //
    }

    /**
     * Handle the Usuario "restored" event.
     */
    public function restored(Usuario $usuario): void
    {
        //
    }

    /**
     * Handle the Usuario "force deleted" event.
     */
    public function forceDeleted(Usuario $usuario): void
    {
        //
    }
}
