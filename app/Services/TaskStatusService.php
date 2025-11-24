<?php

namespace App\Services;

use App\DTOs\TaskStatusDTO;
use App\Models\TaskStatus;
use Illuminate\Support\Collection;

class TaskStatusService
{
    public function getAll(): Collection
    {
        return TaskStatus::orderBy('id', 'ASC')->get();
    }

    public function create(TaskStatusDTO $taskStatusDto): void
    {
        auth()->user()->taskStatuses()->create($taskStatusDto->toArray());
    }

    public function update(TaskStatusDTO $taskStatusDto, TaskStatus $taskStatus): void
    {
        $taskStatus->update($taskStatusDto->toArray());
    }

    public function delete(TaskStatus $taskStatus): void
    {
        $taskStatus->delete();
    }
}
