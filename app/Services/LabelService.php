<?php

namespace App\Services;

use App\DTOs\LabelDTO;
use App\Models\Label;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;

class LabelService
{
    public function getAllPaginated($per = 15): LengthAwarePaginator
    {
        return Label::orderBy('id', 'ASC')->paginate($per);
    }

    public function create(LabelDTO $labelDto): void
    {
        Label::create($labelDto->toArray());
    }

    public function update(LabelDTO $labelDTO, Label $label): void
    {
        $label->update($labelDTO->toArray());
    }

    public function delete(Label $label): bool
    {
        if ($label->tasks()->exists()) {
            return false;
        }

        $label->delete();
        return true;
    }
}
