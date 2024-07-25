<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Card;
use App\Models\Boards;
use App\Models\User;

uses(RefreshDatabase::class);

test('a card can be retrieved', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);
    $card = Card::factory()->create(['boards_id' => $board->id]);

    $retrievedCard = Card::find($card->id);

    $this->assertNotNull($retrievedCard);
    $this->assertEquals($card->id, $retrievedCard->id);
    $this->assertEquals($card->title, $retrievedCard->title);
    $this->assertEquals($card->boards_id, $retrievedCard->boards_id);
    $this->assertEquals($card->created_at, $retrievedCard->created_at);
    $this->assertEquals($card->updated_at, $retrievedCard->updated_at);
});

test('a card can be created', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);
    $card = Card::factory()->create(['boards_id' => $board->id]);

    $this->assertDatabaseHas('cards', [
        'id' => $card->id,
        'title' => $card->title,
        'boards_id' => $board->id,
        'order' => $card->order,
        'created_at' => $card->created_at,
        'updated_at' => $card->updated_at,
    ]);
});

test('a card can be updated', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);
    $card = Card::factory()->create(['boards_id' => $board->id]);

    $newTitle = 'New title';
    $card->title = $newTitle;
    $card->save();

    $this->assertDatabaseHas('cards', [
        'id' => $card->id,
        'title' => $newTitle,
        'boards_id' => $board->id,
        'order' => $card->order,
        'created_at' => $card->created_at,
        'updated_at' => $card->updated_at,
    ]);
});


test('a card can be deleted', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);
    $card = Card::factory()->create(['boards_id' => $board->id]);

    $card->delete();

    $this->assertDatabaseMissing('cards', [
        'id' => $card->id,
    ]);
});
