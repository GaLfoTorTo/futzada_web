<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\EventService;
use App\Models\Event;
use App\Models\User;
use App\Models\Participant;

class EventController extends Controller
{
    private $registerService;

    public function __construct(){
        $this->registerService = new EventService();
    }

    /**
    * EVENTOS - LISTA DE EVENTOS DO USUÁRIO
    *
    * @param Request: ID do Usuário;
    * @return EventResource || []: Collection App\Models\Event
    */
    public function userEvents(Request $request){
        try{
            $id = $request->input("user_id");
            $events = $this->registerService->get($id);
            return response()->json(['events' => $events], 200);
        }catch(\Exception $e) {
            //CAPTURAR ERRO E ENVIAR PARA O LOG
            Log::channel('register')->error("[Erro ao buscar Eventos do Usuário][Eventos]", ['[message]' => $e->getMessage(), '[error]' => $e->getTraceAsString()]);
            //REDIRECIONAR PARA O FORMULÁRIO COM A MENSAGEM DE ERRO
            throw new \Exception("Ocorreu um erro ao buscar so eventos. Por favor, tente novamente.");
        }
    }

    /**
    * EVENTOS - BUSCAR EVENTOS
    *
    * @param Request: ID do Usuário;
    * @return EventResource || []: Collection App\Models\Event
    */
    public function events(Request $request){
        try {
            //BUSCAR EVENTOS
            $events = $this->registerService->get();
            return response()->json(['events' => $events], 201);
        }catch(\Exception $e) {
            //CAPTURAR ERRO E ENVIAR PARA O LOG
            Log::channel('register')->error("[Erro ao buscar Eventos][Eventos]", ['[message]' => $e->getMessage(), '[error]' => $e->getTraceAsString()]);
            //REDIRECIONAR PARA O FORMULÁRIO COM A MENSAGEM DE ERRO
            throw new \Exception("Ocorreu um erro ao buscar so eventos. Por favor, tente novamente.");
        }
    }

    /**
    * EVENTOS - CRIAÇÃO DE EVENTOS
    *
    * @param Request: Dados do Evento e Participantes;
    * @return String: Mensagem de Sucesso ou Erro;
    */
    public function create(Request $request){
        try {
            //INICIALIZAR SERVIÇO DE EVENTOS E CRIAR NOVO EVENTO
            $event = $this->registerService->create($request->all());
            return response()->json(['evento' => $event], 201);
        }catch(\Exception $e) {
            //CAPTURAR ERRO E ENVIAR PARA O LOG
            Log::channel('register')->error("[Erro ao registrar Evento][Eventos]", ['[message]' => $e->getMessage(), '[error]' => $e->getTraceAsString()]);
            //REDIRECIONAR PARA O FORMULÁRIO COM A MENSAGEM DE ERRO
            throw new \Exception("Ocorreu um erro ao criar o evento. Por favor, tente novamente.");
        }
    }
    
    /**
    * EVENTOS - BUSCAR PARTICIPANTES DO EVENTO
    *
    * @param Request: Dados do Evento e Participantes;
    * @return ParticipantsResource || []:Collection App\Models\User
    */
    public function participants(Request $request){
        try {
            $participants = $this->registerService->participants($request->id);
            return response()->json(['participants' => $participants], 200);
        }catch(\Exception $e) {
            Log::channel('register')->error("[Erro de Registro][User][Registro]", ['[message]' => $e->getMessage(), '[error]' => $e->getTraceAsString()]);
            throw new \Exception("Ocorreu um erro ao buscar os participants do evento. Por favor, tente novamente.");
        }
    }
}
