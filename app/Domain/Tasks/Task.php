<?php

namespace App\Domain\Tasks;

final class Task
{
    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param TaskStatus $status
     */
    public function __construct(
        public int        $id,
        public string     $title,
        public string     $description,
        public TaskStatus $status,
    ) {}
}
