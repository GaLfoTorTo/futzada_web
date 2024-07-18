<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use App\Scopes\UsuarioScope;
use App\Observers\UsuarioObserver;
use App\Models\User;

Trait UsuarioTrait
{
    public static function boot(){

        parent::boot();

        static::observe(new UsuarioObserver);

        /* if (Auth::check()) {
            static::addGlobalScope(new UsuarioScope);
        } */
    }
}