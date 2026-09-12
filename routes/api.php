<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//CONTROLLERS
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\EscalationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GameController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::fallback(function () { return response()->json(['message' => 'Não foi possível encontrar a rota'], 404);});

//CRIAR USUÁRIO
Route::post('/user/create', [UserController::class, 'create'])->name('create');
//ROTA DE LOGIN
Route::post('/login', [AuthController::class, 'login'])->name('login');
//ROTAS AUTENTICADAS
Route::middleware(['auth:api'])->group(function () {
    //LOGOUT
    Route::post('/logout', [AuthController::class, 'logout']);
    //HOME
    Route::get('/home', [HomeController::class, 'home']);
    //USER
    Route::prefix('user')->group(function () {
        //USUARIO
        Route::get('/',[UserController::class, 'user']);
        Route::patch('/',[UserController::class, 'update']);
        Route::delete('/',[UserController::class, 'delete']);
        //EVENTOS
        Route::get('/events',[UserController::class, 'events']);
        //INFO
        Route::get('/info',[UserController::class, 'info']);
    });

    // EVENTO
    Route::prefix('events')->group(function () {
        Route::get('/',[EventController::class, 'events']);
        //EVENTO ESPECIFICOS (UUID)
        Route::prefix('{uuid}')->group(function () {
            Route::get('/',[EventController::class, 'event']);
            //PARTICIPANTES
            Route::get('/participants',[EventController::class, 'participants']);
            //REGRAS
            Route::get('/rules',[EventController::class, 'rules']);
            //RANKINGS
            Route::get('/rank',[EventController::class, 'rank']);
            //NOTICIAS
            Route::get('/news',[EventController::class, 'news']);
            //PARTIDAS
            Route::get('/games',[EventController::class, 'games']);
            //SALA AO VIVO (STREAM)
            Route::prefix('/room')->group(function () {
                Route::post('stream',[RoomController::class, 'stream']);
                Route::post('join',  [RoomController::class, 'join']);
                Route::post('exit',  [RoomController::class, 'exit']);
            });
        });
    });

    // ESCALAÇÕES
    Route::prefix('escalation')->group(function () {
        Route::post('save', [EscalationController::class, 'save']);
    });

    // PARTIDAS
    Route::prefix('games')->group(function () {
        Route::prefix('{uuid}')->group(function () {
            Route::post('start', [GameController::class, 'start']);
            Route::post('pause', [GameController::class, 'pause']);
            Route::post('finish',[GameController::class, 'finish']);
        });
    });
});