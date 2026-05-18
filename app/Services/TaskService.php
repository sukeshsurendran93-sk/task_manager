<?php

namespace App\Services;

use App\Jobs\GenerateTaskAiSummaryJob;
use App\Models\Task;
use App\Models\User;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public function __construct(
        protected TaskRepositoryInterface $taskRepository,
        protected AIService $aiService,
    ) {}

    public function paginate(User $user, array $filters = []): LengthAwarePaginator
    {
        return $this->taskRepository->all($this->scopedFilters($user, $filters));
    }

    public function find(int $id): ?Task
    {
        return $this->taskRepository->find($id);
    }

    public function analytics(User $user): array
    {
        $stats = $this->taskRepository->analytics($this->scopedFilters($user, []));

        return array_merge($stats, [
            'monthly' => $this->taskRepository->monthlyCompletion($this->scopedFilters($user, [])),
        ]);
    }

    public function store(User $user, array $data): Task
    {
        return DB::transaction(function () use ($user, $data) {
            $task = $this->taskRepository->create(array_merge($data, [
                'created_by' => $user->id,
            ]));

            $this->processAi($task);

            return $task->fresh(['assignee', 'createdBy']);
        });
    }

    public function update(int $id, array $data): Task
    {
        return DB::transaction(function () use ($id, $data) {
            return $this->taskRepository->update($id, $data);
        });
    }

    public function updateStatus(int $id, string $status): Task
    {
        return $this->taskRepository->update($id, ['status' => $status]);
    }

    public function delete(int $id): bool
    {
        return $this->taskRepository->delete($id);
    }

    public function refreshAiSummary(int $id): Task
    {
        $task = $this->taskRepository->find($id);

        abort_if(! $task, 404);

        if (config('services.ai.queue')) {
            GenerateTaskAiSummaryJob::dispatch($id);

            return $task;
        }

        $aiData = $this->aiService->generateSummary($task);

        return $this->taskRepository->updateAi($id, $aiData);
    }

    protected function processAi(Task $task): void
    {
        if (config('services.ai.queue')) {
            GenerateTaskAiSummaryJob::dispatch($task->id);

            return;
        }

        $aiData = $this->aiService->generateSummary($task);
        $this->taskRepository->updateAi($task->id, $aiData);
    }

    protected function scopedFilters(User $user, array $filters): array
    {
        if (! $user->isAdmin()) {
            $filters['assigned_to'] = $user->id;
        }

        return $filters;
    }
}
