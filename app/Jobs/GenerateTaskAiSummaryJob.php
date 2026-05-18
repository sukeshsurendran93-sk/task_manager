<?php

namespace App\Jobs;

use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Services\AIService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateTaskAiSummaryJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $taskId) {}

    public function handle(AIService $aiService, TaskRepositoryInterface $taskRepository): void
    {
        $task = $taskRepository->find($this->taskId);

        if (! $task) {
            return;
        }

        $aiData = $aiService->generateSummary($task);
        $taskRepository->updateAi($this->taskId, $aiData);
    }
}
