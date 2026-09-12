<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GamesSchedule extends Command
{
    protected $signature = 'games:schedule {--date= : Data alvo no formato Y-m-d (padrão: hoje)}';

    protected $description = 'Gera os registros de partidas agendadas para eventos que ocorrem no dia informado.';

    // Mapeamento Carbon dayOfWeek (0=dom) para abreviação PT
    private const DAY_MAP = [
        0 => 'dom',
        1 => 'seg',
        2 => 'ter',
        3 => 'qua',
        4 => 'qui',
        5 => 'sex',
        6 => 'sab',
    ];

    public function handle(): int
    {
        try {
            $targetDate = $this->option('date')
                ? Carbon::parse($this->option('date'))->startOfDay()
                : Carbon::today();

            $dayAbbr = self::DAY_MAP[$targetDate->dayOfWeek];

            $this->info("Gerando partidas para {$targetDate->toDateString()} ({$dayAbbr})...");

            $events = Event::with('gameConfig')
                ->whereJsonContains('date', $dayAbbr)
                ->get();

            if ($events->isEmpty()) {
                $this->info('Nenhum evento encontrado para este dia.');
                return self::SUCCESS;
            }

            foreach ($events as $event) {
                $this->processEvent($event, $targetDate);
            }

            $this->info('Concluído.');
            return self::SUCCESS;

        } catch (\Exception $e) {
            Log::channel('events')->error("[Erro ao gerar partidas][Partidas][Command]", ['[message]' => $e->getMessage(), '[error]' => $e->getTraceAsString()]);
            $this->error("Erro inesperado ao gerar partidas: {$e->getMessage()}");
            return self::FAILURE;
        }
    }

    //FUNÇÃO DE PROCESSAMENTO DE PARTIDAS
    private function processEvent(Event $event, Carbon $targetDate): void
    {
        try {

            $config = $event->gameConfig;

            if (!$config || !$config->duration) {
                $this->warn("  [ignorado] Evento #{$event->id} sem GameConfig ou duration definida.");
                Log::channel('events')->error("[Evento sem configuração de partida][Partidas][Command]", ['[event_id]' => $event->id, '[message]' => 'GameConfig ausente ou duration não definida']);
                return;
            }

            $alreadyExists = Game::where('event_id', $event->id)
                ->whereDate('date', $targetDate)
                ->exists();

            if ($alreadyExists) {
                $this->line("  [pulando] Evento #{$event->id} já tem partidas para {$targetDate->toDateString()}.");
                return;
            }

            $slots = $this->calculateSlots(
                $event->start_time,
                $event->end_time,
                $config->duration
            );

            if (empty($slots)) {
                $this->warn("  [ignorado] Evento #{$event->id} sem janela de tempo suficiente para partidas.");
                Log::channel('events')->error("[Janela de tempo insuficiente][Partidas][Command]", ['[event_id]' => $event->id, '[start_time]' => $event->start_time, '[end_time]' => $event->end_time, '[duration]' => $config->duration]);
                return;
            }

            $games = [];
            foreach ($slots as $index => $slot) {
                $games[] = [
                    'number'     => $index + 1,
                    'duration'   => $config->duration,
                    'date'       => $targetDate->toDateString(),
                    'start_time' => $slot['start'],
                    'end_time'   => $slot['end'],
                    'status'     => 'scheduled',
                    'event_id'   => $event->id,
                    'referee_id' => $config->referee_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Game::insert($games);

            $count = count($games);
            $this->info("  [ok] Evento #{$event->id} — {$event->title}: {$count} partida(s) criada(s).");

        } catch (\Exception $e) {
            Log::channel('events')->error("[Erro ao processar evento][Partidas][Command]", ['[event_id]' => $event->id, '[message]' => $e->getMessage(), '[error]' => $e->getTraceAsString()]);
            $this->error("  [erro] Evento #{$event->id}: {$e->getMessage()}");
        }
    }

    //FUNÇÃO DE CALCULO DE QUANTIDADE E HORARIO DE PARTIDAS
    private function calculateSlots(string $startTime, string $endTime, int $durationMinutes): array
    {
        $start = Carbon::parse($startTime);
        $end   = Carbon::parse($endTime);

        $slots = [];
        $current = $start->copy();

        while ($current->copy()->addMinutes($durationMinutes)->lte($end)) {
            $slots[] = [
                'start' => $current->format('H:i:s'),
                'end'   => $current->copy()->addMinutes($durationMinutes)->format('H:i:s'),
            ];
            $current->addMinutes($durationMinutes);
        }

        return $slots;
    }
}
