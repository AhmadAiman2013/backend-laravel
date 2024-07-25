<?php

use App\Models\Boards;
use App\Models\User;
use App\Models\Card;

test('can lists cards', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);
    $cards = Card::factory(3)->create(['boards_id' => $board->id]);

    $response = $this->actingAs($user)->getJson("/api/boards/{$board->id}/cards");
    $response->assertStatus(200);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'boards_id','title', 'order','created_at', 'updated_at'],
        ]
    ]);
});

test('can list a card', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);
    $card = Card::factory()->create(['boards_id' => $board->id]);

    $response = $this->actingAs($user)->getJson("/api/boards/{$board->id}/cards/{$card->id}");
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => ['id', 'boards_id','title', 'order','created_at', 'updated_at'],
    ]);
});

test('can create a card', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);

    $cardData = [
        'title' => 'My first card',
        'order' => 1,
    ];

    $response = $this->actingAs($user)->postJson("/api/boards/{$board->id}/cards", $cardData);
    $response->assertStatus(201);
    $response->assertJsonStructure([
        'data' => ['id', 'boards_id','title', 'order','created_at', 'updated_at'],
    ]);
    $response->assertJson([
        'data' => [
            'boards_id' => $board->id,
            'title' => $cardData['title'],
            'order' => $cardData['order'],
        ]
    ]);
    $this->assertDatabaseHas('cards', [
        'boards_id' => $board->id,
        'title' => $cardData['title'],
        'order' => $cardData['order'],
    ]);
});

test('can update a card', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);
    $card = Card::factory()->create(['boards_id' => $board->id]);

    $newTitle = 'New title';
    $newOrder = 2;
    $response = $this->actingAs($user)->putJson("/api/boards/{$board->id}/cards/{$card->id}", ['title' => $newTitle, 'order' => $newOrder]);
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => ['id', 'boards_id','title', 'order','created_at', 'updated_at'],
    ]);
    $response->assertJson([
        'data' => [
            'boards_id' => $board->id,
            'title' => $newTitle,
            'order' => $newOrder,
        ]
    ]);
    $this->assertDatabaseHas('cards', [
        'id' => $card->id,
        'title' => $newTitle,
        'order' => $newOrder,
    ]);
});

test('can delete a card', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);
    $card = Card::factory()->create(['boards_id' => $board->id]);

    $response = $this->actingAs($user)->deleteJson("/api/boards/{$board->id}/cards/{$card->id}");
    $response->assertStatus(204);
    $this->assertDatabaseMissing('cards', [
        'id' => $card->id,
    ]);
});

