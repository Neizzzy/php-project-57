<?php

namespace App\DTOs;

class LabelDTO
{
    public function __construct(
        public string $name,
        public ?string $description
    ){
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description']
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description
        ];
    }
}
