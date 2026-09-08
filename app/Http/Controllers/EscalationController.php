<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\EscalationService;
use App\Models\Escalation;

class EscalationController extends Controller
{
    private $registerService;

    public function __construct(){
        $this->registerService = new EscalationService();
    }

    /**
    * ESCALAÇÃO - BUSCAR ESCALAÇÃO
    *
    * @param Request: ID do Usuário;
    * @return EventResource || []: Collection App\Models\Escalation
    */
    public function escalations(Request $request){
        try {
            //BUSCAR ESCALAÇÃO
            $escalations = $this->registerService->get();
            return response()->json(['escalations' => $escalations], 201);
        }catch(\Exception $e) {
            //CAPTURAR ERRO E ENVIAR PARA O LOG
            Log::channel('register')->error("[Erro ao buscar Escalações][Escalação]", ['[message]' => $e->getMessage(), '[error]' => $e->getTraceAsString()]);
            //REDIRECIONAR PARA O FORMULÁRIO COM A MENSAGEM DE ERRO
            throw new \Exception("Ocorreu um erro ao buscar as escalações. Por favor, tente novamente.");
        }
    }

    /**
    * ESCALAÇÃO - SALVAMENTO DE ESCALAÇÃO
    *
    * @param Request: Dados da escalação
    * @return String: Mensagem de Sucesso ou Erro;
    */
    public function save(Request $request){
        try {
            //INICIALIZAR SERVIÇO DE ESCALAÇÃO E CRIAR NOVO EVENTO
            $data = $this->registerService->save($request);
            return response()->json([
                'message' => 'Salvo com sucesso!',
                'data' => []//$data
            ], 200);
        }catch(\Exception $e) {
            //CAPTURAR ERRO E ENVIAR PARA O LOG
            Log::channel('register')->error("[Erro ao registrar Evento][Escalação]", ['[message]' => $e->getMessage(), '[error]' => $e->getTraceAsString()]);
            //REDIRECIONAR PARA O FORMULÁRIO COM A MENSAGEM DE ERRO
            throw new \Exception("Ocorreu um erro ao salvar a escalação. Por favor, tente novamente.");
        }
    }
}
