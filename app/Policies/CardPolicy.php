<?php

namespace App\Policies;


use App\Models\Card;
use App\Models\User;


class CardPolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Card $card): bool
    {
        return $card->board->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Card $card): bool
    {

        return $card->board->user_id === $user->id;
    }

}
