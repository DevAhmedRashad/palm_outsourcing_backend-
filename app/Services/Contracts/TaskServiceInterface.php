<?php

namespace App\Services\Contracts;

use App\Domain\Tasks\Task;

interface TaskServiceInterface
{
    /**
     * Fetch all tasks
     * @return array
     */
    public function all(): array;
}
