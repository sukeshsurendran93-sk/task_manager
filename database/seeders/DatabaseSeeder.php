<?php

namespace Database\Seeders;

use App\Enums\AiPriority;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@taskmanager.test',
            'role' => UserRole::Admin,
        ]);

        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'user@taskmanager.test',
            'role' => UserRole::User,
        ]);

        $tasks = [
            [
                'title' => 'Launch New Marketing',
                'description' => 'Plan and structure multi-channel campaign for the new product launch. Include process email producers. AI Priority: High.',
                'status' => TaskStatus::InProgress,
                'priority' => TaskPriority::High,
                'due_date' => now()->addDays(14),
                'assigned_to' => $user->id,
                'created_by' => $admin->id,
                'ai_summary' => 'Comprehensive campaign execution strategy across channels, including asset planning.',
                'ai_priority' => AiPriority::High,
            ],
            [
                'title' => 'Develop API Campaign',
                'description' => 'API campaign coordination and documentation.',
                'status' => TaskStatus::InProgress,
                'priority' => TaskPriority::High,
                'due_date' => '2024-12-31',
                'assigned_to' => $user->id,
                'created_by' => $admin->id,
                'ai_priority' => AiPriority::Medium,
            ],
            [
                'title' => 'Develop API Endpoints',
                'description' => 'Build REST endpoints for task module.',
                'status' => TaskStatus::InProgress,
                'priority' => TaskPriority::High,
                'due_date' => '2024-12-31',
                'assigned_to' => $user->id,
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Refactor API Endpoints',
                'description' => 'Refactor controllers to repository pattern.',
                'status' => TaskStatus::Pending,
                'priority' => TaskPriority::Low,
                'due_date' => '2024-12-31',
                'assigned_to' => $user->id,
                'created_by' => $admin->id,
            ],
            [
                'title' => 'Prepare sprint retrospective',
                'description' => 'Collect metrics and team feedback.',
                'status' => TaskStatus::Completed,
                'priority' => TaskPriority::Medium,
                'due_date' => now()->subDays(3),
                'assigned_to' => $admin->id,
                'created_by' => $admin->id,
                'ai_summary' => 'Retrospective materials are ready for review.',
                'ai_priority' => AiPriority::Low,
            ],
            [
                'title' => 'Fix mobile navigation',
                'description' => 'Resolve overflow issues on smaller screens.',
                'status' => TaskStatus::Pending,
                'priority' => TaskPriority::Medium,
                'due_date' => now()->addWeek(),
                'assigned_to' => $user->id,
                'created_by' => $admin->id,
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
