<?php

namespace App\Services\Contracts;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskServiceInterface
{
    /**
     * Fetch all tasks
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param array $data
     * @return Task
     */
    public function create(array $data): Task;
}
