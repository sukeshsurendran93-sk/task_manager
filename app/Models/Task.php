<?php

namespace App\Models;

use App\Enums\AiPriority;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description', 'status', 'priority', 'ai_priority', 'due_date', 'ai_summary', 'assigned_to', 'created_by'];

    protected function casts(): array
    {
        return [
            'status' => TaskStatus::class,
            'priority' => TaskPriority::class,
            'ai_priority' => AiPriority::class,
            'due_date' => 'date',
        ];
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function user(): BelongsTo
    {
        return $this->assignee();
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeFilter(Builder $query, array $filters = []): Builder
    {
        if (isset($filters['search'])) {
            $query = $query->where('title', 'like', "%{$filters['search']}%")
                ->orWhere('description', 'like', "%{$filters['search']}%");
        }

        if (isset($filters['status'])) {
            $query = $query->where('status', $filters['status']);
        }

        if (isset($filters['priority'])) {
            $query = $query->where('priority', $filters['priority']);
        }

        if (isset($filters['due_date'])) {
            $query = $query->whereDate('due_date', $filters['due_date']);
        }

        if (isset($filters['assigned_to'])) {
            $query = $query->where('assigned_to', $filters['assigned_to']);
        }

        if (isset($filters['created_by'])) {
            $query = $query->where('created_by', $filters['created_by']);
        }

        if (isset($filters['ai_priority'])) {
            $query = $query->where('ai_priority', $filters['ai_priority']);
        }

        return $query;
    }
}
