<?php

namespace App\Services;

use App\Repositories\Contracts\TaskRepositoryInterface;

class TaskService
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository, AIService $aiService)
    {
        $this->taskRepository = $taskRepository;
        $this->aiService = $aiService;
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            $task = $this->taskRepository->create(array_merge($data, [
                'created_by' => auth()->id(),
            ]));

            $aiData = $this->aiService->generateSummary($task);
            $this->taskRepository->updateAi($task->id, $aiData);

            return $task;
        });
    }
}
