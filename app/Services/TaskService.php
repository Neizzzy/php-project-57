<?php

namespace App\Services;

use App\DTOs\TaskDTO;
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

    public function create(TaskDTO $taskDto): void
    {
        auth()->user()->tasks()->create($taskDto->toArray());
    }

    public function update(TaskDTO $taskDto, Task $task): void
    {
        $task->update($taskDto->toArray());
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }
}
