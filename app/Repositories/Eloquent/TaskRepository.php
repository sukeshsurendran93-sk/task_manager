<?php

namespace App\Repositories\Eloquent;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class TaskRepository implements TaskRepositoryInterface
{
    public function all(array $filters = []): LengthAwarePaginator
    {
        return Task::query()
            ->with(['assignee', 'createdBy'])
            ->filter($filters)
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    public function find(int $id): ?Task
    {
        return Task::with(['assignee', 'createdBy'])->find($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(int $id, array $data): Task
    {
        $task = Task::findOrFail($id);
        $task->update($data);

        return $task->fresh(['assignee', 'createdBy']);
    }

    public function delete(int $id): bool
    {
        return (bool) Task::destroy($id);
    }

    public function updateAi(int $id, array $data): Task
    {
        $task = Task::findOrFail($id);
        $task->update([
            'ai_summary' => $data['ai_summary'] ?? $task->ai_summary,
            'ai_priority' => $data['ai_priority'] ?? $task->ai_priority,
        ]);

        return $task->fresh(['assignee', 'createdBy']);
    }

    public function analytics(array $filters = []): array
    {
        $base = Task::query()->filter($filters);

        $total = (clone $base)->count();
        $completed = (clone $base)->where('status', TaskStatus::Completed)->count();
        $pending = (clone $base)->where('status', TaskStatus::Pending)->count();
        $inProgress = (clone $base)->where('status', TaskStatus::InProgress)->count();
        $highPriority = (clone $base)->where('priority', 'high')->count();

        return [
            'total' => $total,
            'completed' => $completed,
            'pending' => $pending,
            'in_progress' => $inProgress,
            'high_priority' => $highPriority,
            'completed_percentage' => $total > 0 ? (int) round(($completed / $total) * 100) : 0,
            'in_progress_percentage' => $total > 0 ? (int) round(($inProgress / $total) * 100) : 0,
            'total_percentage' => $total > 0 ? 100 : 0,
        ];
    }

    public function monthlyCompletion(array $filters = []): array
    {
        return collect(range(4, 0))
            ->map(fn (int $i) => Carbon::now()->subMonths($i)->startOfMonth())
            ->map(function (Carbon $month) use ($filters) {
                $count = Task::query()
                    ->filter($filters)
                    ->where('status', TaskStatus::Completed)
                    ->whereBetween('updated_at', [$month, $month->copy()->endOfMonth()])
                    ->count();

                return [
                    'label' => $month->format('M'),
                    'count' => $count,
                ];
            })
            ->values()
            ->all();
    }
}
