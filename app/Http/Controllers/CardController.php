<?php

namespace App\Http\Controllers;

use App\Http\Resources\CardResource;
use App\Models\Boards;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Boards $board)
    {
        $card = $board->cards()->latest()->get();

        return CardResource::collection($card);
    }

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
     * Display the specified resource.
     */
    public function show(Boards $board,Card $card)
    {
        $card = $board->cards()->findOrFail($card->id);
        return new CardResource($card);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Boards $board, Card $card)
    {
        $card = $board->cards()->findOrFail($card->id);
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
        $card = $board->cards()->findOrFail($card->id);
        $card->delete();
        return response(status: 204);
    }
}
