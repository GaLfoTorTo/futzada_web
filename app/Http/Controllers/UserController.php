<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Resources\UserResource;
use App\Services\UserService;
use App\Services\EventService;
use App\Models\User;
use App\Models\Player;
use App\Models\Manager;
use App\Models\Position;
use App\Models\PlayerPosition;

class UserController extends Controller
{
    /** 
    * USER - CRIAÇÃO DE USUÁRIO
    *
    * @param Request: Dados do Usuário, Dados de Modo Jogador e Dados
    * @return String: Mensagem de Sucesso ou Erro;
    */
    public function create(Request $request){
        DB::beginTransaction();
        try {
            if(!empty($request->all())){
                $userService = new UserSerivce();
                $userService->create($request->all());
                DB::commit();
                return response()->json(['message' => 'Usuário registrado com sucesso!'], 200);
            }else{
                return response()->json(['message' => 'Os dados do usuário estão vazios!'], 400);
            }
        }catch(\Exception $e) {
            Log::channel('register')->error("[Erro de Registro][User][Registro]", ['[message]' => $e->getMessage(), '[error]' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Houve um erro ao registrar o Usuário.'], 400);
        }
    }

    /**
    * USER - BUSCAR DADOS DO USUARIO
    *
    * @param Request: Id do usuario
    * @return Array: Dados do usuario (config, player, manager)
    */
    public function info(){
        try {
            $user = auth()->user();

            $events     = \App\Models\Event::whereHas('users', fn($q) => $q->where('users.id', $user->id))->get(['id', 'modality']);
            $eventIds   = $events->pluck('id');
            $modalities = $events->pluck('modality')->unique();

            $user->load([
                'config',
                'level',
                'achievements',
                'tasks',
                'player' => fn($q) => $q->with([
                    'positions' => fn($p) => $p->whereIn('positions.modality', $modalities),
                    'ratings'   => fn($r) => $r->where('role', 'Player')->whereIn('event_id', $eventIds),
                ]),
                'manager' => fn($q) => $q->with([
                    'escalations' => fn($es) => $es->whereIn('event_id', $eventIds)->latest(),
                    'economies'   => fn($ec) => $ec->whereIn('event_id', $eventIds)->latest(),
                ]),
            ]);
            return response()->json(['user' => UserResource::make($user)], 200);
        } catch (\Exception $e) {
            Log::channel('register')->error("[Erro ao buscar info do usuário]", ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Houve um erro ao buscar as informações do usuário.'], 500);
        }
    }

    /**
    * USER - EVENTOS DO USUARIO
    *
    * @param Request: Dados do Usuário, Dados de Modo Jogador e Dados
    * @return EventResource || []: Collection App\Models\Event
    */
    public function events(Request $request){
        try {
            $eventService = new EventService();
            $user = auth()->user();
            $events = $eventService->get(userId: $user->id);
            return response()->json(['events' => $events], 200);
        } catch (\Exception $e) {
            Log::channel('register')->error("[Erro ao buscar eventos do usuário]", ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Houve um erro ao buscar os eventos do usuário.'], 500);
        }
    }
}
