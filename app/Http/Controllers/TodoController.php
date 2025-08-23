<?php

namespace App\Http\Controllers;

use App\DTOs\TodoDTO;
use App\Http\Requests\Todo\StoreTodoRequest;
use App\Http\Requests\Todo\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use App\Services\TodoService;

class TodoController extends Controller
{
    public function __construct(
        private readonly TodoService $todoService
    ) {}

    public function index()
    {
        return TodoResource::collection($this->todoService->allForUser(auth()->user()->id));
    }

    public function store(StoreTodoRequest $request)
    {
        $todo = $this->todoService->create(TodoDTO::buildFromRequest($request->validated(), auth()->user()->id));

        return new TodoResource($todo);
    }

    public function show(Todo $todo)
    {
        return TodoResource::make($todo);
    }

    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $todo = $this->todoService->update($todo,
            TodoDTO::buildFromRequest($request->validated(), auth()->user()->id));

        return TodoResource::make($todo);
    }

    public function destroy(Todo $todo)
    {
        $this->todoService->delete($todo);

        return response()->noContent();
    }
}
