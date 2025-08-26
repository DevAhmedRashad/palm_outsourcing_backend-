<?php

namespace App\Domain\Tasks;

enum TaskStatus: string
{
    case Pending = 'Pending';
    case InProgress = 'In Progress';
    case Done = 'Done';

    public static function fromString(string $value): self
    {
        return match ($value) {
            'Pending' => self::Pending,
            'In Progress' => self::InProgress,
            'Done' => self::Done,
            default => throw new \InvalidArgumentException("Invalid status: {$value}"),
        };
    }
}
