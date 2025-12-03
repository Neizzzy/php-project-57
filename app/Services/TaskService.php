<?php

namespace App\Services;

use App\DTOs\TaskDTO;
use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TaskService
{
    public function getAllPaginated($per = 15): LengthAwarePaginator
    {
        return Task::orderBy('id', 'ASC')->paginate($per);
    }

    public function getUsers(): Collection
    {
        return User::all();
    }

    public function getStatuses(): Collection
    {
        return TaskStatus::all();
    }

    public function getLabels(): Collection
    {
        return Label::all();
    }

    public function create(TaskDTO $taskDto): void
    {
        $task = auth()->user()->tasks()->create($taskDto->toArray());
        $task->labels()->attach($taskDto->labelIds);
    }

    public function update(TaskDTO $taskDto, Task $task): void
    {
        $task->update($taskDto->toArray());
        $task->labels()->sync($taskDto->labelIds);
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }
}
