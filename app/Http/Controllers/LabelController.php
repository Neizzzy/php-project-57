<?php

namespace App\Http\Controllers;

use App\DTOs\LabelDTO;
use App\Http\Requests\Label\StoreRequest;
use App\Http\Requests\Label\UpdateRequest;
use App\Models\Label;
use App\Services\LabelService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class LabelController extends Controller
{
    public function __construct(
        private readonly LabelService $labelService,
    ){
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        Gate::authorize('viewAny', Label::class);

        $labels = $this->labelService->getAllPaginated();

        return view('labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Factory|View
    {
        Gate::authorize('create', Label::class);

        return view('labels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        Gate::authorize('create', Label::class);

        $labelDto = LabelDTO::fromArray($request->validated());
        $this->labelService->create($labelDto);

        flash(__('Label successfully created'))->success();
        return redirect()->route('labels.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Label $label): Factory|View
    {
        Gate::authorize('update', $label);

        return view('labels.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Label $label): RedirectResponse
    {
        Gate::authorize('update', $label);

        $labelDto = LabelDTO::fromArray($request->validated());
        $this->labelService->update($labelDto, $label);

        flash(__('Label successfully updated'))->success();
        return redirect()->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Label $label): RedirectResponse
    {
        Gate::authorize('delete', $label);

        $this->labelService->delete($label) ?
            flash(__('Label successfully deleted'))->success() :
            flash(__('Failed to delete label'))->error();

        return redirect()->route('labels.index');
    }
}
