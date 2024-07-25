<?php

use App\Models\Boards;
use App\Models\User;


test('can lists boards', function () {
    $user = User::factory()->create();
    $boards = Boards::factory(3)->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->getJson('/api/boards');
    $response->assertStatus(200);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'user_id','title', 'created_at', 'updated_at'],
        ]
    ]);
});

test('can show a board', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);
    $response = $this->actingAs($user)->getJson("/api/boards/{$board->id}");
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => ['id', 'user_id','title', 'created_at', 'updated_at'],
    ]);
});

test('can create a board', function () {
    $user = User::factory()->create();

    $boardData = [
        'title' => 'My first board',
    ];

    $response = $this->actingAs($user)->postJson('/api/boards', $boardData);
    $response->assertStatus(201);
    $response->assertJsonStructure([
        'data' => ['id', 'user_id','title', 'created_at', 'updated_at'],
    ]);
    $response->assertJson([
        'data' => [
            'user_id' => $user->id,
            'title' => $boardData['title'],
        ]
    ]);
    $this->assertDatabaseHas('boards', [
        'user_id' => $user->id,
        'title' => $boardData['title'],
    ]);
});

test('can update a board', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);

    $newTitle = 'New title';
    $response = $this->actingAs($user)->putJson("/api/boards/{$board->id}", ['title' => $newTitle]);
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => ['id', 'user_id','title', 'created_at', 'updated_at'],
    ]);
    $response->assertJson([
        'data' => [
            'id' => $board->id,
            'user_id' => $user->id,
            'title' => $newTitle,
        ]
    ]);
    $this->assertDatabaseHas('boards', [
        'id' => $board->id,
        'user_id' => $user->id,
        'title' => $newTitle,
    ]);
});

test('can delete a board', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->deleteJson("/api/boards/{$board->id}");
    $response->assertStatus(204);
    $this->assertDatabaseMissing('boards', [
        'id' => $board->id,
    ]);
});
