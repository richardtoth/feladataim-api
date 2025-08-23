<?php

use App\Models\Todo;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->otherUser = User::factory()->create();
});

it('can list own todos', function () {
    Todo::factory()->for($this->user)->count(3)->create();
    Todo::factory()->for($this->otherUser)->count(2)->create();

    $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/todos');

    $response->assertOk();
    $response->assertJsonCount(3, 'data'); // csak a saját todo-it látja
});

it('can view own todo', function () {
    $todo = Todo::factory()->for($this->user)->create();

    $response = $this->actingAs($this->user, 'sanctum')->getJson("/api/todos/{$todo->id}");

    $response->assertOk();
    $response->assertJsonFragment(['id' => $todo->id], 'data');
});

it('cannot view others todo', function () {
    $todo = Todo::factory()->for($this->otherUser)->create();

    $response = $this->actingAs($this->user, 'sanctum')->getJson("/api/todos/{$todo->id}");

    $response->assertForbidden(); // middleware / policy miatt
});

it('can create a todo', function () {
    $data = [
        'title' => 'New Todo',
        'description' => 'Test description',
    ];

    $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/todos', $data);

    $response->assertCreated();
    $this->assertDatabaseHas('todos', [
        'title' => 'New Todo',
        'user_id' => $this->user->id,
    ]);
});

it('can update own todo', function () {
    $todo = Todo::factory()->for($this->user)->create([
        'title' => 'Old title',
    ]);

    $response = $this->actingAs($this->user, 'sanctum')->putJson("/api/todos/{$todo->id}", [
        'title' => 'Updated title',
    ]);

    $response->assertOk();
    $this->assertDatabaseHas('todos', [
        'id' => $todo->id,
        'title' => 'Updated title',
    ]);
});

it('cannot update others todo', function () {
    $todo = Todo::factory()->for($this->otherUser)->create([
        'title' => 'Old title',
    ]);

    $response = $this->actingAs($this->user, 'sanctum')->putJson("/api/todos/{$todo->id}", [
        'title' => 'Updated title',
    ]);

    $response->assertForbidden();
});

it('can delete own todo', function () {
    $todo = Todo::factory()->for($this->user)->create();

    $response = $this->actingAs($this->user, 'sanctum')->deleteJson("/api/todos/{$todo->id}");

    $response->assertNoContent();
    $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
});

it('cannot delete others todo', function () {
    $todo = Todo::factory()->for($this->otherUser)->create();

    $response = $this->actingAs($this->user, 'sanctum')->deleteJson("/api/todos/{$todo->id}");

    $response->assertForbidden();
});
