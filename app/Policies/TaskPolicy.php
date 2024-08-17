<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;



class TaskPolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->card->board->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {

        $result = $task->card->board->user_id === $user->id;

        return $result;

    }

}
