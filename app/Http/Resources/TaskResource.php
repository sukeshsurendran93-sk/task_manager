<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            'priority' => $this->priority->value,
            'priority_label' => $this->priority->label(),
            'priority_display' => ucfirst($this->priority->value),
            'due_date' => $this->due_date?->format('Y-m-d'),
            'assigned_to' => $this->assigned_to,
            'assignee' => $this->whenLoaded('assignee', fn () => $this->assignee?->name),
            'created_by' => $this->created_by,
            'ai_summary' => $this->ai_summary,
            'ai_summary_short' => $this->ai_summary ? \Illuminate\Support\Str::limit($this->ai_summary, 120) : null,
            'ai_priority' => $this->ai_priority?->value,
            'ai_priority_label' => $this->ai_priority?->label(),
            'body' => $this->description,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
