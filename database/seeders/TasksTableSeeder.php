<?php

namespace Database\Seeders;

use App\Domain\Tasks\TaskStatus;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $rows = [
            ['id' => 1, 'title' => 'Set up project',       'description' => 'Init Laravel repo and configs',        'status' => TaskStatus::Pending->value,    'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'title' => 'Design API schema',    'description' => 'Decide fields for Task entity',        'status' => TaskStatus::InProgress->value, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'title' => 'Implement /tasks',     'description' => 'Return JSON list of tasks',            'status' => TaskStatus::Done->value,       'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'title' => 'Write README',         'description' => 'Add run instructions',                 'status' => TaskStatus::Pending->value,    'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'title' => 'Add CORS config',      'description' => 'Allow Next.js localhost to call API',  'status' => TaskStatus::Done->value,       'created_at' => $now, 'updated_at' => $now],
            ['id' => 6, 'title' => 'Next.js grid page',    'description' => 'Fetch & render tasks as grid',         'status' => TaskStatus::Pending->value,    'created_at' => $now, 'updated_at' => $now],
            ['id' => 7, 'title' => 'Polish code',          'description' => 'PSR-12, small refactors, comments',    'status' => TaskStatus::InProgress->value, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 8, 'title' => 'Final review',         'description' => 'Manual test & tidy repo',              'status' => TaskStatus::Pending->value,    'created_at' => $now, 'updated_at' => $now],
        ];

        //insert or update by primary key
        Task::query()->upsert(
            $rows,
            ['id'], // unique key(s)
            ['title', 'description', 'status', 'updated_at'] // columns to update on conflict
        );
    }
}
