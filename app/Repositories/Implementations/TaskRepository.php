<?php

namespace App\Repositories\Implementations;

use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    /**
     * @var Task
     */
    protected $model;

    /**
     * TaskRepository constructor.
     */
    public function __construct(Task $task)
    {
        $this->model = $task;
    }

    /**
     * @inheritDoc
     * Fetch all tasks
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->query()
            ->select(['id', 'title', 'description', 'status'])
            ->orderBy('id')
            ->get();
    }

    /**
     * @param array $data
     * @return Task
     */
    public function create(array $data): Task
    {
        return $this->model->create($data);
    }
}
