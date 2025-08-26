<?php

namespace App\Services\Implementations;

use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Services\Contracts\TaskServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskService implements TaskServiceInterface
{
    public function __construct(private readonly TaskRepositoryInterface $taskRepository)
    {
    }

    /**
     * Fetch all tasks
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->taskRepository->all();
    }

    public function create(array $data): Task
    {
        return $this->taskRepository->create($data);
    }
}
