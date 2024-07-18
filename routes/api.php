<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//CONTROLLERS
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;

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

//CRIAR USUÁRIO
Route::post('/user/create', [UsuarioController::class, 'create'])->name('create');
//ROTA DE LOGIN
Route::post('/login', [AuthController::class, 'login'])->name('login');

//ROTAS INTERNAS (TOKEN SANCTUM)
Route::middleware('auth:api')->group(function () {
    Route::get('/home', [HomeController::class, 'home']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
