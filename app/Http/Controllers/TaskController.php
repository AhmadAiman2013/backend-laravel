<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function recentTasks()
    {
        $tasks = Task::latest()->limit(5)->get();

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Card $card)
    {
        $maxOrder = $card->tasks()->max('order') ?? 0;
        $newOrder = $maxOrder + 1;
        $task = Task::create([
            ...$request->validate([
                'title' => 'required|string|max:100',
            ]),
            'order' => $newOrder,
            'card_id' => $card->id,
        ]);

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Task $task)
    {
        Gate::authorize('update', $task);

        $task->update(
            $request->validate([
                'title' => 'string|max:100',
                'completed' => 'boolean',
                'due_date' => 'date',
            ])
        );

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card, Task $task)
    {
        $board = $card->board;
        Gate::authorize('delete', [$board, $card, $task]);

        $task->delete();
        $card->tasks()->where('order', '>', $task->order)->decrement('order');

        return response(status: 204);
    }
}
