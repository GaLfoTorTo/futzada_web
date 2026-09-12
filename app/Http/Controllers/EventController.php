<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\EventService;
use App\Services\GameService;
use App\Models\Event;
use App\Models\User;
use App\Models\Participant;

class EventController extends Controller
{
    private $registerService;
    private $gameService;

    public function __construct(){
        $this->registerService = new EventService();
        $this->gameService = new GameService();
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
    * EVENTOS - BUSCAR EVENTOS
    *
    * @param Request: UUID do Evento || ID do Usuário;
    * @return EventResource || []: Collection App\Models\Event
    */
    public function events(Request $request){
        try {
            //BUSCAR EVENTOS
            $events = $this->registerService->get();
            return response()->json(['events' => $events], 200);
        }catch(\Exception $e) {
            //CAPTURAR ERRO E ENVIAR PARA O LOG
            Log::channel('register')->error("[Erro ao buscar Eventos][Eventos]", ['[message]' => $e->getMessage(), '[error]' => $e->getTraceAsString()]);
            //REDIRECIONAR PARA O FORMULÁRIO COM A MENSAGEM DE ERRO
            throw new \Exception("Ocorreu um erro ao buscar so eventos. Por favor, tente novamente.");
        }
    }
    
    /**
    * EVENTO - BUSCAR PARTICIPANTES DO EVENTO
    *
    * @param Request: UUID do Evento;
    * @return ParticipantsResource || []:Collection App\Models\User
    */
    public function participants(Request $request){
        try {
            $uuid = $request->segment(3);
            $participants = $this->registerService->participants($uuid);
            return response()->json(['participants' => $participants], 200);
        }catch(\Exception $e) {
            Log::channel('register')->error("[Erro de buscar participantes][User][Registro]", ['[message]' => $e->getMessage(), '[error]' => $e->getTraceAsString()]);
            throw new \Exception("Ocorreu um erro ao buscar os participants do evento! Por favor, tente novamente.");
        }
    }

    /**
    * EVENTO - BUSCAR RANKINGS EVENTOS
    *
    * @param Request: UUID do Evento;
    * @return RankResource || []: Collection App\Models\Rank
    */
    public function rank(Request $request){
        try {
            //BUSCAR EVENTOS
            $uuid = $request->segment(3);
            $rank = $this->registerService->get(uuid: $uuid);
            return response()->json(['rank' => $rank], 200);
        }catch(\Exception $e) {
            //CAPTURAR ERRO E ENVIAR PARA O LOG
            Log::channel('register')->error("[Erro ao buscar Rankings][Eventos]", ['[message]' => $e->getMessage(), '[error]' => $e->getTraceAsString()]);
            //REDIRECIONAR PARA O FORMULÁRIO COM A MENSAGEM DE ERRO
            throw new \Exception("Ocorreu um erro ao buscar so rankings do evento! Por favor, tente novamente.");
        }
    }
    
    /**
    * EVENTO - BUSCAR REGRAS DO EVENTOS
    *
    * @param Request: UUID do Evento;
    * @return RuleResource || []: Collection App\Models\Rule
    */
    public function rules(Request $request){
        try {
            //BUSCAR EVENTOS
            $uuid = $request->segment(3);
            $rules = $this->registerService->get(uuid: $uuid);
            return response()->json(['rules' => $rules], 200);
        }catch(\Exception $e) {
            //CAPTURAR ERRO E ENVIAR PARA O LOG
            Log::channel('register')->error("[Erro ao buscar Rankings][Eventos]", ['[message]' => $e->getMessage(), '[error]' => $e->getTraceAsString()]);
            //REDIRECIONAR PARA O FORMULÁRIO COM A MENSAGEM DE ERRO
            throw new \Exception("Ocorreu um erro ao buscar so rankings do evento! Por favor, tente novamente.");
        }
    }
    
    /**
    * EVENTO - BUSCAR NOTÍCIAS DO EVENTOS
    *
    * @param Request: UUID do Evento;
    * @return NewsResource || []: Collection App\Models\News
    */
    public function news(Request $request){
        try {
            //BUSCAR EVENTOS
            $uuid = $request->segment(3);
            $news = $this->registerService->get(uuid: $uuid);
            return response()->json(['news' => $news], 200);
        }catch(\Exception $e) {
            //CAPTURAR ERRO E ENVIAR PARA O LOG
            Log::channel('register')->error("[Erro ao buscar Rankings][Eventos]", ['[message]' => $e->getMessage(), '[error]' => $e->getTraceAsString()]);
            //REDIRECIONAR PARA O FORMULÁRIO COM A MENSAGEM DE ERRO
            throw new \Exception("Ocorreu um erro ao buscar so rankings do evento! Por favor, tente novamente.");
        }
    }

    /**
    * EVENTOS - BUSCAR EVENTOS
    *
    * @param Request: UUID do Evento;
    * @return GameResource || []: Collection App\Models\Games
    */
    public function games(Request $request){
        try {
            //BUSCAR EVENTO PELO UUID
            $uuid  = $request->segment(3);
            $games = $this->gameService->get($uuid);
            return response()->json(['games' => $games], 200);
        }catch(\Exception $e) {
            //CAPTURAR ERRO E ENVIAR PARA O LOG
            Log::channel('events')->error("[Erro ao buscar partidas do evento][Partidas][EventController]", ['[message]' => $e->getMessage(), '[error]' => $e->getTraceAsString()]);
            throw new \Exception("Ocorreu um erro ao buscar as partidas do evento. Por favor, tente novamente.");
        }
    }
}
