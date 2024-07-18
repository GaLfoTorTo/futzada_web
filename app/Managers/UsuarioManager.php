<?php

namespace App\Managers;

use App\Models\Usuario;

class UsuarioManager 
{
    //BUSCAR ID DO USUARIO
    public function getUsuarioId() {
        return auth()->user()->id;
    }
    //BUSCAR USUARIO
    public function getUsuario(): Usuario {
        return auth()->user()->usuario;
    }
}