<?php

namespace App\Http\Controllers;

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
        private readonly TaskStatusService $service
    ){
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        Gate::authorize('viewAny', TaskStatus::class);

        $statuses = $this->service->getAll();
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

        $validated = $request->validated();

        $this->service->create($validated);

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

        $validated = $request->validated();

        $this->service->update($validated, $taskStatus);

        flash(__('Status successfully updated'))->success();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $taskStatus): RedirectResponse
    {
        Gate::authorize('delete', $taskStatus);

        $this->service->delete($taskStatus);

        flash(__('Status successfully deleted'))->success();
        return redirect()->route('task_statuses.index');
    }
}
