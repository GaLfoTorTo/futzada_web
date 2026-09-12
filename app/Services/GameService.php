<?php

namespace App\Services;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Fluent;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\Game;
use App\Resources\GameResource;

class GameService
{
    private const DAY_MAP = [
        0 => 'dom',
        1 => 'seg',
        2 => 'ter',
        3 => 'qua',
        4 => 'qui',
        5 => 'sex',
        6 => 'sab',
    ];

    /**
     * PARTIDAS - BUSCAR PARTIDAS DO EVENTO
     *
     * @param Event $event
     * @return array { preview: bool, date: string, games: Lista App\Models\Game }
     */
    public function get(?string $uuid): AnonymousResourceCollection
    {
        try {
            //BUSCAR EVENTO
            $event = Event::with('gameConfig')->where('uuid', $uuid)->firstOrFail();
            //ENCONTRAR O DIA MAIS PRÓXIMO (>= HOJE) QUE PERTENCE AO EVENTO
            $targetDate = $this->resolveNextDate($event);

            if (!$targetDate) {
                return GameResource::collection([]);
            }

            //BUSCAR PARTIDAS JÁ GERADAS NO BANCO
            $games = Game::where('event_id', $event->id)
                ->whereDate('date', $targetDate)
                ->when(
                    $targetDate->isToday(),
                    //HOJE: IN_PROGRESS PRIMEIRO, DEPOIS SCHEDULED POR HORÁRIO
                    fn($q) => $q->orderByRaw("FIELD(status, 'in_progress', 'scheduled', 'finished', 'cancelled')")
                               ->orderBy('start_time'),
                    //OUTRO DIA: APENAS AGENDADAS POR HORÁRIO
                    fn($q) => $q->where('status', 'scheduled')->orderBy('start_time')
                )
                ->with(['result', 'teams'])
                ->get();

            if ($games->isNotEmpty()) {
                return GameResource::collection($games);
            }

            //FALLBACK: CALCULAR PREVISÃO COM BASE NA GAMECONFIG
            $preview = $this->preview($event, $targetDate);

            return GameResource::collection($preview);

        } catch (\Exception $e) {
            Log::channel('events')->error("[Erro ao buscar partidas do evento][Partidas][GameService]", ['[event_id]' => $event->id, '[message]' => $e->getMessage(), '[error]' => $e->getTraceAsString()]);
            throw new \Exception("Ocorreu um erro ao buscar as partidas do evento. Por favor, tente novamente.");
        }
    }

    /**
     * PARTIDAS - GERAR PARTIDAS DE PREVIEW DO EVENTO
     *
     * @param Event $event
     * @return GameResource: Lista de App\Models\Game
     */
    private function preview(Event $event, Carbon $targetDate): array
    {
        try {
            $config = $event->gameConfig;

            if (!$config || !$config->duration) {
                Log::channel('events')->error("[Previsão impossível: evento sem GameConfig][Partidas][GameService]", ['[event_id]' => $event->id]);
                return [];
            }

            $start    = Carbon::parse($event->start_time);
            $end      = Carbon::parse($event->end_time);
            $current  = $start->copy();
            $number   = 1;
            $preview  = [];

            while ($current->copy()->addMinutes($config->duration)->lte($end)) {
                $slotEnd = $current->copy()->addMinutes($config->duration);

                $preview[] = new Fluent([
                    'id'         => null,
                    'number'     => $number,
                    'event_id'   => $event->id,
                    'referee_id' => $config->referee_id,
                    'duration'   => $config->duration,
                    'date'       => $targetDate->toDateString(),
                    'start_time' => $current->format('H:i:s'),
                    'end_time'   => $slotEnd->format('H:i:s'),
                    'status'     => 'scheduled',
                    'result'     => null,
                    'teams'      => [],
                    'created_at' => null,
                    'updated_at' => null,
                    'deleted_at' => null,
                ]);

                $current->addMinutes($config->duration);
                $number++;
            }

            return $preview;

        } catch (\Exception $e) {
            Log::channel('events')->error("[Erro ao calcular previsão de partidas][Partidas][GameService]", ['[event_id]' => $event->id, '[message]' => $e->getMessage(), '[error]' => $e->getTraceAsString()]);
            return [];
        }
    }

    /**
     * PARTIDAS - RESOLVER PROXIMO DIA DE EVENTO
     *
     * @param Event $event
     * @return Carbon: date
     */
    private function resolveNextDate(Event $event): ?Carbon
    {
        $eventDays = $event->date ?? [];

        if (empty($eventDays)) {
            return null;
        }

        $candidate = Carbon::today();

        for ($i = 0; $i < 7; $i++) {
            $abbr = self::DAY_MAP[$candidate->dayOfWeek];
            if (in_array($abbr, $eventDays)) {
                return $candidate;
            }
            $candidate->addDay();
        }

        return null;
    }
}
