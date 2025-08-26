<?php

namespace App\Domain\Tasks;

enum TaskStatus: string
{
    // Store these exact strings in DB:
    case Pending    = 'pending';
    case InProgress = 'in_progress';
    case Done       = 'done';

    /** Human label for API responses */
    public function label(): string
    {
        return match ($this) {
            self::Pending    => 'Pending',
            self::InProgress => 'In Progress',
            self::Done       => 'Done',
        };
    }

    /** Accepts 'Pending', 'In Progress', 'pending', 'in-progress', 'in_progress', etc. */
    public static function fromMixed(string $value): self
    {
        $k = strtolower(trim($value));
        $k = str_replace([' ', '-'], '_', $k);

        return match ($k) {
            'pending'     => self::Pending,
            'in_progress' => self::InProgress,
            'done'        => self::Done,
            default       => throw new \InvalidArgumentException("Invalid status: {$value}"),
        };
    }

    /** Raw DB values (['pending','in_progress','done']) */
    public static function values(): array
    {
        return array_map(fn ($c) => $c->value, self::cases());
    }
}
