<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LogsClear extends Command
{
    protected $signature = 'logs:clear';

    protected $description = 'Renomeia os arquivos de log atuais com sufixo de data e recria-os vazios com permissões ajustadas.';

    private const LOG_FILES = [
        'laravel.log',
        'auth.log',
        'register.log',
        'events.log',
        'files.log',
        'notifications.log',
    ];

    public function handle(): int
    {
        $logsPath = storage_path('logs');
        $suffix   = now()->format('Y-m-d');

        foreach (self::LOG_FILES as $filename) {
            $current = "{$logsPath}/{$filename}";

            if (!file_exists($current)) {
                $this->line("  [ignorado] {$filename} não existe, criando novo...");
                $this->createEmpty($current, $filename);
                continue;
            }

            $ext      = pathinfo($filename, PATHINFO_EXTENSION);
            $base     = pathinfo($filename, PATHINFO_FILENAME);
            $archived = "{$logsPath}/{$base}_{$suffix}.{$ext}";

            if (!rename($current, $archived)) {
                $this->error("  [erro] Não foi possível renomear {$filename}.");
                continue;
            }

            $this->line("  [ok] {$filename} → {$base}_{$suffix}.{$ext}");

            $this->createEmpty($current, $filename);
        }

        $this->info('Rotação de logs concluída.');
        return self::SUCCESS;
    }

    private function createEmpty(string $path, string $filename): void
    {
        file_put_contents($path, '');
        chmod($path, 0664);
        $this->line("  [criado] {$filename} (vazio, 0664)");
    }
}
