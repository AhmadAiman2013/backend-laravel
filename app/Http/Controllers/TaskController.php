<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Http\Resources\TaskResource;
use App\Models\Boards;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Card $card)
    {
        $tasks = $card->tasks()->latest()->get();

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Card $card)
    {
        $task = Task::create([
            ...$request->validate([
                'title' => 'required|string|max:100',
                'order' => 'required|integer',
                'completed' => 'required|boolean',
                'due_date' => 'required|date',
            ]),
            'card_id' => $card->id,
        ]);

        return new TaskResource($task);
    }


    /**
     * Display the specified resource.
     */
    public function show(Card $card, Task $task)
    {
        $task = $card->tasks()->findOrFail($task->id);
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Card $card, Task $task)
    {
        $task = $card->tasks()->findOrFail($task->id);
        $task->update(
            $request->validate([
                'title' => 'required|string|max:100',
                'order' => 'required|integer',
                'completed' => 'required|boolean',
                'due_date' => 'required|date',
            ])
        );

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card, Task $task)
    {
        $task = $card->tasks()->findOrFail($task->id);
        $task->delete();

        return response(status: 204);
    }
}
