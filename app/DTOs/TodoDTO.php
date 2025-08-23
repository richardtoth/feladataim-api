<?php

declare(strict_types=1);

namespace App\DTOs;

use App\TodoRequestEnum;

class TodoDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly string $title,
        public readonly ?string $description = null,
        public readonly bool $isCompleted = false,
        public readonly ?string $dueDate = null,
    ) {
    }

    public static function buildFromRequest(array $data, int $userId): self
    {
        return new self(
            userId: $userId,
            title: $data[TodoRequestEnum::TITLE->value],
            description: $data[TodoRequestEnum::DESCRIPTION->value] ?? null,
            isCompleted: $data[TodoRequestEnum::IS_COMPLETED->value] ?? false,
            dueDate: $data[TodoRequestEnum::DUE_DATE->value] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            TodoRequestEnum::TITLE->value => $this->title,
            TodoRequestEnum::DESCRIPTION->value => $this->description,
            TodoRequestEnum::IS_COMPLETED->value => $this->isCompleted,
            TodoRequestEnum::DUE_DATE->value => $this->dueDate,
        ];
    }
}