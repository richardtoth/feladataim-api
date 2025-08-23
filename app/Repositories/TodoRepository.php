<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTOs\TodoDTO;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;

class TodoRepository
{
    public function allForUser(int $userId): Collection
    {
        return Todo::where('user_id', $userId)->get();
    }

    public function create(TodoDTO $dto): Todo
    {
        return Todo::create($dto->toArray());
    }

    public function update(Todo $todo, TodoDTO $dto): Todo
    {
        return tap($todo)->update($dto->toArray());
    }

    public function delete(Todo $todo): bool
    {
        return $todo->delete();
    }
}