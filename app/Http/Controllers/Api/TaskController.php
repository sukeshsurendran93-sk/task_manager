<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Task::class);

        $filters = $request->only(['search', 'status', 'priority']);
        $tasks = $this->taskService->paginate($request->user(), $filters);

        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->store($request->user(), $request->validated());

        return (new TaskResource($task->load(['assignee', 'createdBy'])))
            ->response()
            ->setStatusCode(201);
    }

    public function updateStatus(UpdateTaskStatusRequest $request, Task $task): TaskResource
    {
        $updated = $this->taskService->updateStatus($task->id, $request->validated('status'));

        return new TaskResource($updated);
    }

    public function aiSummary(Request $request, Task $task): TaskResource
    {
        $this->authorize('refreshAi', $task);

        $updated = $this->taskService->refreshAiSummary($task->id);

        return new TaskResource($updated->load(['assignee', 'createdBy']));
    }
}
