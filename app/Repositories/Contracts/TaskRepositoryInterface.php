<?php

namespace App\Repositories\Contracts;

use App\Domain\Tasks\Task;

interface TaskRepositoryInterface
{
    /**
     * Fetch all tasks
     * @return Task[]
     */
    public function all(): array;
}
