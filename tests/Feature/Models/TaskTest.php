<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Card;
use App\Models\Boards;
use App\Models\User;
use App\Models\Task;

uses(RefreshDatabase::class);

test('a task can be retrieved', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);
    $card = Card::factory()->create(['boards_id' => $board->id]);
    $task = Task::factory()->create(['card_id' => $card->id]);

    $retrievedTask = Task::find($task->id);

    $this->assertNotNull($retrievedTask);
    $this->assertEquals($task->id, $retrievedTask->id);
    $this->assertEquals($task->card_id, $retrievedTask->card_id);
    $this->assertEquals($task->title, $retrievedTask->title);
    $this->assertEquals($task->order, $retrievedTask->order);
    $this->assertEquals($task->completed, $retrievedTask->completed);
    $this->assertEquals($task->due_date, $retrievedTask->due_date);
    $this->assertEquals($task->created_at, $retrievedTask->created_at);
    $this->assertEquals($task->updated_at, $retrievedTask->updated_at);
});

test('a task can be created', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);
    $card = Card::factory()->create(['boards_id' => $board->id]);
    $task = Task::factory()->create(['card_id' => $card->id]);

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'card_id' => $card->id,
        'title' => $task->title,
        'order' => $task->order,
        'completed' => $task->completed,
        'due_date' => $task->due_date,
        'created_at' => $task->created_at,
        'updated_at' => $task->updated_at,
    ]);
});

test('a task can be updated', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);
    $card = Card::factory()->create(['boards_id' => $board->id]);
    $task = Task::factory()->create(['card_id' => $card->id]);

    $newTitle = 'New title';
    $task->title = $newTitle;
    $task->save();

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'card_id' => $card->id,
        'title' => $newTitle,
        'order' => $task->order,
        'completed' => $task->completed,
        'due_date' => $task->due_date,
        'created_at' => $task->created_at,
        'updated_at' => $task->updated_at,
    ]);
});

test('a task can be deleted', function () {
    $user = User::factory()->create();
    $board = Boards::factory()->create(['user_id' => $user->id]);
    $card = Card::factory()->create(['boards_id' => $board->id]);
    $task = Task::factory()->create(['card_id' => $card->id]);

    $task->delete();

    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
    ]);
});
