<?php

namespace App\DTOs;

class TaskDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description,
        public readonly int $status_id,
        public readonly ?int $assigned_to_id
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'],
            status_id: $data['status_id'],
            assigned_to_id: $data['assigned_to_id']
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'status_id' => $this->status_id,
            'assigned_to_id' => $this->assigned_to_id,
        ];
    }
}
