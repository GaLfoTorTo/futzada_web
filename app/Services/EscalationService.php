<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Resources\EscalationResource;
use App\Resources\PatrimonyResource;
use App\Models\Escalation;
use App\Models\Economy;

class EscalationService
{
    /**
    * ESCALATION - BUSCAR ESCALATION
    * @param int: Id da Escalação
    * @return EscalationResource - App\Models\Escalation: Escalação ;
    */
    public function find(int $id)
    {
        //BUSCAR EVENTO A PARTIR DO ID
        $escalation = Escalation::find($id);
        return EscalationResource::make($escalation);
    }
    
    /**
    * EVENTOS - BUSCAR EVENTOS DO USUÁRIO
    * @param int $id: ID do usuário
    * @return EscalationResource[]: Collection de eventos formatados;
    */
    public function get(?int $id=null)
    {
        $query = Escalation::query()->when($id, fn($q) => $q->whereHas('users', fn($q) => $q->where('users.id', $id)));

        $escalationIds   = (clone $query)->pluck('id');
        $modalities = (clone $query)->pluck('modality')->unique();

        $escalations = $query->get();
        
        return EscalationResource::collection($escalations);
    }

    /**
    * EVENTOS - SALVAMENTO DE ESCALAÇÃO E PATRIMONIO
    * @param Request: Dados do Evento e Participantes;
    * @return EscalationResource - App\Models\Escalation: Escalação;
    */
    public function save(Request $request)
    {
        try {
            //INICIALIZAR TRANSAÇÃO NO DB
            DB::beginTransaction();
            Log::channel('register')->info($request->all());
            //DEFINIR DADOS BASICOS DA PELADA
            $eData = $request->escalation;
            $pData = $request->patrimonio;
            //SALVAR EVENTO
            $escalation = [];//Escalation::createOrUpdate($data);
            $economy = [];//Economy::createOrUpdate($data);
            //CONSOLIDAR OPERAÇÃO
            DB::commit();
            return [
                'escalation' => EscalationResource::make($escalation),
                'economy'  => EscalationResource::make($economy),
            ];
        } catch (\Exception $e) {
            throw new \Exception("Ocorreu um erro ao salvar a escalação. Por favor, tente novamente.");
        }
    }
}