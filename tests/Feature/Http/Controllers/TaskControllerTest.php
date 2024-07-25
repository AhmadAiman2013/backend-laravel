<?php

use App\Models\Boards;
use App\Models\User;
use App\Models\Card;
use App\Models\Task;

test('can list tasks', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);
    $card = Card::factory()->create(['boards_id' => $board->id]);
    $tasks = Task::factory(3)->create(['card_id' => $card->id]);

    $response = $this->actingAs($user)->getJson("/api/cards/{$card->id}/tasks");
    $response->assertStatus(200);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'card_id', 'title', 'order', 'completed', 'due_date', 'created_at', 'updated_at'],
        ]
    ]);
});

test('can list a task', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);
    $card = Card::factory()->create(['boards_id' => $board->id]);
    $task = Task::factory()->create(['card_id' => $card->id]);

    $response = $this->actingAs($user)->getJson("/api/cards/{$card->id}/tasks/{$task->id}");
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => ['id', 'card_id', 'title', 'order', 'completed', 'due_date', 'created_at', 'updated_at'],
    ]);
});

test('can create a task', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);
    $card = Card::factory()->create(['boards_id' => $board->id]);

    $taskData = [
        'title' => 'My first task',
        'order' => 1,
        'completed' => false,
        'due_date' => now()->addDay()->toDateString(),
    ];

    $response = $this->actingAs($user)->postJson("/api/cards/{$card->id}/tasks", $taskData);
    $response->assertStatus(201);
    $response->assertJsonStructure([
        'data' => ['id', 'card_id', 'title', 'order', 'completed', 'due_date', 'created_at', 'updated_at'],
    ]);
    $response->assertJson([
        'data' => [
            'card_id' => $card->id,
            'title' => $taskData['title'],
            'order' => $taskData['order'],
            'completed' => $taskData['completed'],
            'due_date' => $taskData['due_date'],
        ]
    ]);
    $this->assertDatabaseHas('tasks', [
        'card_id' => $card->id,
        'title' => $taskData['title'],
        'order' => $taskData['order'],
        'completed' => $taskData['completed'],
        'due_date' => $taskData['due_date'],
    ]);
});

test('can update a task', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);
    $card = Card::factory()->create(['boards_id' => $board->id]);
    $task = Task::factory()->create(['card_id' => $card->id]);

    $newTitle = 'New title';
    $newOrder = 5;
    $response = $this->actingAs($user)->putJson("/api/cards/{$card->id}/tasks/{$task->id}", [
        'title' => $newTitle,
        'order' => $newOrder,
        'completed' => $task->completed,
        'due_date' => $task->due_date,
    ]);
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => ['id', 'card_id', 'title', 'order', 'completed', 'due_date', 'created_at', 'updated_at'],
    ]);
    $response->assertJson([
        'data' => [
            'id' => $task->id,
            'card_id' => $card->id,
            'title' => $newTitle,
            'order' => $newOrder,
            'completed' => $task->completed,
            'due_date' => $task->due_date,
        ]
    ]);
    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'card_id' => $card->id,
        'title' => $newTitle,
        'order' => $newOrder,
        'completed' => $task->completed,
        'due_date' => $task->due_date,
    ]);
});

test('can delete a task', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);
    $card = Card::factory()->create(['boards_id' => $board->id]);
    $task = Task::factory()->create(['card_id' => $card->id]);

    $response = $this->actingAs($user)->deleteJson("/api/cards/{$card->id}/tasks/{$task->id}");
    $response->assertStatus(204);
    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
    ]);
});
