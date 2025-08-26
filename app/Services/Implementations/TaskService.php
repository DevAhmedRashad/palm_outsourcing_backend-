<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Services\Contracts\TaskServiceInterface;

class TaskService implements TaskServiceInterface
{
    public function __construct(private readonly TaskRepositoryInterface $taskRepository)
    {
    }

    /**
     * Fetch all tasks
     * @return array
     */
    public function all(): array
    {
        return $this->taskRepository->all();
    }
}
