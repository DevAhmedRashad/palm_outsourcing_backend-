# Laravel Tasks API

A minimal **Laravel** API that serves a hard‑coded list of tasks.  
**No database required.** Clean layering with Controller → Service → Repository → Domain (Task + Enum) → API Resource.

---

## Requirements

- PHP **8.1+** (8.2/8.3 OK)
- Composer
- Git

---

## Installation

```bash
# 1) Clone
git clone https://github.com/DevAhmedRashad/palm_outsourcing_backend-.git
cd palm_outsourcing_backend-

# 2) Install PHP dependencies
composer install

# 3) Environment & app key
cp .env.example .env
php artisan key:generate
```

```bash
# 4) Clear caches and verify route
php artisan optimize:clear
php artisan route:list --path=tasks  # should show: GET  api/tasks

# 5) Run the server
php artisan serve   # http://127.0.0.1:8000
```
---

## Project Structure (relevant parts)

```
app/
  Domain/
    Tasks/
      Task.php                 # Plain DTO (final / readonly fields)
      TaskStatus.php           # Enum: Pending | In Progress | Done
  Http/
    Controllers/Api/TaskController.php
    Resources/TaskResource.php # Stable API response shape
  Repositories/
    Contracts/TaskRepositoryInterface.php
    Implementations/TaskRepository.php  # Hard-coded data source
  Services/
    Contracts/TaskServiceInterface.php
    Implementations/TaskService.php
routes/
  api.php                      # GET /tasks (registered via bootstrap/app.php)
bootstrap/
  app.php                      # withRouting(... api: routes/api.php)
```
---

## Implemented Feature

---

### Version 1.0.0

--- 
### Endpoint

**GET** `/api/tasks`  
Returns a list of hard‑coded tasks.

- **Auth:** None
- **Body:** None
- **Query params:** None

#### Example Request

```bash
curl http://127.0.0.1:8000/api/tasks
```

#### Success Response — `200 OK`

```json
[
  {
    "id": 1,
    "title": "Set up project",
    "description": "Init Laravel repo and configs",
    "status": "Pending"
  },
  {
    "id": 2,
    "title": "Design API schema",
    "description": "Decide fields for Task entity",
    "status": "In Progress"
  },
  {
    "id": 3,
    "title": "Implement /tasks",
    "description": "Return JSON list of tasks",
    "status": "Done"
  }
  // ... up to 6 tasks total
]
```

---

## Notes

- **No DB**: Data is returned from an **in-memory repository** for simplicity.
- **Stable API**: `TaskResource` controls the exact JSON shape, independent of internals.
- **Type Safety**: `TaskStatus` enum guarantees valid statuses (`Pending`, `In Progress`, `Done`).
