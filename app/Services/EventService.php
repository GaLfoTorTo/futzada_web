<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\User;
use App\Models\Participant;
use App\Resources\EventResource;
use App\Resources\UserResource;

class EventService
{
    /**
    * EVENTO - BUSCAR EVENTO
    * @param int: Id do evento
    * @return EventResource - App\Models\Event: Evento ;
    */
    public function find(int $id)
    {
        //BUSCAR EVENTO A PARTIR DO ID
        $event = Event::with(['address', 'gameConfig', 'avaliations', 'participants.user', 'rules', 'news', 'games'])->find($id);
        return EventResource::make($event);
    }
    
    /**
    * EVENTOS - BUSCAR EVENTOS DO USUÁRIO
    * @param int $id: ID do usuário
    * @return EventResource[]: Collection de eventos formatados;
    */
    public function get(?int $id=null)
    {
        $query = Event::query()->when($id, fn($q) => $q->whereHas('users', fn($q) => $q->where('users.id', $id)));

        $eventIds   = (clone $query)->pluck('id');
        $modalities = (clone $query)->pluck('modality')->unique();

        $events = $query->with([
                            'address', 'gameConfig', 'avaliations', 'rules', 'news', 'games',
                            'users' => fn($q) => $q->with([
                                'manager'  => fn($p) => $p->with([
                                    'ratings'   => fn($r) => $r->where('role', 'Manager'),
                                    'economies'   => fn($e) => $e->whereIn('event_id', $eventIds),
                                ]),
                                'player'  => fn($p) => $p->with([
                                    'ratings'   => fn($r) => $r->where('role', 'Player'),
                                    'positions' => fn($p) => $p->whereIn('positions.modality', $modalities),
                                ]),
                            ]),
                        ])->get();
        
        return EventResource::collection($events);
    }

    /**
    * EVENTOS - CRIAÇÃO DE EVENTOS
    * @param Request: Dados do Evento e Participantes;
    * @return EventResource - App\Models\Event: Evento;
    */
    public function create(Request $request)
    {
        //INICIALIZAR TRANSAÇÃO NO DB
        DB::beginTransaction();
        //DEFINIR DADOS BASICOS DA PELADA
        $data = [
            'uuid' => (string) Str::uuid(),
            'title'=> $request['title'],
            'bio'=> $request['bio'],
            'address'=> $request['address'],
            'number'=> $request['number'],
            'city'=> $request['city'],
            'state'=> $request['state'],
            'complement'=> $request['complement'],
            'country'=> $request['country'],
            'zip_code'=> $request['zip_code'],
            'days_week'=> json_encode($request['days_week']),
            'date'=> date('Y-m-d', strtotime($request['date'])),
            'time'=> date('H:i', strtotime($request['time'])),
            'category'=> $request['category'],
            'qtd_players'=> $request['qtd_players'],
            'visibility'=> $request['visibility'],
            'allow_collaborators'=> $request['allow_collaborators'],
        ];
        //VERIFICAR SE FOI RECEBIDO FOTO DO USUÁRIO
        if($request->hasFile('photo')){
            //RESGATAR RESQUEST PARA FUNÇÃO DE UPLOAD
            $dataFile['request'] = $request;
            //DEFINIR PASTA DE ARQUIVOS DO USUARIO
            $dataFile['pasta'] = 'events/'.$data['uuid'];
            //SALVAR FOTO DE USUARIO
            $data['photo'] = upload($dataFile);
        }
        //SALVAR EVENTO
        $event = Event::create($data);
        //SALVAR PARTICIPANTES
        $this->participantsEvent($request->participantes, $event->id);
        //CONSOLIDAR OPERAÇÃO
        DB::commit();
        return new EventResource($event);
    }
    
    /**
    * EVENTOS - BUSCA DE PARTICIPANTS
    * @param Request: Id do evento
    * @return UserResource - App\Models\User: Users;
    */
    public function participants(int $id)
    {
        $users = User::whereHas('participants', function ($q) use ($id) {
                        $q->where('event_id', $id);
                    })->with(['participants' => function ($q) use ($id) {
                        $q->where('event_id', $id);
                    }])->get();

        return UserResource::collection($users);
    }
}