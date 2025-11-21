<?php

namespace App\Services;

use App\Models\TaskStatus;
use Illuminate\Support\Collection;

class TaskStatusService
{
    public function getAll(): Collection
    {
        return TaskStatus::orderBy('id', 'ASC')->get();
    }

    public function create(array $data): void
    {
        TaskStatus::create([
            'name' => $data['name'],
            'user_id' => auth()->id(),
        ]);
    }

    public function update(array $data, TaskStatus $taskStatus): void
    {
        $taskStatus->update($data);
    }

    public function delete(TaskStatus $taskStatus): void
    {
        $taskStatus->delete();
    }
}
