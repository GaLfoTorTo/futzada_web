<?php

namespace App\Enums;

enum GameStatus: string
{
    case Scheduled  = 'Scheduled';
    case InProgress = 'InProgress';
    case Completed  = 'Completed';
    case Cancelled  = 'Cancelled';

    public static function fromDatabase(string $value): self
    {
        return match($value) {
            'scheduled'   => self::Scheduled,
            'in_progress' => self::InProgress,
            'finished'    => self::Completed,
            'cancelled'   => self::Cancelled,
        };
    }

    public function toDatabase(): string
    {
        return match($this) {
            self::Scheduled  => 'scheduled',
            self::InProgress => 'in_progress',
            self::Completed  => 'finished',
            self::Cancelled  => 'cancelled',
        };
    }
}
