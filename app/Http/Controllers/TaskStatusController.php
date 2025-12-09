<?php

namespace App\Http\Controllers;

use App\DTOs\TaskStatusDTO;
use App\Http\Requests\TaskStatus\StoreRequest;
use App\Http\Requests\TaskStatus\UpdateRequest;
use App\Models\TaskStatus;
use App\Services\TaskStatusService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class TaskStatusController extends Controller
{
    public function __construct(
        private readonly TaskStatusService $taskStatusService
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        Gate::authorize('viewAny', TaskStatus::class);

        $statuses = $this->taskStatusService->getAllPaginated();
        return view('task-statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Factory|View
    {
        Gate::authorize('create', TaskStatus::class);

        return view('task-statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        Gate::authorize('create', TaskStatus::class);

        $taskStatusDto = TaskStatusDTO::fromArray($request->validated());
        $this->taskStatusService->create($taskStatusDto);

        flash(__('Status successfully created'))->success();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskStatus $taskStatus): Factory|View
    {
        Gate::authorize('update', $taskStatus);

        return view('task-statuses.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, TaskStatus $taskStatus): RedirectResponse
    {
        Gate::authorize('update', $taskStatus);

        $taskStatusDto = TaskStatusDTO::fromArray($request->validated());
        $this->taskStatusService->update($taskStatusDto, $taskStatus);

        flash(__('Status successfully updated'))->success();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $taskStatus): RedirectResponse
    {
        Gate::authorize('delete', $taskStatus);

        $this->taskStatusService->delete($taskStatus) ?
            flash(__('Status successfully deleted'))->success() :
            flash(__('Failed to delete status'))->error();

        return redirect()->route('task_statuses.index');
    }
}
