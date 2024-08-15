<?php

namespace App\Policies;

use App\Models\Boards;
use App\Models\Card;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CardPolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Card $card): bool
    {
        return $user->id === $card->board->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Card $card): bool
    {

        // if ($card->boards_id == $board->id) {
        //     return $user->id === $board->user_id;
        // }
        // return false;
        return $card->board->user_id === $user->id;
    }

}
