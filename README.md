# Laravel Tasks API

A minimal **Laravel** API that serves tasks.  
Now uses **MySQL** (Eloquent) and supports **creating tasks**.

Clean layering: Controller → Request → Service → Repository → Model/Enum → Resource.

---

## Requirements

- PHP **8.1+** (8.2/8.3 OK)
- Composer
- Git
- MySQL **8+** (or MariaDB equivalent)

---

## Version History

- **1.1.0**
    - MySQL integration (Eloquent)
    - `POST /api/tasks` (create)
    - Database seeder (8 tasks)
- **1.0.0**
    - `GET /api/tasks` with in-memory data

---

## Installation

```bash
# 1) Clone
git clone https://github.com/DevAhmedRashad/palm_outsourcing_backend-.git
cd palm_outsourcing_backend-

git fetch origin
# Prefer Git 2.37+: 'git switch'
git switch feature/add-task-into-db

# 2) Install PHP dependencies
composer install

# 3) Copy env & generate app key
cp .env.example .env
php artisan key:generate
```

### 4) Configure Database (.env)

Edit `.env`:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tasks_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create the DB (in MySQL):
```sql
CREATE DATABASE tasks_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5) Migrate

```bash
php artisan migrate
```

### 6) Seed initial tasks

```bash
php artisan db:seed
```

### 7) Clear caches & run

```bash
php artisan optimize:clear
php artisan serve                    # http://127.0.0.1:8000
```

---

## Database Schema (tasks)

- `id` BIGINT PK
- `title` VARCHAR(150)
- `description` TEXT
- `status` ENUM(`pending`, `in_progress`, `done`)
- `timestamps`

> The API **returns human-readable labels** (`"Pending"`, `"In Progress"`, `"Done"`), while the DB stores the snake_case enum values.

---

## API Endpoints

### 1) GET `/api/tasks`

- **Auth:** none
- **Body:** none

**Example**
```bash
curl http://127.0.0.1:8000/api/tasks
```

**200 OK**
```json
[
  { "id": 1, "title": "Set up project", "description": "Init Laravel repo and configs", "status": "Pending" },
  { "id": 2, "title": "Design API schema", "description": "Decide fields for Task entity", "status": "In Progress" },
  { "id": 3, "title": "Implement /tasks", "description": "Return JSON list of tasks", "status": "Done" }
]
```

---

### 2) POST `/api/tasks`

Create a new task.

- **Auth:** none
- **Content-Type:** `application/json`
- **Body:**
    - `title` (string, required, ≤150)
    - `description` (string, required)
    - `status` (required) — accepts **`"Pending" | "In Progress" | "Done"`** or snake_case **`pending | in_progress | done`**

**Example**
```bash
curl -X POST http://127.0.0.1:8000/api/tasks   -H "Content-Type: application/json"   -d '{
    "title": "Write README",
    "description": "Add DB setup steps",
    "status": "In Progress"
  }'
```

**201 Created**
```json
{
  "id": 9,
  "title": "Write README",
  "description": "Add DB setup steps",
  "status": "In Progress"
}
```

**422 Unprocessable Entity (validation)**
```json
{
  "message": "The status field is invalid.",
  "errors": { "status": ["The selected status is invalid."] }
}
```

---

## Seeding

**database/seeders/TasksTableSeeder.php** seeds 8 tasks and is **idempotent** (safe to re-run).

```php
<?php

namespace Database\Seeders;

use App\Domain\Tasks\TaskStatus;   // enum: pending | in_progress | done
use App\Models\Task;               // Eloquent model with casts ['status' => TaskStatus::class]
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
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

        Task::query()->upsert(
            $rows,
            ['id'], // unique key(s)
            ['title', 'description', 'status', 'updated_at'] // columns to update on conflict
        );
    }
}
```

Run:
```bash
php artisan db:seed --class=TasksTableSeeder
```

---

## Project Structure (relevant parts)

```
app/
  Domain/
    Tasks/
      TaskStatus.php                 # Enum: DB values 'pending'|'in_progress'|'done'
  Http/
    Controllers/Api/TaskController.php
    Requests/StoreTaskRequest.php    # Validates POST /tasks
    Resources/TaskResource.php       # Maps enum to human labels
  Models/
    Task.php                         # Eloquent model; casts ['status' => TaskStatus::class]
  Repositories/
    Contracts/TaskRepositoryInterface.php
    Eloquent/EloquentTaskRepository.php
  Services/
    TaskService.php
routes/
  api.php                            # GET /tasks, POST /tasks
bootstrap/
  app.php                            # withRouting(... api: routes/api.php)
database/
  migrations/                        # tasks table (enum status)
  seeders/TasksTableSeeder.php
```
