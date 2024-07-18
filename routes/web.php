<?php

use Illuminate\Support\Facades\Route;
use App\Models\Atuacao;
use App\Models\Equipe;
use App\Models\Escalacao;
use App\Models\Jogador;
use App\Models\Noticia;
use App\Models\Participante;
use App\Models\Partida;
use App\Models\Pelada;
use App\Models\Pontuacao;
use App\Models\Posicao;
use App\Models\Regra;
use App\Models\Resultado;
use App\Models\Tecnico;
use App\Models\Usuario;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $class_atuacao = new Atuacao;
    dd($class_atuacao);
    return view('welcome');
});
