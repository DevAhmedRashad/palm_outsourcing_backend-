<?php

namespace App\Repositories\Implementations;

use App\Domain\Tasks\Task;
use App\Domain\Tasks\TaskStatus;
use App\Repositories\Contracts\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{

    /**
     * @inheritDoc
     * Fetch all tasks
     * @return Task[]
     */
    public function all(): array
    {
        return [
            new Task(1, 'Set up project',       'Init Laravel repo and configs',        TaskStatus::Pending),
            new Task(2, 'Design API schema',    'Decide fields for Task entity',        TaskStatus::InProgress),
            new Task(3, 'Implement /tasks',     'Return JSON list of tasks',            TaskStatus::Done),
            new Task(4, 'Write README',         'Add run instructions',                 TaskStatus::Pending),
            new Task(5, 'Add CORS config',      'Allow Next.js localhost to call API',  TaskStatus::Done),
            new Task(6, 'Next.js grid page',    'Fetch & render tasks as grid',         TaskStatus::Pending),
        ];
    }
}
