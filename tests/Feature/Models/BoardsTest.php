<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Boards;
use App\Models\User;

uses(RefreshDatabase::class);

test('a board can be retrieved', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);

    $retrievedBoard = Boards::find($board->id);

    $this->assertNotNull($retrievedBoard);
    $this->assertEquals($board->id, $retrievedBoard->id);
    $this->assertEquals($board->user_id, $retrievedBoard->user_id);
    $this->assertEquals($board->title, $retrievedBoard->title);
    $this->assertEquals($board->created_at, $retrievedBoard->created_at);
    $this->assertEquals($board->updated_at, $retrievedBoard->updated_at);
});

test('a board can be created', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);

    $this->assertDatabaseHas('boards', [
        'id' => $board->id,
        'user_id' => $user->id,
        'title' => $board->title,
        'created_at' => $board->created_at,
        'updated_at' => $board->updated_at,
    ]);
});

test('a board can be updated', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);

    $newTitle = 'New title';
    $board->title = $newTitle;
    $board->save();

    $this->assertDatabaseHas('boards', [
        'id' => $board->id,
        'user_id' => $user->id,
        'title' => $newTitle,
        'created_at' => $board->created_at,
        'updated_at' => $board->updated_at,
    ]);
});

test('a board can be deleted', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);

    $board->delete();

    $this->assertDatabaseMissing('boards', [
        'id' => $board->id,
    ]);
});
