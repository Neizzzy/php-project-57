<?php

namespace App\Http\Controllers;

use App\DTOs\TaskDTO;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService $taskService,
    ){
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        Gate::authorize('viewAny', Task::class);

        $tasks = $this->taskService->getAllPaginated();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Factory|View
    {
        Gate::authorize('create', Task::class);

        $users = $this->taskService->getUsers();
        $statuses = $this->taskService->getStatuses();
        $labels = $this->taskService->getLabels();

        return view('tasks.create', compact('users', 'statuses', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        Gate::authorize('create', Task::class);

        $taskDto = TaskDTO::fromArray($request->validated());
        $this->taskService->create($taskDto);

        flash(__('Task successfully created'))->success();
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): Factory|View
    {
        Gate::authorize('view', $task);

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task): Factory|View
    {
        Gate::authorize('update', $task);

        $users = $this->taskService->getUsers();
        $statuses = $this->taskService->getStatuses();
        $labels = $this->taskService->getLabels();

        return view('tasks.edit', compact('users', 'statuses', 'labels', 'task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Task $task): RedirectResponse
    {
        Gate::authorize('update', $task);

        $taskDto = TaskDTO::fromArray($request->validated());
        $this->taskService->update($taskDto, $task);

        flash(__('Task successfully updated'))->success();
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        Gate::authorize('delete', $task);

        $this->taskService->delete($task);

        flash(__('Task successfully deleted'))->success();
        return redirect()->route('tasks.index');
    }
}
