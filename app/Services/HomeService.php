<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\User;
use App\Resources\EventResource;
use App\Resources\UserResource;

class HomeService
{
    /* 
    * EVENTOS - RECOMENDADOS
    * @return EventResource || []: Array de eventos recomendados;
    */
    public function recommended()
    {
        $list = Event::with('address')
                ->where('modality', 'Football')
                ->orderBy('title')
                ->limit(10)
                ->get();
        //RETORNAR COLECAO DE ITENS
        return EventResource::collection($list);
    }
    /* 
    * EVENTOS - PROXIMOS DE VOCE
    * @params - Array Request: Dados de requisição recebidos;
    * @return - EventResource || []: Array de eventos próximos;
    */
    public function nearby(array $request)
    {
        //VERIFICAR SE LAT LONG FORAM INFORMADO
        //if(!isset($request['lat']) && !isset($request['lon'])) return [];
        //RESGATAR LAT E LON DO USUARIO
        $lat = -15.816489;//$request['lat'];
        $lon = -47.868992;//$request['lon'];
        //RAIO DE DISTANCIA
        $d = 10;

        //REDUZIR QUANTIDADE METRICAS DE BUSCA COM BOUDING BOX
        $maxLat = $lat + ($d / 111);
        $minLat = $lat - ($d / 111);

        $maxLon = $lon + ($d / (111 * cos(deg2rad($lat))));
        $minLon = $lon - ($d / (111 * cos(deg2rad($lat))));

        //BUSCAR EVENTOS NUM RAIO DE 5 KM DO USUARIO
        $list = Event::query()
            ->with('address')
            ->join('event_address', 'event_address.event_id', '=', 'events.id')
            ->join('address', 'address.id', '=', 'event_address.address_id')
            // FILTRO INICIAL DE LAT E LON (BOUNDING BOX)
            ->whereBetween('address.latitude', [
                $minLat,
                $maxLat
            ])
            ->whereBetween('address.longitude', [
                $minLon,
                $maxLon
            ])
            /* // CÁLCULO REAL DA DISTÂNCIA
            ->selectRaw("
                events.*,

                (
                    6371 *
                    acos(
                        cos(radians(?)) *
                        cos(radians(address.latitude)) *
                        cos(radians(address.longitude) - radians(?)) +
                        sin(radians(?)) *
                        sin(radians(address.latitude))
                    )
                ) AS distance
            ", [$lat, $lon, $lat]) */
            // ORDENAÇÃO
            ->orderBy('title')
            // LIMITE
            ->limit(10)
            ->get();
        return EventResource::collection($list);
    }
    /* 
    * EVENTOS - POPULARES
    * @return - EventResource || []: Array de eventos populares;
    */
    public function popular()
    {
        $list = Event::with('address','avaliations')
                ->whereHas('avaliations', function ($query){
                    $query->where('avaliation', '>=', 4.0);
                })
                ->orderBy('title')
                ->limit(10)
                ->get();
        return EventResource::collection($list);
    }
    /* 
    * EVENTOS - AO VIVO
    * @return - EventResource || []: Array de eventos ao vivo;
    */
    public function live()
    {
        $list = Event::with('address','room')
                ->whereHas('room', function ($query){
                    $query->where('status', 'Open');
                })
                ->orderBy('title')
                ->limit(10)
                ->get();
        return EventResource::collection($list);
    }
    /* 
    * EVENTOS - HOJE
    * @return - EventResource || []: Array de eventos hoje;
    */
    public function today()
    {
        Carbon::setLocale('pt_BR');
        //RESGATAR O DIA DA SEMANA ATUAL
        $weekDay = Str::ascii(Carbon::now()->translatedFormat('D'));
        $list = Event::with('address')
                ->whereJsonContains('date', 'ter')
                ->orderBy('title')
                ->limit(10)
                ->get();
        return EventResource::collection($list);
    }
    /* 
    * USUARIOS - TALVEZ VOCE CONHEÇA
    * @return - UserResource || []: Array de sugestões de usuários;
    */
    public function friends(array $request)
    {
        $list = User::orderBy('first_name')
                ->limit(10)
                ->get();
        //RETORNAR COLECAO DE ITENS
        return UserResource::collection($list);
    }
}