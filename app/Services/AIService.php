<?php

namespace App\Services;

use App\Enums\AiPriority;
use App\Enums\TaskPriority;
use App\Models\Task;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AIService
{
    public function buildPrompt(Task $task): string
    {
        $dueDate = $task->due_date?->toDateString() ?? 'none';

        return <<<PROMPT
            You are a task management assistant. Analyze the task and respond ONLY with valid JSON.

            Task title: {$task->title}
            Description: {$task->description}
            Status: {$task->status->value}
            Priority: {$task->priority->value}
            Due date: {$dueDate}

            Return JSON:
            {
              "ai_summary": "2-3 sentence actionable summary",
              "ai_priority": "low|medium|high"
            }
            PROMPT;
    }

    public function generateSummary(Task $task): array
    {
        if (config('services.ai.driver') === 'mock' || blank(config('services.gemini.api_key'))) {
            return $this->mockSummary($task);
        }

        try {
            return $this->callGemini($task);
        } catch (\Throwable $exception) {
            Log::warning('AI summary generation failed, using mock fallback.', [
                'task_id' => $task->id,
                'message' => $exception->getMessage(),
            ]);

            return $this->mockSummary($task);
        }
    }

    protected function callGemini(Task $task): array
    {
        try {
            $apiKey = config('services.gemini.api_key');
            if (empty($apiKey)) {
                throw new \RuntimeException('Gemini API key is not configured.');
            }

            $client = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->timeout(30);

            if (app()->environment('local')) {
                $client = $client->withoutVerifying();
            }

            $response = $client->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                'systemInstruction' => [
                    'parts' => [
                        ['text' => 'You return only valid JSON for task summaries.']
                    ]
                ],
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => $this->buildPrompt($task)]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.3,
                    'responseMimeType' => 'application/json',
                ],
            ])->throw()->json();

            $content = data_get($response, 'candidates.0.content.parts.0.text', '');
            $content = preg_replace('/^```(?:json)?\s*(.*?)\s*```$/s', '$1', trim($content));
            $parsed = json_decode(trim($content), true);

            if (!is_array($parsed) || !isset($parsed['ai_summary'], $parsed['ai_priority'])) {
                throw new \RuntimeException('Invalid AI JSON response.');
            }

            return [
                'ai_summary' => Str::limit((string) $parsed['ai_summary'], 1000),
                'ai_priority' => $this->normalizePriority((string) $parsed['ai_priority']),
            ];
        } catch (\Throwable $e) {
            return [
                'ai_summary' => 'AI Error: ' . $e->getMessage(),
                'ai_priority' => 'medium',
            ];
        }
    }

    protected function mockSummary(Task $task): array
    {
        $aiPriority = match ($task->priority) {
            TaskPriority::High => AiPriority::High,
            TaskPriority::Low => AiPriority::Low,
            default => AiPriority::Medium,
        };

        return [
            'ai_summary' => sprintf(
                'AI summary for "%s": focus on deliverables, owners, and due date %s. Recommended next steps are documented for the assignee.',
                $task->title,
                $task->due_date?->format('Y-m-d') ?? 'N/A'
            ),
            'ai_priority' => $aiPriority->value,
        ];
    }

    protected function normalizePriority(string $priority): string
    {
        $priority = strtolower(trim($priority));

        return in_array($priority, ['low', 'medium', 'high'], true) ? $priority : 'medium';
    }
}
