<?php

namespace App\Services;

class AIService
{
    public function generateSummary(Task $task): array
    {
        return [
            'ai_summary' => 'Short summary here',
            'ai_priority' => 'high'
        ];
    }
}