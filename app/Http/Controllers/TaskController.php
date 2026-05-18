<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

use App\Repositories\Contracts\UserRepositoryInterface;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function index(Request $request): Response
    {
        $this->authorize('viewAny', Task::class);

        $filters = $request->only(['search', 'status', 'priority', 'ai_priority']);
        $tasks = $this->taskService->paginate($request->user(), $filters);

        return Inertia::render('Task/Index', [
            'tasks' => TaskResource::collection($tasks),
            'filters' => $filters,
            'stats' => $this->taskService->analytics($request->user()),
            'users' => $this->userRepository->assignableUsers($request->user()),
        ]);
    }

    public function create(Request $request): Response
    {
        $this->authorize('create', Task::class);

        return Inertia::render('Task/Create', [
            'users' => $this->userRepository->assignableUsers($request->user()),
        ]);
    }

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $task = $this->taskService->store($request->user(), $request->validated());

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'Task created successfully.');
    }

    public function show(Request $request, Task $task): Response
    {
        $this->authorize('view', $task);

        return Inertia::render('Task/Show', [
            'task' => (new TaskResource($task->load(['assignee', 'createdBy'])))->resolve(),
            'stats' => $this->taskService->analytics($request->user()),
        ]);
    }

    public function edit(Request $request, Task $task): Response
    {
        $this->authorize('update', $task);

        return Inertia::render('Task/Edit', [
            'task' => (new TaskResource($task->load(['assignee', 'createdBy'])))->resolve(),
            'stats' => $this->taskService->analytics($request->user()),
            'users' => $this->userRepository->assignableUsers($request->user()),
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $this->taskService->update($task->id, $request->validated());

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $this->authorize('delete', $task);

        $this->taskService->delete($task->id);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    public function refreshAi(Request $request, Task $task): RedirectResponse
    {
        $this->authorize('refreshAi', $task);

        $this->taskService->refreshAiSummary($task->id);

        return back()->with('success', 'AI summary refreshed.');
    }
}
