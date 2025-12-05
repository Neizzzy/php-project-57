<?php

namespace App\Services;

use App\DTOs\TaskStatusDTO;
use App\Models\TaskStatus;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class TaskStatusService
{
    public function getAllPaginated($per = 15): LengthAwarePaginator
    {
        return TaskStatus::orderBy('id', 'ASC')->paginate($per);
    }

    public function create(TaskStatusDTO $taskStatusDto): void
    {
        TaskStatus::create($taskStatusDto->toArray());
    }

    public function update(TaskStatusDTO $taskStatusDto, TaskStatus $taskStatus): void
    {
        $taskStatus->update($taskStatusDto->toArray());
    }

    public function delete(TaskStatus $taskStatus): bool
    {
        if ($taskStatus->tasks()->exists()) {
            return false;
        }

        $taskStatus->delete();
        return true;
    }
}
