<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_view_unassigned_task(): void
    {
        $user = User::factory()->create(['role' => UserRole::User]);
        $other = User::factory()->create();
        $task = Task::factory()->create(['assigned_to' => $other->id, 'created_by' => $other->id]);

        $this->actingAs($user)
            ->get(route('tasks.show', $task))
            ->assertForbidden();
    }

    public function test_admin_can_view_any_task(): void
    {
        $admin = User::factory()->create(['role' => UserRole::Admin]);
        $task = Task::factory()->create();

        $this->actingAs($admin)
            ->get(route('tasks.show', $task))
            ->assertOk();
    }
}
