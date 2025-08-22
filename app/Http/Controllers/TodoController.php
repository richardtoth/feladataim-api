<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Auth::user()->todos;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $todo = Auth::user()->todos()->create($validated);

        return response()->json($todo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        return $todo;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'boolean',
            'due_date' => 'nullable|date',
        ]);

        $todo->update($validated);

        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response()->json(null, 204);
    }
}
