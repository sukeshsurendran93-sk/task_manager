# AI-Assisted Task Management System

Production-oriented Laravel + Vue 3 (Inertia) task manager with **Repository pattern**, **Service layer**, **Policies**, and **AI summaries**.

## Tech Stack

- Laravel 13 + MySQL
- Vue 3 + Inertia.js + Tailwind CSS
- Chart.js (sidebar analytics)
- Laravel Breeze (authentication)
- Laravel Sanctum (REST API)
- Gemini-compatible API (optional; mock fallback)

## Architecture

```
app/
├── Enums/              # TaskStatus, TaskPriority, AiPriority, UserRole
├── Http/
│   ├── Controllers/
│   │   ├── TaskController.php      # Inertia web UI (no Eloquent)
│   │   └── Api/TaskController.php  # REST API
│   ├── Requests/                   # Form validation
│   └── Resources/                  # API / Inertia transformers
├── Models/
├── Policies/TaskPolicy.php
├── Repositories/
│   ├── Contracts/TaskRepositoryInterface.php
│   └── Eloquent/TaskRepository.php
├── Services/
│   ├── TaskService.php             # Business logic + transactions
│   └── AIService.php               # AI calls (not used in controllers)
├── Jobs/GenerateTaskAiSummaryJob.php
└── Providers/RepositoryServiceProvider.php
```

**Flow:** `Controller → Service → Repository → Eloquent Model`

Controllers never call Eloquent or AI directly.

## Roles

| Role  | Access                                     |
|-------|--------------------------------------------|
| User  | Tasks assigned to them only                |
| Admin | All tasks + assign to any user             |

Seeded accounts (password: `password`):

- Admin: `admin@taskmanager.test`
- User: `user@taskmanager.test`

## AI Integration

`AIService::generateSummary()` is invoked from `TaskService` on create and refresh.

### Prompt (documented)

```
You are a task management assistant. Analyze the task and respond ONLY with valid JSON.

Task title: {title}
Description: {description}
Status: {status}
Priority: {priority}
Due date: {due_date}

Return JSON:
{
  "ai_summary": "2-3 sentence actionable summary",
  "ai_priority": "low|medium|high"
}
```

### Configuration (`.env`)

```env
AI_DRIVER=mock          # mock | gemini
AI_QUEUE=false          # true = queue GenerateTaskAiSummaryJob
GEMINI_API_KEY=         # leave empty for mock
GEMINI_MODEL=gemini-1.5-flash
GEMINI_BASE_URL=https://generativelanguage.googleapis.com/v1beta
```

If the API fails or keys are missing, a **mock fallback** is used automatically.

## API Endpoints (Sanctum)

| Method | Endpoint                    | Description        |
|--------|-----------------------------|--------------------|
| GET    | `/api/tasks`                | List tasks         |
| POST   | `/api/tasks`                | Create task        |
| PATCH  | `/api/tasks/{id}/status`    | Update status      |
| GET    | `/api/tasks/{id}/ai-summary`| Refresh AI summary |

Authenticate with Sanctum token: `Authorization: Bearer {token}`

## Web Routes

- `GET /tasks` — Task list
- `GET /tasks/create` — Create form
- `GET /tasks/{id}` — Detail + AI summary
- `GET /tasks/{id}/edit` — Edit form
- `POST /tasks/{id}/refresh-ai` — Regenerate AI summary

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
# Configure DB_* in .env
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

## Dashboard Analytics

Sidebar stats (total, completed, in progress) and monthly completion bars are loaded from `TaskRepository::analytics()` and `monthlyCompletion()`.

## Testing

```bash
php artisan test
```

## Screenshots

Screenshots of the three UI screens are in `/docs/screenshots/`.
