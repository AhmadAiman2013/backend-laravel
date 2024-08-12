<?php

namespace App\Http\Controllers;

use App\Http\Resources\CardResource;
use App\Models\Boards;
use App\Models\Card;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class CardController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Boards $board)
    {
        $card = Card::create([
            ...$request->validate([
                'title' => 'required|string|max:50',
                'order' => 'required|integer',
            ]),
            'boards_id' => $board->id,
        ]);

        return new CardResource($card);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Boards $board, Card $card)
    {
        Gate::authorize('update', $card);

        $card->update(
            $request->validate([
                'title' => 'required|string|max:50',
                'order' => 'required|integer',
            ])
        );

        return new CardResource($card);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Boards $board, Card $card)
    {
        Gate::authorize('delete', $card);

        $card->delete();
        
        return response(status: 204);
    }
}
