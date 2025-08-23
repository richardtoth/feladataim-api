<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\TodoDTO;
use App\Models\Todo;
use App\Repositories\TodoRepository;
use Illuminate\Database\Eloquent\Collection;

class TodoService
{
    public function __construct(private TodoRepository $repository) {}

    public function allForUser(int $userId): Collection
    {
        return $this->repository->allForUser($userId);
    }

    public function create(TodoDTO $todoDTO): Todo
    {
        return $this->repository->create($todoDTO);
    }

    public function update(Todo $todo, TodoDTO $todoDTO): Todo
    {
        return $this->repository->update($todo, $todoDTO);
    }

    public function delete(Todo $todo): bool
    {
        return $this->repository->delete($todo);
    }
}