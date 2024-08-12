<?php

use App\Models\Boards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardsController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\TaskController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('boards', BoardsController::class);
    Route::apiResource('boards.cards', CardController::class)->except('index', 'show');
    Route::apiResource('cards.tasks', TaskController::class)->except('index', 'show');
    Route::get('/recent-tasks', [TaskController::class, 'recentTasks'])->name('tasks.recent');
});




